<template>
  <div class="min-h-full bg-neutral-50">
    <LpProductHeader title="What's new" section="Product updates"
      description="Actual changes made to this LP Forms installation, not release notes from another platform." />
    <main class="mx-auto max-w-6xl px-5 py-9 sm:px-8">
      <div class="mb-7 flex items-center gap-2 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-900">
        <UIcon name="i-heroicons-information-circle" class="size-5 shrink-0" />
        <p>These are staging updates. Features that need production infrastructure are marked separately in the roadmap.</p>
      </div>
      <div class="space-y-5">
        <article v-for="update in updates" :key="update.title"
          class="rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm sm:p-8">
          <div class="flex flex-wrap items-center justify-between gap-3">
            <span class="text-xs font-semibold uppercase tracking-wide text-blue-600">{{ update.date }}</span>
            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-800">{{ update.label }}</span>
          </div>
          <h2 class="mt-4 text-xl font-semibold text-neutral-950">{{ update.title }}</h2>
          <p class="mt-2 leading-7 text-neutral-600">{{ update.description }}</p>
          <ul class="mt-5 grid gap-2 sm:grid-cols-2">
            <li v-for="point in update.points" :key="point" class="flex items-start gap-2 text-sm text-neutral-700">
              <UIcon name="i-heroicons-check-circle" class="mt-0.5 size-5 shrink-0 text-green-600" />
              <span>{{ point }}</span>
            </li>
          </ul>
        </article>
      </div>
      <div class="mt-8 flex flex-wrap gap-3">
        <UButton to="/product/roadmap" color="primary" trailing-icon="i-heroicons-arrow-right">See the roadmap</UButton>
        <UButton to="/product/feature-requests" variant="outline" color="neutral">Suggest an improvement</UButton>
      </div>
    </main>
  </div>
</template>

<script setup>
import LpProductHeader from '~/components/pages/lp-product/LpProductHeader.vue'
definePageMeta({ layout: 'dashboard', middleware: ['auth'] })
useOpnSeoMeta({ title: "What's new", description: "LP Forms product updates", robots: 'noindex, nofollow' })
const updates = [
  {
    date: 'November 2026', label: 'Available in staging',
    title: 'LP Forms identity and native product resources',
    description: 'The self-hosted form builder now has LP Forms branding across its key workflows. Product updates, roadmap, feedback and support pages are served inside the application.',
    points: ['LP Forms logo, favicon and page titles', 'Branded form preview and submission screens', 'In-app product and support navigation', 'Email invitation and account text updates'],
  },
  {
    date: 'November 2026', label: 'Available in staging',
    title: 'Live self-hosted foundation',
    description: 'LP Forms was deployed as separate Nuxt and Laravel services on Render, connected to its own Neon PostgreSQL database.',
    points: ['Laravel migrations completed', 'Frontend and backend health checks passed', 'Same-origin API proxy connected to Laravel', 'Dedicated staging configuration without paid upgrades'],
  },
  {
    date: 'November 2026', label: 'Available in staging',
    title: 'Form builder baseline',
    description: 'The forked form-builder foundation supports creating and previewing forms. Full customer-facing reliability, email delivery, persistent uploads and queued processing are not yet production-verified.',
    points: ['Create and preview forms', 'Share links and embed-code interface', 'Response management screens', 'Workspace and account access'],
  },
]
</script>
