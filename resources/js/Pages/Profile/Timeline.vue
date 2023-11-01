<script setup>
import Threads from '@/Pages/Threads/Threads.vue';
import ThreadsTrendingBar from '@/Pages/Threads/ThreadsTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    user: {
        type: Object,
    },
    threads: {
        type: Array,
    }
});

const userName = props.user.name;

</script>

<template>
    <Head :title="userName" />

    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="thread col-span-12 lg:col-span-8">
                <Threads v-for="thread in threads"
                    :key="thread.id"
                    :user="userName"
                    :threadData="thread" />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
                <ThreadsTrendingBar />
            </div>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="thread col-span-12 lg:col-span-8">
                <Threads v-for="thread in threads"
                    :key="thread.id"
                    :user="userName"
                    :threadData="thread" />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
                <ThreadsTrendingBar />
            </div>
        </GuestLayout>
    </div>

</template>
