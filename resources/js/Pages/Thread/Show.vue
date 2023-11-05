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


</script>

<template>
    <Head :title="huh" />

    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="thread col-span-12 lg:col-span-8">
                left
            </div>
            <div class="col-span-12 lg:block lg:col-span-4 mr-2 h-16 sticky top-1">
                right
            </div>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="thread col-span-12 lg:col-span-8">
                right
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
                Left
            </div>
        </GuestLayout>
    </div>

</template>
