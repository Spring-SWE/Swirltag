<script setup>
import ThreadWithComments from '@/Pages/Thread/Partials/ThreadWithComments.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    user: {
        type: Object,
    },
    thread: {
        type: Object,
    },
    comments: {
        type: Array
    }
});

</script>

<template>
    <Head title="Viewing Thread" />

    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="thread col-span-12 lg:col-span-8">
                <ThreadWithComments
                :thread="props.thread"
                :comments="props.comments"
                />
            </div>
            <div class="col-span-12 lg:block lg:col-span-4 mr-2 h-16 sticky top-1">
                Viewing Thread
            </div>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="thread col-span-12 lg:col-span-8">
                <ThreadWithComments
                :thread="props.thread"
                :comments="props.comments"
                />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
                Left
            </div>
        </GuestLayout>
    </div>

</template>
