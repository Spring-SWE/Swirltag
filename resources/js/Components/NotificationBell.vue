<template>
    <div class="relative">
        <BellIcon class="h-6 w-6 text-gray-500" />
        <span v-if="notificationCount > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
            {{ notificationCount }}
        </span>
    </div>
</template>

<script setup>
import { BellIcon } from '@heroicons/vue/24/outline';
import { ref, onMounted } from 'vue';


// Optionally, you can fetch the initial count from the server
</script>
