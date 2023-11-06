<script setup>
import Threads from '@/Pages/Thread/Partials/Threads.vue';
import ProfileInlineTabs from '@/Pages/Profile/Partials/ProfileInlineTabs.vue';
import ProfileUserDetails from '@/Pages/Profile/Partials/ProfileUserDetails.vue';
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
            <div class="col-span-12">
                <ProfileInlineTabs></ProfileInlineTabs>
            </div>
            <div class="thread col-span-12 lg:col-span-8">
                <Threads v-for="(thread, index) in threads"
                    :key="thread.id"
                    :user="userName"
                    :threadData="thread"
                    :class="[index !== threads.length - 1 ? 'border-b-0' : '', 'border']"
                    />
            </div>
            <div class="col-span-12 lg:block lg:col-span-4 mr-2 h-16 sticky top-1">
                <ProfileUserDetails />
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
                <ProfileUserDetails />
            </div>
        </GuestLayout>
    </div>

</template>
