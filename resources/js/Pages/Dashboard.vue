<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
            <ThreadsTrendingBar />
        </div>
    </AuthenticatedLayout>
</template>
