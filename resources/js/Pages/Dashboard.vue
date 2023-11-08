<script setup>
import Threads from '@/Pages/Thread/Partials/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Thread/Partials/ThreadsTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    threads: {
        type: Array,
    },
    user: {
        type: Array
    }
});
</script>

<template>
    <Head title="Dashboard" />
    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="thread col-span-12 lg:col-span-8 mt-3">
                <Threads v-for="(thread, index) in threads"
                        :key="thread.id"
                        :user="thread.user.name"
                        :threadData="thread"
                        :class="[index !== threads.length - 1 ? 'border-b-0' : '', 'border']" />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                <ThreadsTrendingBar />
            </div>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="thread col-span-12 lg:col-span-8 mt-3">
                <Threads v-for="(thread, index) in threads"
                         :key="thread.id" :user="thread.user.name"
                         :threadData="thread"
                         :class="[index !== threads.length - 1 ? 'border-b-0' : '', 'border']" />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                <ThreadsTrendingBar />
            </div>
        </GuestLayout>
    </div>
</template>
