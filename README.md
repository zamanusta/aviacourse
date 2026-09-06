# aviacourse

`www.aviacourse.com` — WordPress 7.1 + WooCommerce + Tutor LMS on Coolify
(`infra.entropol.com`, project **LMS**).

**Push to `main` → Coolify builds the Dockerfile → the site redeploys.**

## What lives where

| | where | why |
|---|---|---|
| WordPress core | `wordpress:7.1-php8.3-apache` base image | pinned; the DB is at `db_version 61833` |
| **theme** (`eduhap`, `eduhap-child`, …) | **this repo** → baked into the image | so a commit is a deploy |
| plugins, languages | Docker volume | managed from wp-admin as usual; survives redeploys |
| `uploads`, `fonts` | Docker volume | user media, not code |
| database | Coolify MariaDB resource | gets Coolify's scheduled backups |
| secrets (salts, DB password) | Coolify environment variables | never in git |

Only the theme is versioned here. Plugins stay under WordPress's own control, so
`Updates → Update Now` in wp-admin keeps working and the result persists.

## Day-to-day

**Theme change** — edit, commit, push. Coolify rebuilds and redeploys:

```bash
git add wp-content/themes/eduhap-child && git commit -m "footer: fix contact link" && git push
```

**Plugin update** — wp-admin, exactly as before. Nothing to commit.

**WordPress core update** — bump the `FROM` tag in the `Dockerfile`, push, and let
WP run its database upgrade on first load. `WP_AUTO_UPDATE_CORE` is off so core
never drifts from the image.

**wp-cli** — from the Coolify terminal on the `aviacourse` app:

```bash
wp --path=/var/www/html plugin list --update=available
```

## Environment variables (set in Coolify, not here)

```
WORDPRESS_DB_HOST      <mariadb-container>:3306
WORDPRESS_DB_NAME      aviacourse
WORDPRESS_DB_USER      aviacourse
WORDPRESS_DB_PASSWORD  <from the Coolify MariaDB resource>
WORDPRESS_AUTH_KEY     … 8 salts, carried over from the old host
```

Optional: `WORDPRESS_DEBUG`, `WORDPRESS_HOME` (staging only),
`WORDPRESS_DISABLE_WP_CRON`.

## First-time setup

See [`ops/RUNBOOK.md`](ops/RUNBOOK.md). Deploy once, then run
[`ops/seed-server.sh`](ops/seed-server.sh) on the host to load the database and
`wp-content/{plugins,languages,uploads,fonts}` from the cPanel export.

## Carried over from the old host

- Table prefix is **`wpct_`**, not `wp_`.
- Old server was cPanel + LiteSpeed. `litespeed-cache` is skipped during seeding;
  the empty `LSCACHE` blocks left in `.htaccess` are inert.
- The old `php.ini` / `.user.ini` are gone — mod_php ignores them. Those limits
  are set in the `Dockerfile`.
- 106 of 116 tables were MyISAM; seeding converts them to InnoDB.
