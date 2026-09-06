# AviaCourse - www.aviacourse.com on Coolify.
#
#   core       -> official image, pinned to the version the database expects
#   themes     -> this repo, baked into the image: a git push is a deploy
#   plugins,   -> persistent volumes, managed from wp-admin as usual and
#   languages,    untouched by redeploys
#   uploads,
#   fonts
#
# Pinned deliberately: the database is at db_version 61833 (WP 7.1). To move
# WordPress, bump this tag and let WP run its upgrade on first load.
FROM wordpress:7.1-php8.3-apache

# --- Apache -----------------------------------------------------------------
# Debian's default vhost forbids .htaccess overrides; this site needs them for
# permalinks and for Tutor LMS's hotlink-protection rules.
RUN set -eux; \
    { \
      echo '<Directory /var/www/html>'; \
      echo '  Options FollowSymLinks'; \
      echo '  AllowOverride All'; \
      echo '  Require all granted'; \
      echo '</Directory>'; \
    } > /etc/apache2/conf-available/zz-aviacourse.conf; \
    a2enconf zz-aviacourse; \
    a2enmod rewrite headers expires

# --- PHP --------------------------------------------------------------------
# Replaces the old cPanel php.ini / .user.ini, which mod_php ignores entirely.
# Tutor LMS course material uploads need the 256M ceiling.
RUN set -eux; \
    { \
      echo 'memory_limit = 512M'; \
      echo 'upload_max_filesize = 256M'; \
      echo 'post_max_size = 256M'; \
      echo 'max_execution_time = 300'; \
      echo 'max_input_time = 300'; \
      echo 'max_input_vars = 5000'; \
      echo 'display_errors = Off'; \
    } > /usr/local/etc/php/conf.d/zz-aviacourse.ini; \
    { \
      echo 'opcache.enable = 1'; \
      echo 'opcache.memory_consumption = 256'; \
      echo 'opcache.interned_strings_buffer = 16'; \
      echo 'opcache.max_accelerated_files = 50000'; \
      echo 'opcache.revalidate_freq = 60'; \
    } > /usr/local/etc/php/conf.d/zz-opcache.ini
# 50000 rather than the image default of 4000: WooCommerce, Elementor and
# Tutor Pro together ship roughly 35k PHP files.

# --- theme (the only site code this repo owns) ------------------------------
RUN rm -rf /var/www/html/wp-content/themes
COPY --chown=www-data:www-data wp-content/themes/ /var/www/html/wp-content/themes/
COPY --chown=www-data:www-data wp-config.php      /var/www/html/wp-config.php
COPY --chown=www-data:www-data .htaccess          /var/www/html/.htaccess

# --- volume mount points ----------------------------------------------------
# Created empty and owned by www-data so a fresh Docker volume inherits the
# right ownership. ops/seed-server.sh fills them once, from the cPanel export.
RUN set -eux; \
    rm -rf /var/www/html/wp-content/plugins; \
    mkdir -p /var/www/html/wp-content/plugins \
             /var/www/html/wp-content/languages \
             /var/www/html/wp-content/uploads \
             /var/www/html/wp-content/fonts \
             /var/www/html/wp-content/upgrade; \
    chown -R www-data:www-data /var/www/html/wp-content

# --- wp-cli, for maintenance from the Coolify terminal ----------------------
ADD https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar /usr/local/bin/wp
RUN chmod +x /usr/local/bin/wp

HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=5 \
  CMD php -r 'exit(@fsockopen("127.0.0.1", 80) ? 0 : 1);'

# CMD/ENTRYPOINT inherited. The image's entrypoint finds core and wp-config.php
# already in place and leaves both alone.
