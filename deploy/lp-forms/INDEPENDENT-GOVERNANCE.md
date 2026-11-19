# LP Forms — Independent governance engineering plan

Status: **development prototype only** (19 November 2026). This is not permission to use OpnForm Enterprise capabilities on an unlicensed commercial installation.

## 1. Team management — existing core is maintained

- Current core already has invitations, membership roles, team-list endpoints, and a self-hosted two-user guard in `SelfHostedSeatLimitService`.
- Do **not** modify that guard, enterprise entitlements, or vendor licence checks to gain additional seats.
- A future independently designed organization/team service must enforce tenant isolation, invite expiry and revocation, single-owner/last-admin constraints, role-based authorization, transactional concurrent seat checks, and user lifecycle tests.
- More than two self-hosted users remains a **commercial licensing decision**. For unlicensed evaluation, use at most two instance users. A genuinely separate implementation or replacement form engine would require its own licence and design review.

## 2. Basic activity history — independently written prototype

- New `lp_forms_workspace_audit_events` table, own model/service/controller, no dependency on `api/app/Enterprise/`.
- Captures IDs and action names for form and workspace changes; does not copy answer data, password hashes, invitation tokens, or emails.
- Administrator-only, workspace-scoped, paginated `GET /open/workspaces/{workspace}/audit-events`.
- Off by default via `LP_FORMS_AUDIT_ENABLED=false`. Evaluation is available only in local/test; production requires a valid Enterprise entitlement as a **temporary commercial safeguard** pending legal advice.
- No changes to existing OpnForm feature flags or seat licence checks.
- Not yet a compliance-grade immutable audit system. Before commercial release: cover invite events and exports, transactional writes, retention/deletion, integrity controls, export permissions, abuse monitoring and UI.

## 3. SAML / LDAP SSO — planned, not enabled

- Existing Community OIDC supports up to two instance users; leave existing checks in place.
- SAML 2.0 and LDAP integrations require their *own* security-reviewed adapters; Laravel Socialite alone is not a SAML implementation.
- Requirements: signed assertion verification; audience/issuer/destination/InResponseTo checks; expiry/replay protection; safe account linking; MFA policies; strict HTTPS; LDAP TLS/cert validation; no admin password logging; disable-user sync; fallback recovery; certificate rotation; SCIM optional.
- Evaluate independently licensed libraries (for example, OneLogin's PHP-SAML and LdapRecord), verify each dependency and lockfile licence, then implement using tests and external identity-provider interoperability checks.
- Do not import or adapt any source from `api/app/Enterprise/`. Do not expose SAML/LDAP as a working feature or remove vendor licensing restrictions before legal clearance.

## Release gates

- Production/paid-client launch remains blocked as detailed in `COMMERCIAL-COMPLIANCE.md`.
- Keep all original AGPL notices and original Enterprise licensing separate; ensure Corresponding Source is public and matches each deployed core revision.
- Run migrations, targeted Pest tests, auth/tenant regression tests and security review on an isolated instance before merging. Staging rollout is not part of this prototype.
