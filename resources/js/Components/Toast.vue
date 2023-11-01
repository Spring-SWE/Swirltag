<template>
    <div
      v-if="isVisible"
      id="toast-simple"
      class="fixed bottom-10 left-1/2 transform -translate-x-1/2 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x divide-gray-200 rounded-lg shadow-2xl dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-theme-purple"
      role="alert"
    >
      <svg
        class="w-5 h-5 text-blue-600 dark:text-white rotate-45"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 18 20"
      >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9"
            role="alert"
          />
      </svg>
      <div class="pl-4 text-sm font-semibold text-white">
        <slot></slot>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';

  const isVisible = ref(true);

  onMounted(() => {
    setTimeout(() => {
      isVisible.value = false;
    }, 5000);
  });

</script>
