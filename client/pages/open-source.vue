<template>
  <div class="min-h-screen bg-white text-neutral-900">
    <main class="mx-auto max-w-3xl px-6 py-12 sm:py-20">
      <NuxtLink to="/" class="text-sm font-semibold text-blue-700">← LP Forms</NuxtLink>
      <h1 class="mt-7 text-3xl font-bold">Open-source licence and attribution</h1>
      <p class="mt-4 leading-7 text-neutral-700">
        LP Forms is an independently branded modified deployment based on OpnForm.
        Copyright © 2025 OpnForm remains with the original copyright holders.
        Modifications by LP Forms contributors began in November 2026.
      </p>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">AGPL-3.0 source code</h2>
        <p class="leading-7 text-neutral-700">The application core is provided under the GNU Affero General Public License version 3 (AGPL-3.0), subject to the original notices and third-party licences. Network users may obtain the corresponding source for the modified AGPL-covered core and the scripts needed to build and operate it.</p>
        <a class="block font-semibold text-blue-700 underline" href="https://github.com/surajsingh5803/OpnForm/tree/feat/lp-forms-phase1-foundation" target="_blank" rel="noopener noreferrer">View the LP Forms staging source branch</a>
        <a class="block font-semibold text-blue-700 underline" href="https://github.com/surajsingh5803/OpnForm/blob/feat/lp-forms-phase1-foundation/LICENSE" target="_blank" rel="noopener noreferrer">Read the full AGPL-3.0 and repository licensing notice</a>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Important licence boundary</h2>
        <p class="leading-7 text-neutral-700">The upstream repository also includes material under <code>api/app/Enterprise/</code> governed by a separate proprietary Enterprise licence, not the AGPL. That proprietary material is not re-licensed by LP Forms. Access to or availability of repository files does not grant Enterprise usage, distribution or resale rights.</p>
        <p class="leading-7 text-neutral-700">The LP Forms team is auditing this boundary for any eventual commercial offering. Do not assume Enterprise features, white-labelling, or additional user seats are licensed unless appropriate rights have been obtained.</p>
      </section>
      <section class="mt-8 space-y-3">
        <h2 class="text-xl font-semibold">Copyright, redistribution and warranty</h2>
        <p class="leading-7 text-neutral-700">You may copy, modify and redistribute AGPL-covered code in accordance with its full licence terms and required notices. The AGPL-covered software comes without warranty as described in that licence. Separate customer service agreements, if offered, do not alter the rights granted by the open-source licence.</p>
        <p class="leading-7 text-neutral-700">LP Forms is not affiliated with or endorsed by the original OpnForm authors.</p>
      </section>
      <p class="mt-10 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-950">This deployment is currently a staging environment. Public source access and attribution do not by themselves establish compliance for commercial resale; the proprietary-module, data-protection and customer-contract reviews are still open.</p>
    </main>
    <OpenFormFooter :show-cta="false" />
  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })
useOpnSeoMeta({
  title: 'Open-source licence and attribution',
  description: 'AGPL-3.0 licensing, source code, upstream attribution and Enterprise licence boundaries for LP Forms.',
})
</script>
