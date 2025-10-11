
<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-gray-50 to-indigo-100">
    <!-- Logo ou título -->
    <div class="text-center p-8 bg-white rounded-2xl shadow-lg max-w-lg w-full">
      <h1 class="text-4xl font-extrabold text-indigo-600 mb-4">
        👋 Olá, PREGÃO Inertia/Vue 3 está ativo!
      </h1>

      <p class="text-gray-700 mb-6">
        Front-end totalmente funcional com <strong>TailwindCSS</strong> e <strong>Vite</strong>.
      </p>

      <!-- Botões de navegação fictícios -->
      <div class="flex justify-center gap-4">
        <a
          href="#"
          class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition"
        >
          Entrar
        </a>
        <a
          href="#"
          class="px-5 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 transition"
        >
          Criar Conta
        </a>
      </div>
    </div>

    <!-- Rodapé simples -->
    <footer class="mt-10 text-sm text-gray-500">
      <p>© {{ new Date().getFullYear() }} Pregão - Todos os direitos reservados.</p>
    </footer>
  </div>
</template>

<script setup>
// Nenhuma lógica complexa ainda — o script setup é o padrão Vue 3
</script>

<style scoped>
/* Escopo opcional para garantir que o estilo seja local */
</style>
