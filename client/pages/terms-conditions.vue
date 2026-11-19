<template>
  <div class="min-h-screen bg-white text-neutral-900">
    <main class="mx-auto max-w-3xl px-6 py-12 sm:py-20">
      <NuxtLink to="/" class="text-sm font-semibold text-blue-700">← LP Forms</NuxtLink>
      <h1 class="mt-7 text-3xl font-bold">LP Forms terms — staging draft</h1>
      <p class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-950">
        This draft explains the current LP Forms test installation. It is not a final paid-service agreement, offer, subscription contract or completed legal policy. The contracting entity, pricing, customer support, refunds, warranties, service levels and governing law require approval before commercial sales.
      </p>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Staging access</h2>
        <p class="leading-7 text-neutral-700">LP Forms is currently being tested as a self-hosted form-building application. Staging may change, sleep or be interrupted and is not intended for production use, payment processing, sensitive information or live client records. Test users should use dummy information and retain copies of anything important.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Acceptable use</h2>
        <p class="leading-7 text-neutral-700">Do not attempt unauthorised access to other accounts or submissions, bypass technical controls, upload malicious material, send spam, infringe other people's rights or use forms to collect information without an appropriate legal basis. Form owners are responsible for the questions they ask and the notices they provide to respondents.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Open-source and proprietary licences</h2>
        <p class="leading-7 text-neutral-700">LP Forms is based on the open-source OpnForm core under AGPL-3.0. Rights to copy, modify and redistribute the AGPL-covered software are governed by that licence, independent of any future hosted-service fees. Certain upstream Enterprise components have a separate proprietary licence and are not included in those AGPL rights. No subscription or Enterprise rights are granted by this staging page.</p>
        <NuxtLink to="/open-source" class="inline-block font-semibold text-blue-700 underline">Read the full licensing and source-code notice</NuxtLink>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">User data and availability</h2>
        <p class="leading-7 text-neutral-700">This test platform stores operational and form data for functionality checks, but durable uploads, backups, retention periods, support response times and production security controls are still being evaluated. No commercial uptime commitment is offered for staging. Please read the <NuxtLink to="/privacy-policy" class="text-blue-700 underline">staging privacy notice</NuxtLink> before using the test environment.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Future commercial subscriptions</h2>
        <p class="leading-7 text-neutral-700">Before selling LP Forms as a hosted SaaS or delivering client-managed installations, the operator must publish the applicable contracting terms, data-processing and privacy materials, pricing, cancellation/refund rules, licensing disclosures and service commitments. No pricing or promise should be inferred from default upstream marketing pages.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Contact</h2>
        <p class="leading-7 text-neutral-700">Until the formal service contact is published, enquiries may be directed through <a href="https://lazyplex.com" target="_blank" rel="noopener noreferrer" class="text-blue-700 underline">the Lazy Plex website</a>. Contact and jurisdiction information will be included in the final, approved commercial Terms.</p>
      </section>
      <p class="mt-10 text-sm text-neutral-500">Draft prepared: 19 November 2026. Legal review and customer-contract details are pending.</p>
    </main>
    <OpenFormFooter :show-cta="false" />
  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })
useOpnSeoMeta({
  title: 'Terms — staging draft',
  description: 'Preliminary staging terms and commercial licence boundaries for LP Forms.',
  robots: 'noindex, nofollow',
})
</script>
