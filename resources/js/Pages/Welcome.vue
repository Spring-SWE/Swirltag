<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Guest View" />

    <GuestLayout>
        <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
            <ThreadsTrendingBar />
        </div>
    </GuestLayout>
</template>
