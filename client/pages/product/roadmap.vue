<template>
  <div class="min-h-full bg-neutral-50">
    <LpProductHeader title="Product roadmap" section="Product"
      description="See what is already working, what needs production hardening, and what we are considering next for LP Forms." />
    <main class="mx-auto max-w-6xl px-5 py-9 sm:px-8">
      <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="max-w-2xl text-sm leading-6 text-neutral-600">A living roadmap for this independent LP Forms installation. Statuses are based on actual implementation work; they are not commitments or delivery dates.</p>
        <UButton to="/product/feature-requests" icon="i-heroicons-plus" color="primary">Request a feature</UButton>
      </div>
      <div class="grid gap-5 lg:grid-cols-4">
        <section v-for="column in columns" :key="column.key" class="min-w-0">
          <div class="mb-4 flex items-center justify-between gap-2 border-b border-neutral-200 pb-3">
            <div class="flex items-center gap-2">
              <span class="size-2.5 rounded-full" :class="column.dot" />
              <h2 class="text-sm font-bold text-neutral-900">{{ column.name }}</h2>
            </div>
            <span class="rounded-full bg-neutral-200 px-2 py-0.5 text-xs font-semibold text-neutral-600">{{ column.items.length }}</span>
          </div>
          <div class="space-y-3">
            <article v-for="item in column.items" :key="item.title" class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm">
              <span class="inline-flex rounded-md bg-neutral-100 px-2 py-1 text-[11px] font-semibold text-neutral-600">{{ item.area }}</span>
              <h3 class="mt-3 font-semibold leading-6 text-neutral-950">{{ item.title }}</h3>
              <p class="mt-2 text-sm leading-6 text-neutral-600">{{ item.description }}</p>
            </article>
          </div>
        </section>
      </div>
      <div class="mt-9 rounded-2xl border border-blue-100 bg-blue-50 p-6">
        <h2 class="font-semibold text-blue-950">Help shape LP Forms</h2>
        <p class="mt-2 text-sm leading-6 text-blue-900">Do you need conditional logic, better email delivery or a CRM connection? Suggest it in Feature Requests. New submissions start in review rather than appearing as promised releases.</p>
        <UButton to="/product/feature-requests" class="mt-4" color="primary">Share your idea</UButton>
      </div>
    </main>
  </div>
</template>

<script setup>
import LpProductHeader from '~/components/pages/lp-product/LpProductHeader.vue'
definePageMeta({ layout: 'dashboard', middleware: ['auth'] })
useOpnSeoMeta({ title: 'Product roadmap', description: 'LP Forms development roadmap', robots: 'noindex, nofollow' })
const columns = [
  {
    key: 'complete', name: 'Implemented in staging', dot: 'bg-emerald-500', items: [
      { area: 'Platform', title: 'Render + Neon setup', description: 'Separate Nuxt and Laravel services connected to an LP Forms PostgreSQL project.' },
      { area: 'Branding', title: 'LP Forms identity', description: 'Custom logo, browser icon, form preview badge, key screens and account messaging.' },
      { area: 'Forms', title: 'Form builder foundation', description: 'Existing form editing, preview, sharing and response interfaces from the fork.' },
    ],
  },
  {
    key: 'progress', name: 'In progress', dot: 'bg-blue-500', items: [
      { area: 'Support', title: 'Native help and feedback', description: 'In-app guidance, product updates and a feature-request inbox for this installation.' },
      { area: 'Reliability', title: 'Production readiness', description: 'End-to-end testing, stable integrations, logging and data protection for customer submissions.' },
    ],
  },
  {
    key: 'planned', name: 'Planned', dot: 'bg-violet-500', items: [
      { area: 'Infrastructure', title: 'Persistent uploads', description: 'Replace ephemeral container storage with durable object storage and backups.' },
      { area: 'Notifications', title: 'Email delivery', description: 'Configure a real SMTP or transactional email provider and verify delivery.' },
      { area: 'Operations', title: 'Background jobs', description: 'Add a reliable worker and durable queue before production use.' },
      { area: 'Domains', title: 'LP Forms domain', description: 'Configure a branded domain with TLS and correct redirects.' },
    ],
  },
  {
    key: 'exploring', name: 'Exploring', dot: 'bg-amber-500', items: [
      { area: 'Lazy Plex', title: 'LP CRM handoff', description: 'Send form submissions into LP CRM without copying customer data manually.' },
      { area: 'Lazy Plex', title: 'LP SalesOS workflows', description: 'Turn qualified form enquiries into sales pipeline activity.' },
      { area: 'Automation', title: 'More form integrations', description: 'Evaluate webhooks and automation workflows around actual user demand.' },
    ],
  },
]
</script>
