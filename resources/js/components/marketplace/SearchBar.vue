<template>
  <div class="w-full">
    <form @submit.prevent="submit">
      <div class="flex">
        <input v-model="q" placeholder="Pesquisar produtos..." class="w-full rounded-l border px-3 py-2"/>
        <button class="bg-pregao-primary text-white px-4 rounded-r">Pesquisar</button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const q = ref('');
const router = useRouter();
const submit = () => {
  if(q.value.trim()) router.push({ path: '/marketplace', query: { q: q.value }});
};
</script>
