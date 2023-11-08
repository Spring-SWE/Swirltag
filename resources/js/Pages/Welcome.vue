<script setup>
import Status from '@/Pages/Status/Partials/Status.vue';
import StatusTrendingBar from '@/Pages/Status/Partials/StatusTrendingBar.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Home" />

    <GuestLayout>
        <div class="Status col-span-12 lg:col-span-8">
            <h1 class="dark:text-white">Stuff coming soon.</h1>
        </div>
        <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
            <StatusTrendingBar />
        </div>
    </GuestLayout>
</template>
