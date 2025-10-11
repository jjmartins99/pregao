<template>
  <div class="relative w-64">
    <input v-model="q" @keydown.enter="go" type="text" placeholder="Pesquisar..." class="w-full border rounded px-3 py-2"/>
    <button @click="go" class="absolute right-1 top-1 text-gray-600">🔍</button>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
export default {
  setup() {
    const q = ref('')
    const router = useRouter()
    const go = () => {
      if(!q.value) return
      router.push({ name: 'marketplace', query: { q: q.value } })
      q.value = ''
    }
    return { q, go }
  }
}
</script>
