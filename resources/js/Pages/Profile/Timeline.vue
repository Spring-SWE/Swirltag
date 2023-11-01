<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({ user: Object })

</script>

<template>
    <Head :title="user.name" />
    <AuthenticatedLayout>
        <Threads
            :threadsDisplayMethod="timeline"
            :user="user.name" />
        <ThreadsTrendingBar />
    </AuthenticatedLayout>
</template>
