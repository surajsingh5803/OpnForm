# LP Forms — Phase 1 foundation

This fork remains based on [OpnForm](https://github.com/OpnForm/OpnForm) and retains its original licence and notices. LP Forms is the proposed brand for the Lazy Plex self-hosted deployment; this folder documents the fork-specific configuration without modifying upstream deployment scripts.

## Verified architecture

- Nuxt 4 frontend in `client/`; Laravel 12 API in `api/`.
- PostgreSQL for application data, Redis for queue/cache; independent Laravel worker and scheduler.
- Nginx ingress currently terminates port 80; configure HTTPS at a trusted reverse proxy before exposing the service.
- Form files currently use a shared container volume in the default Compose stack; production deployment needs persistent external storage or a backed-up persistent volume.
- Existing upstream GitHub Actions provide application CI/security checks. The LP Forms foundation workflow adds quick browser-title regression coverage.

## Local source-built deployment (not production-ready)

Prerequisites: Docker Engine and Compose v2, and adequate build memory. Run from the repository root.

1. Set a **unique non-default** `DB_PASSWORD` in your shell or a private root `.env` file. Do **not** commit this value.
2. Generate the app/client configuration files and application secrets:

   ```sh
   bash scripts/setup-env.sh --docker --public-url http://localhost
   ```

3. Ensure `api/.env` contains `APP_NAME="LP Forms"`, `APP_DEBUG=false`, and valid `APP_KEY` / `JWT_SECRET`. Ensure `client/.env` contains `NUXT_PUBLIC_SELF_HOSTED_NAME="LP Forms"`, `NUXT_PUBLIC_ENV=production`, and a private `NUXT_API_SECRET` matching `FRONT_API_SECRET` in `api/.env`.
4. Start **your fork's source-built images**, not the upstream images:

   ```sh
   docker compose -f docker-compose.yml -f docker-compose.lpforms.yml up -d --build
   ```

5. Visit `http://localhost/setup` and create the first administrator. Verify that the app, worker, scheduler, database and Redis services are healthy; then create a form, submit a response, and check delivery/exports.

To stop: `docker compose -f docker-compose.yml -f docker-compose.lpforms.yml down`. Do not add `-v` unless you intend to delete local data volumes.

## Production gates (not completed in Phase 1)

- Decide deployment environment and cost, custom DNS and HTTPS configuration.
- Use a dedicated LP Forms PostgreSQL database; do not reuse LP CRM/LeadOS/SalesOS data stores. The local Compose file creates its own PostgreSQL service. A future Neon setup will require a separate production configuration and the appropriate SSL connection settings.
- Use managed/persistent Redis, backups and file-object storage with retention rules.
- Store credentials only in the hosting provider's secret store, never in GitHub or screenshots.
- Configure SMTP, domain verification, public URL, CORS/proxy trust, anti-spam, and data-retention controls.
- Check AGPL-3.0 obligations and preserve upstream licences/notices. Audit proprietary enterprise features separately before productizing.
- Run the existing upstream lint, unit and end-to-end checks against the selected hosting topology and verify failures are resolved before accepting live submissions.

## Planned integrations

LP CRM / LP SalesOS should receive leads via authenticated webhooks with per-form opt-in, retries, deduplication and auditable delivery. Do not forward sensitive patient or financial submissions without an appropriate compliance/security review.
