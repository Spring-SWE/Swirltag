<script setup>
import Threads from '@/Pages/Thread/Partials/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Thread/Partials/ThreadsTrendingBar.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <GuestLayout>
        <div class="thread col-span-12 lg:col-span-8">
            <h1 class="dark:text-white">Stuff coming soon.</h1>
        </div>
        <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
            <ThreadsTrendingBar />
        </div>
    </GuestLayout>
</template>
