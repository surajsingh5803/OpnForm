# LP Forms staging on Render + Neon

This Blueprint creates only LP Forms resources and does **not** create a Render PostgreSQL database. Create a dedicated Neon project and provide its connection string directly in Render. Never commit secrets.

## Services defined in render.yaml

- `lp-forms-web`: public Nuxt SSR web service.
- `lp-forms-api`: private Laravel/PHP-FPM + Nginx service.
- `lp-forms-cache`: paid persistent Render Key Value service (Redis-compatible).

All services are initially configured with automatic deploys disabled. A Blueprint creation/planning step alone does not deploy or bill; review and approve the Render plan before provisioning any paid resources.

## Required secrets during first Blueprint approval

1. `lp-forms-api / DATABASE_URL`: the dedicated Neon PostgreSQL URL. Use the direct (unpooled) connection string for migrations, with `sslmode=require`.
2. `lp-forms-api / APP_KEY`: a Laravel application key in `base64:<32-byte-key>` format. Generate on a trusted terminal with `printf 'base64:%s\n' "$(openssl rand -base64 32)"`.
3. `lp-forms-api / APP_URL` is configured to `https://lp-forms-web.onrender.com` in the Blueprint. Update it to the verified custom domain only when domain setup is complete.

Render automatically generates `FRONT_API_SECRET` and `JWT_SECRET`. The UI receives the shared API secret through a Blueprint cross-service reference; the database URL does not belong in the Nuxt frontend.

## Design considerations

- Render **private services**, workers, and persistent Key Value generally require paid plans. This YAML requests paid resources; do not approve if the cost is not acceptable.
- `QUEUE_CONNECTION=sync` is a staging compromise. Before production, add a separate worker and scheduler and enable an asynchronous queue.
- `FILESYSTEM_DRIVER=local` has **ephemeral storage** on this Blueprint. Do not accept real customer uploads until object storage is wired with credentials and tested.
- `MAIL_MAILER=log` does not send email. Configure a legitimate email provider, verified sender and retries before using notifications or password recovery.
- Keep `JWT_SKIP_IP_UA_VALIDATION=false`, Laravel debug off, and secrets out of GitHub.
- Use the correct origin, test HTTPS and redirects, then exercise sign-up, sign-in, form creation/publishing, submissions, exports, file uploads (after object storage), and email.
- This proxy design keeps browser traffic on a single domain: `/api/*` and selected Laravel paths forward through Nuxt's Nitro fallback handlers to the private API. The API sees the path after the `/api` prefix has been removed, matching upstream Nginx behaviour.
- The API startup runs upstream Laravel migrations. An invalid Neon URL or missing APP_KEY will block service startup.

## Required follow-up after provisioning

1. Verify Render's build and runtime logs, and ensure `/healthz` and `/login` respond.
2. Confirm migrations against the intended Neon project.
3. Set custom DNS and TLS for `forms.lazyplex.com` (if chosen) then update `APP_URL` to that exact URL.
4. Add persistent object storage, SMTP, backup/restore tests, queue worker/scheduler, abuse controls and monitoring before a production launch.
5. Observe the AGPL-3.0 licensing and source-availability requirements for modified network deployments.

The original `docker-compose.yml` remains available for local Docker development; this Blueprint does not rely on it.
