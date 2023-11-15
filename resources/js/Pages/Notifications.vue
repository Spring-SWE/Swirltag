<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const page = usePage.props;

onMounted(() => {
    Echo.private(`App.Models.User.1`)
   .notification((notification) => {
       console.log('Notification received:', notification);
   });
});
</script>

<template>
    <Head title="Notification" />

    <div v-if="$page.props.auth.user">
        <AuthenticatedLayout>

            <div class="hidden lg:block lg:col-span-4 mr-2 h-16 sticky top-2 mt-2">

            </div>
            <div class="status col-span-12 lg:col-span-8 border dark:border-gray-700">
                f
            </div>

        </AuthenticatedLayout>
    </div>

    <div v-else>
        <GuestLayout>
            <div class="col-span-8">
                ddd
            </div>
            <div class="hidden lg:block lg:col-span-4 mr-2 h-16 sticky top-2 mt-2">

            </div>
            <div class="status col-span-12 lg:col-span-8 border dark:border-gray-700">


            </div>
        </GuestLayout>
    </div>

</template>
