import { httpUrl } from '~/lib/self-hosted-public.js'

export function useSelfHostedPresentation() {
  const config = useRuntimeConfig().public

  return {
    name: config.selfHostedName || 'LP Forms',
    logoUrl: httpUrl(config.selfHostedLogoUrl) || '/img/logo.svg',
    privacyPolicyUrl: httpUrl(config.selfHostedPrivacyPolicyUrl),
    termsUrl: httpUrl(config.selfHostedTermsUrl),
  }
}
