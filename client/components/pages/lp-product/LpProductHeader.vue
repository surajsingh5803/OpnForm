<template>
  <header class="border-b border-neutral-200 bg-white">
    <div class="mx-auto max-w-6xl px-5 pt-8 pb-0 sm:px-8 sm:pt-12">
      <div class="flex flex-wrap items-center gap-2 text-sm font-semibold tracking-wide text-blue-600">
        <img src="/img/lp-forms-logo.svg" width="28" height="28" alt="" />
        <span>LP Forms</span>
        <span class="text-neutral-300">/</span>
        <span class="text-neutral-500">{{ section }}</span>
      </div>
      <h1 class="mt-5 text-3xl font-bold tracking-tight text-neutral-950 sm:text-4xl">{{ title }}</h1>
      <p class="mt-3 max-w-3xl text-base leading-7 text-neutral-600">{{ description }}</p>
      <nav aria-label="Product and support pages" class="mt-8 flex flex-wrap gap-1 border-b border-transparent">
        <NuxtLink
          v-for="link in links"
          :key="link.href"
          :to="link.href"
          class="-mb-px rounded-t-lg border-b-2 px-3 py-3 text-sm font-medium transition-colors hover:bg-neutral-50 hover:no-underline"
          :class="route.path === link.href ? 'border-blue-600 text-blue-700' : 'border-transparent text-neutral-500 hover:text-neutral-900'"
        >{{ link.label }}</NuxtLink>
      </nav>
    </div>
  </header>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
  description: { type: String, required: true },
  section: { type: String, default: 'Product resources' },
})
const route = useRoute()
const links = [
  { label: "What's new", href: '/product/whats-new' },
  { label: 'Roadmap', href: '/product/roadmap' },
  { label: 'Feature requests', href: '/product/feature-requests' },
  { label: 'Help center', href: '/help' },
  { label: 'API docs', href: '/help/api' },
]
</script>
