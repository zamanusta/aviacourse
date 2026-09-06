#!/usr/bin/env bash
# One-time data load for the AviaCourse Coolify deployment.
#
# The image carries WordPress core, the theme and the config. This script loads
# the four things that deliberately are not in git, straight from the cPanel
# export: the database, plugins, translations and uploads.
#
# Run on the Coolify host, as root, after the first successful deploy.
#
#   DB_CT=<mariadb container> \
#   ZIP=/root/aviacourse/aviacourseWP.zip \
#   SQL=/root/aviacourse/bizjetco_wp388.sql \
#   bash seed-server.sh
#
# Container names:  docker ps --format '{{.Names}}'

set -Eeuo pipefail

ZIP="${ZIP:-/root/aviacourse/aviacourseWP.zip}"
SQL="${SQL:-/root/aviacourse/bizjetco_wp388.sql}"
STAGE="${STAGE:-/root/aviacourse/stage}"
say() { printf '\n\033[1;36m==> %s\033[0m\n' "$*"; }
die() { printf '\n\033[1;31mERROR: %s\033[0m\n' "$*" >&2; exit 1; }

[ -f "$ZIP" ] || die "zip not found: $ZIP"
[ -f "$SQL" ] || die "sql not found: $SQL"
command -v unzip >/dev/null || die "unzip missing. Run: apt-get update && apt-get install -y unzip"

WP_CT="${WP_CT:-$(docker ps --filter 'label=coolify.resourceName=aviacourse' --format '{{.Names}}' | head -1)}"
[ -n "$WP_CT" ] || die "WordPress container not found. Pass WP_CT=<name>  (docker ps)"
[ -n "${DB_CT:-}" ] || die "Pass DB_CT=<mariadb container name>  (docker ps | grep mariadb)"

DB_NAME=$(docker exec "$WP_CT" printenv WORDPRESS_DB_NAME)
DB_USER=$(docker exec "$WP_CT" printenv WORDPRESS_DB_USER)
DB_PW=$(docker exec   "$WP_CT" printenv WORDPRESS_DB_PASSWORD)
mysql() { docker exec -i -e MYSQL_PWD="$DB_PW" "$DB_CT" mariadb --default-character-set=utf8mb4 -u"$DB_USER" "$@"; }
wp()    { docker exec -u www-data -e HOME=/tmp "$WP_CT" wp --path=/var/www/html "$@"; }

say "Target"
echo "  wordpress : $WP_CT"
echo "  mariadb   : $DB_CT  (db: $DB_NAME)"
echo
if [ "${SKIP_DB:-0}" = "1" ]; then echo "  SKIP_DB=1: the database is left alone."; else echo "  This DROPS every table in '$DB_NAME'."; fi
echo "  Overwrites wp-content/"
echo "  {plugins,languages,uploads,fonts} on the volume."
if [ "${FORCE:-0}" != "1" ]; then
  read -r -p "  Type 'yes' to continue: " ok
  [ "$ok" = "yes" ] || die "aborted"
fi

# ---------------------------------------------------------------- 1. database
if [ "${SKIP_DB:-0}" = "1" ]; then
say "SKIP_DB=1 - leaving the database untouched"
else
say "Dropping existing tables in $DB_NAME"
mysql -N -B -e "SELECT CONCAT('DROP TABLE IF EXISTS \`',table_name,'\`;')
  FROM information_schema.tables WHERE table_schema='$DB_NAME';" > /tmp/drop-tables.sql
if [ -s /tmp/drop-tables.sql ]; then
  { echo "SET FOREIGN_KEY_CHECKS=0;"; cat /tmp/drop-tables.sql; } | mysql "$DB_NAME"
fi

say "Importing $(du -h "$SQL" | cut -f1) dump (a few minutes)"
mysql "$DB_NAME" < "$SQL"
echo "  tables: $(mysql -N -B -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$DB_NAME';")"

say "Converting MyISAM tables to InnoDB"
mysql -N -B -e "SELECT CONCAT('ALTER TABLE \`',table_name,'\` ENGINE=InnoDB;')
  FROM information_schema.tables WHERE table_schema='$DB_NAME' AND engine='MyISAM';" > /tmp/to-innodb.sql
mysql --force "$DB_NAME" < /tmp/to-innodb.sql || true
echo "  MyISAM left: $(mysql -N -B -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$DB_NAME' AND engine='MyISAM';")"
fi

# ------------------------------------------------------------- 2. wp-content
say "Unpacking plugins, languages, uploads and fonts (~660 MB)"
rm -rf "$STAGE"; mkdir -p "$STAGE"
unzip -q "$ZIP" \
  'public_html/wp-content/plugins/*' \
  'public_html/wp-content/languages/*' \
  'public_html/wp-content/uploads/*' \
  'public_html/wp-content/fonts/*' \
  -d "$STAGE" \
  -x 'public_html/wp-content/uploads/*/cache/*' \
     'public_html/wp-content/plugins/litespeed-cache/*'
SRC="$STAGE/public_html/wp-content"
[ -d "$SRC/plugins" ] || die "plugins not found in the zip"

say "Copying into the volume"
for d in plugins languages uploads fonts; do
  [ -d "$SRC/$d" ] || { echo "  $d: not in export, skipped"; continue; }
  # These paths are Docker volume mountpoints. "rm -rf <mountpoint>" empties it
  # and then fails with EBUSY on the mountpoint itself, which aborts under set -e.
  # Delete the contents instead.
  docker exec "$WP_CT" bash -c "mkdir -p /var/www/html/wp-content/$d && find /var/www/html/wp-content/$d -mindepth 1 -delete"
  docker cp "$SRC/$d/." "$WP_CT:/var/www/html/wp-content/$d/"
  echo "  $d: $(du -sh "$SRC/$d" | cut -f1)"
done
docker exec "$WP_CT" chown -R www-data:www-data /var/www/html/wp-content

say "Verifying the volumes"
for d in plugins languages uploads fonts; do
  n=$(docker exec "$WP_CT" bash -c "ls -1 /var/www/html/wp-content/$d 2>/dev/null | wc -l")
  printf '  %-10s %s entries
' "$d" "$n"
  if [ "$d" = "plugins" ] && [ "$n" -lt 10 ]; then die "plugins volume looks empty - the copy did not land"; fi
  if [ "$d" = "uploads" ] && [ "$n" -lt 1 ];  then die "uploads volume is empty - the copy did not land"; fi
done

# -------------------------------------------------------------- 3. tidy WP up
say "Post-import"
echo "  core    : $(wp core version)"
echo "  siteurl : $(wp option get siteurl)"
echo "  theme   : $(wp option get stylesheet)"
# litespeed-cache was excluded above: that cache layer does not exist here.
wp plugin deactivate litespeed-cache 2>/dev/null || echo "  (litespeed-cache not installed - good)"
wp rewrite flush --hard || true
wp cache flush || true
wp plugin list --status=active --field=name | tr '\n' ' '; echo

say "DONE - verify before DNS:"
echo "  curl -sI --resolve www.aviacourse.com:443:<host-ip> https://www.aviacourse.com/ | head -n1"
