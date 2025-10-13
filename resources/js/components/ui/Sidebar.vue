<template>
  <aside class="h-full bg-white border-r">
    <div class="p-4 border-b">
      <a href="/" class="text-xl font-bold">PREGÃO</a>
    </div>

    <nav class="p-4">
      <ul class="space-y-2">
        <li>
          <inertia-link href="{{ route('dashboard') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-50">
            <span>Dashboard</span>
          </inertia-link>
        </li>
        <li>
          <inertia-link href="/admin/products" class="flex items-center gap-2 p-2 rounded hover:bg-gray-50">
            Produtos
          </inertia-link>
        </li>
        <li>
          <inertia-link href="/admin/categories" class="flex items-center gap-2 p-2 rounded hover:bg-gray-50">
            Categorias
          </inertia-link>
        </li>
        <li>
          <inertia-link href="/marketplace" class="flex items-center gap-2 p-2 rounded hover:bg-gray-50">
            Marketplace (cliente)
          </inertia-link>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { Link as InertiaLink } from '@inertiajs/vue3';
</script>
