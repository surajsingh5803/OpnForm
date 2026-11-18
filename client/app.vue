<template>
  <AppProvider>
    <div
      id="app"
      class="bg-white dark:bg-notion-dark"
    >
      <NuxtLoadingIndicator color="#2563eb" />
      <NuxtLayout>
        <NuxtPage />
      </NuxtLayout>

      <!-- Third-party services and modals - only load when not on public form pages -->
      <ClientOnly v-if="!isPublicFormPage">
        <div
          v-if="authStore.isImpersonating"
          class="fixed z-[9999] left-0 bottom-0 p-4" id="admin-actions"
        >
          <UFieldGroup size="sm">
            <LazyToolsStopImpersonation />
          </UFieldGroup>
        </div>

        <LazyVendorClarity v-if="vendorsReady && authStore.token && config.public.clarityProjectId" />
        <LazyVendorFeatureBase v-if="vendorsReady && authStore.token && config.public.featureBaseOrganization" />
        <LazyQuickRegister v-if="appStore.quickLoginModal || appStore.quickRegisterModal || appStore.isUnauthorizedError" />
      </ClientOnly>
    </div>
  </AppProvider>
</template>

<script setup>
import { formatBrandTitle } from '~/lib/brand-title.js'
const vendorsReady = ref(false)
let vendorTimer
onMounted(() => { vendorTimer = setTimeout(() => { vendorsReady.value = true }, 1500) })
onBeforeUnmount(() => clearTimeout(vendorTimer))
const appStore = useAppStore()
const authStore = useAuthStore()
const config = useRuntimeConfig()
const route = useRoute()
const { locale } = useI18n()
const { name: instanceName } = useSelfHostedPresentation()

// Check if current page is a public form page (for performance optimization)
const isPublicFormPage = computed(() => route.name === 'forms-slug')

// SEO and head configuration
useOpnSeoMeta({
  title: "Free Form Builder with Unlimited Submissions",
  description: () =>
    `Build beautiful, powerful forms for free with ${instanceName}. Unlimited submissions, rich features, and seamless integrations — fully open-source and easy to use.`,
  ogImage: "/img/lp-forms-social.svg",
  robots: () => {
    return config.public.env === "production" ? null : "noindex, nofollow"
  },
})

useHead({
  titleTemplate: (titleChunk) => {
    return formatBrandTitle(titleChunk, instanceName)
  },
  meta: [
    {
      name: 'mobile-web-app-capable',
      content: 'yes'
    },
    {
      name: 'apple-mobile-web-app-status-bar-style',
      content: 'black-translucent'
    },
  ],
  link: [
    {
      rel: 'icon',
      type: 'image/svg+xml',
      href: '/favicon.svg'
    },
    {
      rel: 'apple-touch-icon',
      type: 'image/svg+xml',
      href: '/favicon.svg'
    }
  ],
  htmlAttrs: () => ({
    dir: 'ltr',
    lang: locale.value
  })
})
</script>
