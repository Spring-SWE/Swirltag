<script setup>
import { ref } from 'vue'
import {
    CheckBadgeIcon,
    LinkIcon,
    CalendarIcon,
    EllipsisHorizontalIcon,
    PencilIcon,
} from '@heroicons/vue/24/solid'
import Modal from '@/Components/Modal.vue';
import Edit from '@/Pages/Profile/Edit.vue';

const isProfileEditModalOpen = ref(false);

const openProfileEditModal = () => {
    isProfileEditModalOpen.value = true;
};

const closeProfileEditModal = () => {
    isProfileEditModalOpen.value = false;
};

const props = defineProps({
    userData: {
        type: Object,
    },
    userId: {
        type: Number,
    }
});
</script>

<template>
    <Modal :show="isProfileEditModalOpen" @close="closeProfileEditModal">
        <Edit :userData="props.userData"/>
    </Modal>

    <div class="w-full relative bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <!-- Card Header with Background and User Image -->
        <div class="bg-theme-purple flex justify-between items-center border-b-1 w-full border-t-1 rounded-t-lg h-24 relative">
            <!-- <img class="rounded-full absolute top-6 left-4 h-24" alt="user image" src="https://i.pravatar.cc/150"> -->
            <div class="avatar">
                <div class="absolute top-[-34px] left-4 w-24 rounded-full ring ring-gray-800 ring-offset-base-50 ring-offset-2">
                    <img :src="`/storage/${props.userData.avatar}`" class="" />
                </div>
            </div>

            <div class="flex items-center justify-center flex-grow">
                <a href="#" class="text-3xl decoration-theme-purple text-gray-900 dark:text-white font-semibold">
                    {{ props.userData.name }}
                </a>
                <CheckBadgeIcon class="h-6 w-6 text-white" alt="verification badge" />
            </div>
            <!-- Follow Button -->
            <button class="bg-white hover:bg-gray-100 text-gray-600 font-bold py-2 px-5 rounded-full absolute right-4 top-4">
                Follow
            </button>
        </div>

        <!-- User Profile Information -->
        <div class="p-4 mt-2">
            <div class="flex justify-between">
                <div class="flex items-center">
                    <CalendarIcon class="h-4 w-4 text-gray-800 dark:text-gray-400"/>
                    <p class="text-sm dark:text-gray-400 text-gray-800 pl-1">Joined October 2023</p>
                </div>
                <div class="flex  items-center">
                    <EllipsisHorizontalIcon class="h-6 w-6 text-gray-800 dark:text-gray-400"/>
                </div>
            </div>

            <div class="flex space-x-1 justify-between mt-1">
                <p class="text-base text-gray-800 dark:text-white">Followers <a href="#" class="text-theme-purple">0</a></p>
                <p class="text-base text-gray-800 dark:text-white">Following <a href="#" class="text-theme-purple">0</a></p>
                <p class="text-base text-gray-800 dark:text-white">Posts <a href="#" class="text-theme-purple">
                    {{ props.userData.post_count }}
                </a></p>
                <p class="text-base text-gray-800 dark:text-white">Creds <a href="#" class="text-theme-purple">0</a></p>
            </div>

            <!-- About Text -->
            <div class="flex justify-between mt-3">
                <div v-if="props.userData.website" class="flex">
                    <LinkIcon class="h-4 w-4 text-gray-800 dark:text-gray-400"/>
                    <a class="text-sm text-theme-purple pl-1" :href="props.userData.website">

                        {{ props.userData.website }}

                    </a>
                </div>

                <!-- Edit -->
                <div v-if="props.userId === props.userData.id">
                    <PencilIcon @click="openProfileEditModal" class="cursor-pointer h-5 w-5 text-gray-800 dark:text-gray-400"/>
                </div>
            </div>


            <p class="mt-2 text-gray-800 dark:text-white">
                {{ props.userData.description }}
            </p>


            <!-- Badge Section -->
            <!-- <div class="mt-2">
                <CheckBadgeIcon class="h-5 w-5 text-blue-500 mr-1 inline-block" />
                <CheckBadgeIcon class="h-5 w-5 text-blue-500 mr-1 inline-block" />
                 ...more badges as needed
            </div> -->
        </div>
    </div>
</template>
