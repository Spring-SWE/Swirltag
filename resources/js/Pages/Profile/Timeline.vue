<script setup>
import Status from '@/Pages/Status/Partials/Status.vue';
import ProfileInlineTabs from '@/Pages/Profile/Partials/ProfileInlineTabs.vue';
import ProfileUserDetails from '@/Pages/Profile/Partials/ProfileUserDetails.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    user: {
        type: Object,
    },
    statuses: {
        type: Array,
    }
});

const userName = props.user.name;

</script>

<template>
    <Head :title="userName" />

    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="col-span-8">
                <ProfileInlineTabs></ProfileInlineTabs>
            </div>
            <div class="hidden lg:block lg:col-span-4 mr-2 h-16 sticky top-2 mt-2">
                <ProfileUserDetails />
            </div>
            <div class="status col-span-12 lg:col-span-8 border dark:border-gray-700">

                <Status v-for="(status) in statuses"
                    :key="status.id"
                    :statusData="status"
                    :hasBorder="true"
                    />
            </div>

        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="status col-span-12 lg:col-span-8 border dark:border-gray-700">

                <Status v-for="(status) in statuses"
                    :key="status.id"
                    :statusData="status"
                    :hasBorder="true"
                    />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 ">
                <ProfileUserDetails />
            </div>
        </GuestLayout>
    </div>

</template>
