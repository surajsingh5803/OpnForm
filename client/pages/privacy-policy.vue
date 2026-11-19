<template>
  <div class="min-h-screen bg-white text-neutral-900">
    <main class="mx-auto max-w-3xl px-6 py-12 sm:py-20">
      <NuxtLink to="/" class="text-sm font-semibold text-blue-700">← LP Forms</NuxtLink>
      <h1 class="mt-7 text-3xl font-bold">LP Forms privacy notice — staging draft</h1>
      <p class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-950">
        This is a preliminary notice for the LP Forms test environment, not the final Privacy Policy for a paid service. The operator's full legal identity, contact details, retention schedule and any mandatory local disclosures require review before commercial launch. Do not enter real customer, patient, financial or otherwise sensitive information into staging.
      </p>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Who operates this installation?</h2>
        <p class="leading-7 text-neutral-700">LP Forms is being developed as part of Lazy Plex. The legal entity and formal privacy-contact details for a future commercial offering have not yet been finalised. Until then, enquiries may be directed through <a href="https://lazyplex.com" class="text-blue-700 underline" target="_blank" rel="noopener noreferrer">the Lazy Plex website</a>.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Information handled by the platform</h2>
        <p class="leading-7 text-neutral-700">When the application is used, it may process account information (such as a name and email address), login/session information, forms and settings, answers deliberately submitted through forms, and technical service logs needed to operate and secure the application. The kind of response information depends on the questions a form owner creates.</p>
        <p class="leading-7 text-neutral-700">Please do not use this staging instance to collect real submissions until data-processing roles, permissions, security, retention, deletion and incident-response procedures have been reviewed.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Hosting and service providers</h2>
        <p class="leading-7 text-neutral-700">This staging application uses Render to host its web and API services and Neon for its PostgreSQL database. The deployment may use other providers only when specifically configured. Regional storage locations, transfers, backups and contractual provider safeguards must be confirmed before accepting paid-client data.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Purposes, sharing and retention</h2>
        <p class="leading-7 text-neutral-700">The platform processes test information to provide accounts, build and share forms, receive test submissions, troubleshoot errors and protect the service. Actual customer-facing uses, processing bases, any integrations or subprocessors, and the retention or deletion schedule will be defined in the final commercial policy. There is currently no published commitment to a specific retention or backup period for staging.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Your choices and questions</h2>
        <p class="leading-7 text-neutral-700">If you have an existing test account or data request, contact the LP Forms operator through the Lazy Plex site above. Formal requests about access, correction, erasure, exports and complaints will be addressed in the final privacy process before paid-client onboarding.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Open-source software</h2>
        <p class="leading-7 text-neutral-700">The underlying application licence is separate from the privacy obligations of the service operator. See <NuxtLink to="/open-source" class="text-blue-700 underline">Open-source licence and attribution</NuxtLink>.</p>
      </section>
      <p class="mt-10 text-sm text-neutral-500">Draft prepared: 19 November 2026. Commercial privacy terms are pending review.</p>
    </main>
    <OpenFormFooter :show-cta="false" />
  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })
useOpnSeoMeta({
  title: 'Privacy notice — staging draft',
  description: 'Preliminary privacy information for the LP Forms staging service.',
  robots: 'noindex, nofollow',
})
</script>
