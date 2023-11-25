<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    user: Object
});

</script>

<template>
    <div class="w-80 overflow-y-auto px-4 py-3 sm:px-0 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 dark:shadow-white/20">

        <div class="flex flex-col items-center">
            <!-- Top section with avatar and follow button -->
            <div class="flex justify-between items-center w-full mb-4 px-4"> <!-- Added horizontal padding -->
                <img class="h-32 w-32 rounded-full shadow-lg" :src="`/storage/${user.avatar}`" alt="User avatar"/>
                <a href="#" class="inline-flex items-center px-4 py-2 text-lg font-medium text-center text-white bg-theme-purple rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-theme-purple dark:hover:bg-blue-700 dark:focus:ring-blue-800">Follow</a>
            </div>

            <!-- Content below avatar and follow button -->
            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ user.name }}</h5>
            <span class="text-sm text-center p-2 text-gray-500 dark:text-gray-400">{{ user.description }}</span>
            <div class="flex space-x-1 justify-between mt-1">
                <p class="text-base text-gray-800 dark:text-white">Followers <span class="font-semibold">{{ user.following_count }}</span></p>
                <p class="text-base text-gray-800 dark:text-white">Following  <span class="font-semibold">{{ user.followers_count }}</span></p>
            </div>
            <div class="flex space-x-1 justify-between mt-1">
                <p class="text-base text-gray-800 dark:text-white">Creds <span class="font-semibold">{{ user.creds }}</span></p>
            </div>
        </div>
    </div>
    </template>


