<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    threads: {
        type: Array,
    },
    user: {
        type: Array
    }
});

console.log(props.threads)

</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="thread col-span-12 lg:col-span-8">
            <Threads v-for="thread in threads"
                :key="thread.id"
                :user="thread.user.name"
                :threadData="thread" />
        </div>
        <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
            <ThreadsTrendingBar />
        </div>
    </AuthenticatedLayout>
</template>
