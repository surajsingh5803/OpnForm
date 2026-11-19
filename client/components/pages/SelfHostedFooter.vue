<template>
  <footer class="mx-auto flex w-full max-w-5xl flex-col items-center justify-between gap-4 px-6 py-8 text-sm text-muted sm:flex-row">
    <a :href="cloudUrl" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:text-highlighted">
      <img src="/img/lp-forms-logo.svg" alt="" class="size-4" />
      LP Forms
      <UIcon name="i-heroicons-arrow-up-right" class="size-3.5" />
    </a>
    <nav aria-label="Instance resources" class="flex flex-wrap justify-center gap-x-5 gap-y-2">
      
      <a href="https://github.com/surajsingh5803/OpnForm/tree/feat/lp-forms-phase1-foundation" target="_blank" rel="noopener noreferrer" class="hover:text-highlighted">LP Forms source code</a>
      <NuxtLink to="/open-source" class="hover:text-highlighted">AGPL-3.0 &amp; attribution</NuxtLink>
      <a :href="privacyPolicyUrl || '/privacy-policy'" class="hover:text-highlighted">Privacy notice</a>
      <a :href="termsUrl || '/terms-conditions'" class="hover:text-highlighted">Terms</a>
    </nav>
    <p class="text-xs text-muted">Modified AGPL-3.0 core. Original copyright © 2025 OpnForm. No warranty under the open-source licence; separate proprietary Enterprise modules are not AGPL.</p>
  </footer>
</template>

<script setup>
const { privacyPolicyUrl, termsUrl } = useSelfHostedPresentation()
const cloudUrl = '/'
</script>
