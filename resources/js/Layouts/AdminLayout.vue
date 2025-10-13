<template>
  <div class="min-h-screen flex bg-gray-100">
    <Sidebar class="w-64 hidden md:block" />
    <div class="flex-1">
      <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-3">
          <slot name="topbar">
            <div class="flex items-center justify-between">
              <h1 class="text-lg font-semibold">PREGÃO</h1>
              <div>
                <span class="text-sm text-gray-600 mr-4">{{ user?.name }}</span>
                <form :action="route('logout')" method="post" style="display:inline">
                  <input type="hidden" name="_token" :value="csrf" />
                  <button class="text-sm text-red-600">Sair</button>
                </form>
              </div>
            </div>
          </slot>
        </div>
      </nav>
      <main class="p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import Sidebar from '@/components/ui/Sidebar.vue';
import { usePage } from '@inertiajs/vue3';
const page = usePage();
const user = page.props.value?.auth?.user ?? null;
import { computed } from 'vue';
const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
</script>

<style scoped>
/* small helpers */
</style>
