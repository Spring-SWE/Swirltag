<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Guest View" />

    <GuestLayout>
        <Threads />
        <ThreadsTrendingBar />
    </GuestLayout>
</template>
