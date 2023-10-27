<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Threads />
        <ThreadsTrendingBar />
    </AuthenticatedLayout>
</template>
