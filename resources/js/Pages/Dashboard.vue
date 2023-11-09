<script setup>
import { ref, reactive, onMounted } from 'vue';
import Status from '@/Pages/Status/Partials/Status.vue';
import StatusTrendingBar from '@/Pages/Status/Partials/StatusTrendingBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useIntersectionObserver } from '@vueuse/core'
import axios from 'axios';


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

// Create a reactive local copy of statuses that you can safely mutate
const localStatuses = reactive({
    data: [],
    meta: props.statuses.meta,
});
const last = ref(null);
const isLoading = ref(false);

onMounted(() => {
    localStatuses.data = [...props.statuses.data];
});

//Nice vue.use method imported.
const { stop } = useIntersectionObserver(last, ([{ isIntersecting }]) => {
    if (!isIntersecting) {
        return;
    }

    isLoading.value = true; // Start loading

    axios.get(`${localStatuses.meta.path}?cursor=${localStatuses.meta.next_cursor}`).then((response) => {

        localStatuses.data.push(...response.data.data);
        localStatuses.meta = response.data.meta;

        // If there's no next cursor, stop the intersection observer
        if (!response.data.meta.next_cursor) {
            stop();
        }
    }).catch(error => {
        console.error(error);
    }).finally(() => {
        isLoading.value = false;
    });;
});

</script>

<template>
    <Head title="Dashboard" />
    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="status col-span-12 lg:col-span-8 mt-3 border dark:border-gray-700">
                <Status v-for="(status) in localStatuses.data"
                        :key="status.id"
                        :statusData="status"
                        :hasBorder="true" />
            </div>

            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                <StatusTrendingBar />
            </div>

            <div v-if="isLoading" class="col-span-12 lg:col-span-8 flex justify-center items-center h-16">
                <span class="loading loading-spinner loading-lg text-primary"></span>
            </div>
            <span ref="last" class="-translate-y-40"></span>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="status col-span-12 lg:col-span-8 mt-3">
                <Status v-for="(status, index) in statuses"
                        key="status.id"
                        :statusData="status"
                        :hasBorder="true" />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                <StatusTrendingBar />
            </div>
        </GuestLayout>
    </div>
</template>
