# Deployment checklist — Mounts Edge Regency

Written alongside the performance work in `PERFORMANCE-AUDIT.md`. The steps
under "Performance-critical" are the ones that keep that work from silently
reverting in production.

---

## 1. Environment

The repo's `.env` is a **development** file (`APP_ENV=local`, `APP_DEBUG=true`)
and should stay that way — these values apply to the server's own `.env`, which
is gitignored and never deployed from here.

```dotenv
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
APP_URL=https://your-real-domain
```

`APP_DEBUG=true` in production is both a performance cost (the full error
handler, query and exception collection, several optimisations skipped) and a
disclosure risk — Laravel's error page prints file paths, environment values,
and database structure to anyone who triggers a 500.

## 2. Build and cache

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

`storage:link` matters more than usual here: every image is served through
`public/storage`, and the `page-hero` and gallery components probe the
filesystem for srcset variants. Without the symlink the site still renders, but
silently drops to unoptimised single-source images.

Re-run the three `:cache` commands after **every** deploy — a cached config that
predates an `.env` change is a confusing class of bug. To clear them:
`php artisan optimize:clear`.

## 3. Performance-critical

### Images are not in git

`storage/app/public/.gitignore` is `*`, so **no image is tracked**. A `git push`
deploys none of them. Options, in order of preference:

1. **Sync the directory** — `rsync -av storage/app/public/ user@host:/path/storage/app/public/`
2. **Optimise on the server** — copy the images up unprocessed, then run:

   ```bash
   php artisan images:optimize
   ```

   It resizes to the per-folder caps, re-encodes, writes the srcset variants,
   and generates the `.webp` siblings.
   It is safe to re-run: a manifest at `storage/app/image-optimizer.json` records
   what it has already processed, so a second run is a genuine no-op rather than
   a slow quality leak from repeated re-encoding. `--dry-run` reports without
   writing; `--force` ignores the manifest and reprocesses everything.

### Verify the cache headers actually apply

`public/.htaccess` sets a one-year cache on images and Vite assets. This is
**Apache-only** and cannot be tested locally, because `php artisan serve` uses
PHP's built-in server, which ignores `.htaccess` entirely.

```bash
curl -I https://your-domain/storage/home/hero/pool4.jpg
```

Expect `Cache-Control: public, max-age=31536000`. If it is missing:

- Confirm `mod_expires`, `mod_headers`, and `mod_deflate` are enabled. Every
  block is `IfModule`-guarded, so missing modules fail **silently** rather than
  erroring — an untested deploy looks fine and caches nothing.
- Confirm `AllowOverride All` for the vhost, or `.htaccess` is ignored outright.
- **On nginx these rules do nothing at all** and need an equivalent `location`
  block.

### Replacing an image

Filenames are not content-hashed, so a replaced photo keeps its URL and browsers
hold the old one for up to a year. Either give the new file a different name, or
bump a `?v=2` on its references. Admin uploads are unaffected — Laravel assigns
each one a fresh random name.

---

## 4. After deploying

- Load the home page and confirm the hero carousel advances through all six
  slides (backgrounds load on demand, so a broken path shows as a blank slide).
- Scroll the home page and `/gallery` once to confirm lazy images appear.
- Upload one image through the admin gallery and confirm it comes back resized,
  correctly oriented, and with `-400w`/`-800w` variants and `.webp` siblings
  beside it.
- Confirm WebP is actually being served: open DevTools > Network on the home page
  and check the hero background and gallery tiles come down as `.webp`. Files
  where WebP saved too little are served as JPEG by design, so a mix is correct.
- `curl -I` an image as above.

## 5. Known-good baseline

Initial image bytes per page, as measured on 2026-08-26:

| Page | Initial load |
|---|---|
| Home | ~575 KB |
| `/experiences` | ~342 KB |
| `/dining` | ~254 KB |
| `/weddings` | ~252 KB |
| `/luxury-stay` | ~201 KB |
| `/gallery` | ~166 KB |
| `/contact` | ~203 KB |

JS bundle 47.8 KB, CSS 66.5 KB. If a page drifts well above these, something has
regressed — most likely an image added without `loading="lazy"`, or one uploaded
outside the admin (which bypasses `ImageOptimizer`).
