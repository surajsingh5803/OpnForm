# LP Forms — Commercial-sale compliance and release gate

**Status (19 November 2026): NOT cleared for paid-customer launch.** This is a technical inventory and implementation checklist, not a legal opinion. LP Forms is intended for future sale to customers and agency clients, so these gates apply to all subsequent releases.

## Confirmed by source review

1. **Core licence is preserved.** The root `LICENSE` retains upstream copyright (© 2025 OpnForm), a carve-out for `api/app/Enterprise/`, third-party licence preservation, and the complete AGPL-3.0 terms. It must not be replaced with LP Forms-only proprietary terms.
2. **GitHub fork is public, but the deployment branch differs from default `main`.** Modified staging code lives at [feat/lp-forms-phase1-foundation](https://github.com/surajsingh5803/OpnForm/tree/feat/lp-forms-phase1-foundation). Footer/source notices must point to **this actual modified code**, or to the exact tagged commit running in production; the unmodified upstream/default branch alone does not satisfy an offer of the modified source.
3. **Enterprise proprietary files exist.** `api/app/Enterprise/LICENSE` prohibits unlicensed production use and unauthorized publication/distribution/sale of proprietary Enterprise modules. The folder contains 25+ entries, including an OIDC implementation. An external controller imports `App\Enterprise\Oidc\Models\IdentityConnection` and other proprietary classes. **Do not delete this directory blindly or assume it is unused**; audit dependencies and licence rights. No enterprise code should be relicensed as AGPL.
4. **Free self-hosted user limit remains enforced by source.** `api/app/Service/License/SelfHostedSeatLimitService.php` defines `FREE_SEAT_LIMIT = 2` and checks the valid license via `LicenseService`. Never bypass these checks. Official licensing documentation says commercial use of the AGPL core is permitted, but additional seats and advanced workspace/white-label features require appropriate Enterprise rights.
5. **Branding limits need a legal decision.** Text-only references to LP Forms are not automatically equivalent to authorization for advanced white-label or branding-removal features, which the original product describes as Enterprise. The original licensing documentation and separate proprietary terms must be checked before marketing LP Forms as a multi-customer white-label SaaS.
6. **Original Notion-hosted legal pages were not LP Forms policies.** The former `privacy-policy.vue` and `terms-conditions.vue` loaded upstream Notion documents. They have been replaced with first-party, publicly viewable **staging drafts** containing no claim of completed commercial legal review.
7. **The public licence/attribution page is** `/open-source`. It preserves upstream attribution, distinguishes AGPL-covered code from proprietary Enterprise components, and offers a link to the modified staging branch and root licence.

## Non-negotiable gates before accepting money or production client data

- [ ] Obtain a written opinion from an appropriate software-licensing professional on this fork's exact intended SaaS and client-installation model (including branding changes).
- [ ] Verify the correct licence/permissions for *every* proprietary Enterprise file used or shipped; if Community-only, produce and test a core-only artefact without proprietary code, dependent routes or autoload failures. Do not republish proprietary modules as open source.
- [ ] Verify that no commercial/Enterprise functionality is exposed by flag edits, entitlements, patched API responses, or seat-limit bypasses without a valid vendor licence.
- [ ] Decide how multi-customer accounts work with the **two-user-per-instance** Community licence cap; a shared multi-tenant service is **not** automatically exempt.
- [ ] Create a publicly readable, prominent **Corresponding Source** offer matching the **exact deployed release**, including build/install scripts and required notices, as required by AGPL-3.0 §13 and related provisions.
- [ ] Finalise the legal identity of the operator, contact details, privacy policy, cookie disclosures, retention/deletion, subprocessors, geography/data transfer arrangements and applicable customer data-processing agreement. Get appropriate local counsel review.
- [ ] Finalise and approve actual paid-service Terms, pricing, billing/refunds, customer support terms, SLA/warranty commitments and an abuse-reporting process.
- [ ] Remove or obtain permission/evidence for upstream customer-logo, review, case-study, trust-score, paid-plan and feature-availability claims. Do not copy the original vendor's contracts or commercial promises.
- [ ] Verify durable storage, database backups/restore, file retention, queue worker, transactional email, access controls, abuse prevention, incident procedures, security tests and monitoring with **non-sensitive** test data first.
- [ ] Confirm build/published container licence and source parity, dependency licence inventory and third-party notices for the release.
- [ ] Review and publish a production-ready support channel accessible to account holders and form respondents.

## Reference sources

- Local `/LICENSE` and `/api/app/Enterprise/LICENSE` (retain verbatim).
- [Upstream official self-hosted licensing documentation](https://docs.opnform.com/deployment/self-hosted-license).
- [Upstream enterprise terms](https://opnform.com/terms-conditions).
- [GNU AGPL-3.0 text](https://www.gnu.org/licenses/agpl-3.0.html).
- [Fork source branch](https://github.com/surajsingh5803/OpnForm/tree/feat/lp-forms-phase1-foundation).

**Commercial decision:** Offering paid setup, maintenance or hosted access to AGPL-covered software can be possible under its terms, but LP Forms is **not yet compliant-by-inspection**, and a source-link/footer-only fix cannot settle the Enterprise rights. No proprietary restrictions should be bypassed to launch more quickly.
