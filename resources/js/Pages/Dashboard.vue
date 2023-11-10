<script setup>
import InfiniteLoader from '@/Pages/Status/Partials/InfiniteLoader.vue';
import { reactive, computed } from 'vue';
import Status from '@/Pages/Status/Partials/Status.vue';
import StatusTrendingBar from '@/Pages/Status/Partials/StatusTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    statuses: {
        type: Object
        ,
    },
    user: {
        type: Array
    },
    replies: {
        type: Array
    },
});

const localStatuses = reactive({
    data: [],
    meta: props.statuses.meta,
});

const apiEndpoint = computed(() => `${localStatuses.meta.path}`);

</script>

<template>
    <Head title="Dashboard" />
    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="status col-span-12 lg:col-span-8 mt-3 border dark:border-gray-700">
                <InfiniteLoader :apiEndpoint="apiEndpoint" :initialData="localStatuses.data" :hasMore="localStatuses.meta.next_cursor">
                    <template #default="{ items }">
                    <Status v-for="status in items" :key="status.id" :statusData="status" :hasBorder="true" />
                    </template>
                </InfiniteLoader>
            </div>

            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                <StatusTrendingBar />
            </div>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="status col-span-12 lg:col-span-8 mt-3 border dark:border-gray-700">
                <InfiniteLoader :apiEndpoint="apiEndpoint" :initialData="localStatuses.data" :hasMore="localStatuses.meta.next_cursor">
                    <template #default="{ items }">
                    <Status v-for="status in items" :key="status.id" :statusData="status" :hasBorder="true" />
                    </template>
                </InfiniteLoader>
            </div>

            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                <StatusTrendingBar />
            </div>

            <div v-if="isLoading" class="col-span-12 lg:col-span-8 flex justify-center items-center h-16">
                <span class="loading loading-spinner loading-lg text-primary"></span>
            </div>
            <span ref="last" class="-translate-y-40"></span>
        </GuestLayout>
    </div>
</template>
