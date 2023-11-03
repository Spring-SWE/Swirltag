
<script setup>
import {
    CheckBadgeIcon,
    LinkIcon,
    CalendarIcon,
} from '@heroicons/vue/24/solid'
</script>

<template>
    <div
        class="w-full relative bg-white border border-gray-200 rounded-t-lg rounded-l-lg rounded-r-lg round-b-none shadow  dark:bg-gray-800 dark:border-gray-700">
        <div class="bg-theme-purple flex border-b-1 w-full p-0 m-0 border-t-1 rounded-t-lg h-24">
            <img class="rounded-full absolute top-6 left-4 h-24" alt="user image" src="https://placewaifu.com/image/40">
            <div class="username flex mx-auto mt-1">
                <div class="flex-none">
                    <a href="#" class="ml-1 text-3xl decoration-theme-purple dark:text-white font-semibold">
                        Spring
                    </a>
                </div>
                <div class="flex-none">
                    <CheckBadgeIcon class="h-6 w-6 mt-1 text-white" alt="verification badge" />
                </div>

            </div>

        </div>

        <div class="user-profile-info absolute top-32 w-full">
            <div class="flex justify-around">
                <div class="flex">
                    <CalendarIcon class="h-4 w-4 dark:text-gray-400 mt-1"></CalendarIcon>
                    <p class="text-sm text-gray-400 pl-1">Joined October 2023</p>
                </div>
                <div class="flex">
                    <LinkIcon class="h-4 w-4 dark:text-gray-400 mt-1"> </LinkIcon>
                    <a class = "text-sm grow cursor-pointer text-theme-purple pl-1" href="google.com">Swirltag</a>
                </div>
            </div>
            <div>
                <div class="flex space-x-2 pl-8 mt-1">
                    <p class="flex-initial text-sm text-white">Followers: <a href="#">1337</a> </p>
                    <p class="flex-initial text-sm text-white">Following: <a href="#">0</a></p>
                </div>
            </div>
            <p class="mt-1 p-2 text-white">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus atque debitis illum ad, dignissimos nemo! Expedita totam blanditiis, deserunt et distinctio deleniti eum corporis cupiditate, eius quaerat similique dolorum ipsa.
            </p>
        </div>
        <div class="flex h-80">

        </div>
    </div>
</template>
