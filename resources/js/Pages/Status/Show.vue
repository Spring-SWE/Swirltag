<script setup>
import ViewStatus from '@/Pages/Status/Partials/ViewStatus.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    status: {
        type: Object,
    },
    replies: {
        type: Object
    },
    conversation: {
        type: Array
    },
});


</script>

<template>
    <Head title="Viewing Status" />
    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>
            <div class="status col-span-12 lg:col-span-8">
                <ViewStatus
                    :status="props.status"
                    :replies="props.replies"
                    :conversation="props.conversation"
                  />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1 mt-3">
                Viewing Status
            </div>
        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="status col-span-12 lg:col-span-8">
                <ViewStatus
                    :status="props.status"
                    :replies="props.replies"
                    :conversation="props.conversation"
                  />
            </div>
            <div class="hidden lg:block col-span-4 mr-2 h-16 sticky top-1">
                Viewing Status
            </div>
        </GuestLayout>
    </div>

</template>
