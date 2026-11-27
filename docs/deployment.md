# Deployment Instructions

**How to make a script executable as part of Git**

```bash
git update-index --chmod=+x ./.scripts/deploy.sh
```

## Server requirement: Inertia SSR server

Pages built with Inertia + React (see `docs/adr/0002-inertia-react-front-end.md`) are server-side rendered by a
Node.js process. Production must run it alongside PHP:

- **Node.js 22 or newer** on the server (the project pins Node 26.13.1).
- **Build both bundles** on every deploy: `npm run build` runs `vp build && vp build --ssr`, producing
  `public/build/` (browser assets) and `bootstrap/ssr/inertia.js` (the SSR bundle). `.scripts/deploy.sh` already runs
  `npm install && npm run build`.
- **Run `php artisan inertia:start-ssr` as a supervised background process** (for example a Supervisor program),
  started from the project directory, so it restarts if it exits. It listens on port 13714.
- **Restart it after each deploy** so it loads the new bundle: run `php artisan inertia:stop-ssr` after `npm run build`;
  the supervisor starts it again.
- Laravel reaches it at `INERTIA_SSR_URL`, which defaults to `http://127.0.0.1:13714` (the SSR server on the same
  host). Set it in `.env` only if the SSR server runs elsewhere. `INERTIA_SSR_TIMEOUT` (seconds, default 2) bounds how
  long a request waits for it.

Example Supervisor program:

```ini
[program:weintegral-inertia-ssr]
command=php artisan inertia:start-ssr
directory=/var/www/weintegral-website
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/log/weintegral-inertia-ssr.log
```

If the SSR server is down or slow, pages still work: Laravel falls back to client-side rendering, so visitors get the
page once JavaScript loads, but search engines and first paint lose the server-rendered HTML. Check it with
`php artisan inertia:check-ssr`.

## Local development

Locally the SSR server runs in the `we-scheduler` container as the `inertia-ssr` Supervisor program (see
`docker/supervisor.conf`), and `docker/.docker.env` points the web server at `http://we-scheduler:13714`. The program
waits until `npm run build` has produced the SSR bundle. After rebuilding, restart it so it serves the new bundle:

```bash
docker compose exec we-scheduler php artisan inertia:stop-ssr
```
