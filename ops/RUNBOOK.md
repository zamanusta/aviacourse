# AviaCourse → Coolify migration runbook

## What the export actually contains (verified from your two files)

| | |
|---|---|
| Site URL | `https://www.aviacourse.com` (siteurl **and** home) |
| WordPress | 7.1, single site (no multisite) |
| DB | `bizjetco_wp388`, prefix **`wpct_`**, utf8mb4_unicode_520_ci, MariaDB 10.11 |
| Engines | **106 MyISAM** tables + 10 InnoDB → converted to InnoDB during import |
| Stack | WooCommerce 11.0.1, Tutor LMS + Tutor Pro, Elementor, theme `eduhap` / `eduhap-child` |
| Payments | Stripe + iyzico gateways |
| Source host | cPanel + **LiteSpeed** (`litespeed-cache` plugin, `php.ini`/`.user.ini`) |
| Zip layout | everything under `public_html/` — 548 MB zip, 48 571 entries |
| Junk in zip | `academy/` = a bare 98 MB `.git` and nothing else; plus `upgrade-temp-backup/`, `litespeed/`, `error_log`, `.tmb` — all excluded by the loader |

**The domain does not change → no `search-replace` is needed.** That is what makes this short.

---

## Shortest path — 4 steps

### 1. Copy the two files to the Coolify host
```bash
ssh root@COOLIFY_HOST 'mkdir -p /root/aviacourse'
scp "C:\Users\zaman\Desktop\aviacourseWP.zip" "C:\Users\zaman\Desktop\bizjetco_wp388.sql" root@COOLIFY_HOST:/root/aviacourse/
```
(~570 MB — run it from a stable connection, or `rsync -P` so it can resume.)

### 2. Create the stack in Coolify
* **New Resource → Docker Compose (Empty)**
* Paste `docker-compose.yaml` from this folder.
* Open the `wordpress` service → **Domains** → set `https://www.aviacourse.com`.
  *(Leave TLS to Coolify/Traefik. If DNS is not switched yet, use a temporary
  domain such as `new.aviacourse.com` here and change it back at cutover.)*
* **Deploy.** Wait until both containers are healthy. The site will 500/blank — expected, it is empty.

### 3. Load files + database
```bash
ssh root@COOLIFY_HOST
apt-get update && apt-get install -y unzip     # only if missing
bash /root/aviacourse/load-aviacourse.sh
```
It will: unpack the zip (minus junk) → point `wp-config.php` at the container's DB env vars →
insert the reverse-proxy HTTPS fix → wipe & refill `/var/www/html` → drop/import the dump →
convert MyISAM → InnoDB → install wp-cli → deactivate `litespeed-cache` → flush rewrites.

### 4. Verify, then switch DNS
```bash
curl -sI --resolve www.aviacourse.com:443:COOLIFY_HOST_IP https://www.aviacourse.com/ | head -n1
curl -sI --resolve www.aviacourse.com:443:COOLIFY_HOST_IP https://www.aviacourse.com/courses/icao-sms/ | head -n1
```
Both must be `200`. Then point the `A` record for `aviacourse.com` + `www` at the Coolify host.

---

## Things that will bite you if skipped

1. **Reverse-proxy HTTPS.** Traefik terminates TLS, so PHP sees plain HTTP and WordPress
   redirect-loops. The loader adds the `HTTP_X_FORWARDED_PROTO` block to `wp-config.php`.
   This is the single most common Coolify+WordPress failure.
2. **LiteSpeed.** The old host was LiteSpeed; `litespeed-cache` is deactivated and its
   `advanced-cache.php` / `object-cache.php` drop-ins are deleted. The `.htaccess`
   LSCACHE blocks are empty and harmless.
3. **PHP limits.** The old `php.ini`/`.user.ini` are cPanel artefacts and are **ignored** by
   mod_php in the container — the compose `command:` re-applies them (512M memory,
   256M uploads, 5000 input vars). Tutor LMS course uploads need this.
4. **`AllowOverride All`** is set explicitly in the compose `command:` so `.htaccess`
   permalinks and the Tutor hotlink-protection rules keep working.
5. **MyISAM.** 106 tables. Converted to InnoDB so WooCommerce order writes are transactional.

## Cutover for a live WooCommerce shop

Your dump is from **07 Sep 2026 01:13**. Any order placed on the old server after that
timestamp is not in it. So:

1. Do steps 1–3 now with the current dump and test everything.
2. At cutover: put the old site in maintenance mode, take a **fresh** dump, re-run
   *only* the DB part (`SQL=/root/aviacourse/fresh.sql bash load-aviacourse.sh` — it will
   also re-copy files, which is harmless), then flip DNS.
3. Lower the DNS TTL to 300s a day beforehand.
4. Keep the old server reachable for ~48h, but with writes disabled, so nothing splits.

## After cutover

- [ ] Log in to `/wp-admin`, check Tutor LMS courses and a WooCommerce test order.
- [ ] Stripe + iyzico webhook URLs — same domain, so they should keep working; confirm in each dashboard.
- [ ] Mailgun still sends (it is API/SMTP-based, unaffected by the move).
- [ ] Google Site Kit / Analytics reconnect if it complains about the site URL.
- [ ] **Recommended:** real cron instead of WP-Cron. Add `define( 'DISABLE_WP_CRON', true );`
      to `wp-config.php` and a Coolify **Scheduled Task** on the `wordpress` service:
      `php /var/www/html/wp-cron.php` every 5 minutes. Action Scheduler (WooCommerce)
      is much healthier this way.
- [ ] Set up Coolify backups on the `mariadb` service, plus a volume backup for `wp-html`.
