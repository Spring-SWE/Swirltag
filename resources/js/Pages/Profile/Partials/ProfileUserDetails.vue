<script setup>
import {
    CheckBadgeIcon,
    LinkIcon,
    CalendarIcon,
} from '@heroicons/vue/24/solid'
</script>

<template>
    <div class="w-full relative bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <!-- Card Header with Background and User Image -->
        <div class="bg-theme-purple flex justify-between items-center border-b-1 w-full border-t-1 rounded-t-lg h-24 relative">
            <img class="rounded-full absolute top-6 left-4 h-24" alt="user image" src="https://i.pravatar.cc/40">
            <div class="flex items-center justify-center flex-grow">
                <a href="#" class="text-3xl decoration-theme-purple dark:text-white font-semibold">
                    Spring
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
                    <CalendarIcon class="h-4 w-4 dark:text-gray-400"/>
                    <p class="text-sm text-gray-400 pl-1">Joined October 2023</p>
                </div>
                <div class="flex items-center">
                    <LinkIcon class="h-4 w-4 dark:text-gray-400"/>
                    <a class="text-sm text-theme-purple pl-1" href="https://google.com">Swirltag</a>
                </div>
            </div>

            <div class="flex space-x-2 mt-1">
                <p class="text-sm text-gray-800 dark:text-white">Followers: <a href="#" class="text-theme-purple">1337</a></p>
                <p class="text-sm text-gray-800 dark:text-white">Following: <a href="#" class="text-theme-purple">0</a></p>
            </div>

            <!-- About Text -->
            <p class="mt-1 text-gray-800 dark:text-white">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus atque debitis illum ad, dignissimos nemo! Expedita totam blanditiis, deserunt et distinctio deleniti eum corporis cupiditate, eius quaerat similique dolorum ipsa.
            </p>

            <!-- Badge Section -->
            <div class="mt-2">
                <CheckBadgeIcon class="h-5 w-5 text-blue-500 mr-1 inline-block" />
                <CheckBadgeIcon class="h-5 w-5 text-blue-500 mr-1 inline-block" />
                <!-- ...more badges as needed -->
            </div>
        </div>
    </div>
</template>
