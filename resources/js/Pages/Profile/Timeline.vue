<script setup>
import InfiniteLoader from '@/Pages/Status/Partials/InfiniteLoader.vue';
import { reactive, computed } from 'vue';
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
        type: Object,
    }
});

const userName = props.user.name;

const localStatuses = reactive({
    data: [],
    meta: props.statuses.meta,
});

const apiEndpoint = computed(() => `${localStatuses.meta.path}`);

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

                <InfiniteLoader :apiEndpoint="apiEndpoint" :initialData="localStatuses.data" :hasMore="localStatuses.meta.next_cursor">
                    <template #default="{ items }">
                    <Status v-for="status in items" :key="status.id" :statusData="status" :hasBorder="true" />
                    </template>
                </InfiniteLoader>
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
