// This fork is an independent self-hosted LP Forms installation.
// Upstream cloud sales/comparison pages are not relevant to this instance;
// presenting their provider-specific pricing, customer claims or links would be
// misleading, so do not serve them on self-hosted routes.
const legacyMarketingRoutes = [
  /^\/opnform-vs-[^/]+\/?$/,
  /^\/enterprise\/?$/,
  /^\/industry\/?$/,
  /^\/pricing\/?$/,
  /^\/integrations(?:\/|$)/,
]

export default defineNuxtRouteMiddleware((to) => {
  if (!useFeatureFlag('self_hosted', false)) return
  if (legacyMarketingRoutes.some((re) => re.test(to.path))) {
    return navigateTo({ name: 'index' })
  }
})
