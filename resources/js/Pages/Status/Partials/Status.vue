<script setup>
import { defineProps, onMounted } from 'vue';
import { Link, usePage, } from '@inertiajs/vue3';
import { CheckBadgeIcon, HandThumbUpIcon as SolidHandThumbUpIcon, HandThumbDownIcon as SolidHandThumbDownIcon } from '@heroicons/vue/24/solid';
import {
    EllipsisHorizontalIcon,
    ChatBubbleLeftIcon,
    ArrowPathRoundedSquareIcon,
    ArrowUpTrayIcon,
    HandThumbUpIcon,
    HandThumbDownIcon,
} from '@heroicons/vue/24/outline';
import { useToast } from "vue-toastification";
import UserInformation from './UserInformation.vue';
import axios from 'axios';

const toast = useToast();
const props = defineProps({
    conversation: Array, // The entire conversation up to the current status
    hasBorder: Boolean,
    statusData: Object,
});

// Helper function to update the like/dislike status
const updateStatus = (status, response) => {
    if (response.data.message === 'Status liked') {
        status.like_count++;
        status.userLiked = 1;
    } else if (response.data.message === 'Status unliked') {
        status.like_count--;
        status.userLiked = 0;
    } else if (response.data.message === 'Status liked from dislike') {
        status.like_count += 2;
        status.userLiked = 1;
    } else if (response.data.message === 'Status disliked') {
        status.like_count--;
        status.userLiked = -1;
    } else if (response.data.message === 'Status undisliked') {
        status.like_count++;
        status.userLiked = 0;
    } else if (response.data.message === 'Status disliked from like') {
        status.like_count -= 2;
        status.userLiked = -1;
    }
};

// Function to like a status
const likeStatus = (status_id) => {
    axios.post('/like', { status_id: status_id })
        .then(function (response) {
            if (props.statusData && props.statusData.id === status_id) {
                updateStatus(props.statusData, response);
            }
            if (props.conversation) {
                props.conversation.forEach(status => {
                    if (status.id === status_id) {
                        updateStatus(status, response);
                    }
                });
            }

        })
        .catch(handleError);
};

// Function to dislike a status
const dislikeStatus = (status_id) => {
    axios.post('/dislike', { status_id: status_id })
        .then(function (response) {
            if (props.statusData && props.statusData.id === status_id) {
                updateStatus(props.statusData, response);
            }

            if (props.conversation) {
                props.conversation.forEach(status => {
                    if (status.id === status_id) {
                        updateStatus(status, response);
                    }
                });
            }
        })
        .catch(handleError);
};

// Error handling function
const handleError = (error) => {
    if (error.response?.status === 401) {
        toast.error("You need to log in to do that.");
    } else {
        toast.error("Something went wrong, please try again later.");
    }
    console.log(error);
};

// Set the user like status when the component is mounted.
onMounted(() => {
    const currentUserID = usePage().props.auth.user?.id;

    if (props.statusData && Array.isArray(props.statusData.likes)) {
        // Initialize for a single status
        const likedStatus = props.statusData.likes.find(like => like.user_id === currentUserID);
        if (likedStatus) {
            props.statusData.userLiked = likedStatus.value;
        } else {
            props.statusData.userLiked = 0; // Not liked or disliked
        }
    }

    if (props.conversation && props.conversation.length > 0) {
        props.conversation.forEach(status => {
            if (Array.isArray(status.likes)) {
                const likedStatus = status.likes.find(like => like.user_id === currentUserID);
                if (likedStatus) {
                    status.userLiked = likedStatus.value;
                } else {
                    status.userLiked = 0; // Not liked or disliked
                }
            }
        });
    }
});

</script>


<template >
    <div
        :class="['Status p-3 border-gray-100 dark:border-gray-700 border-b  ', hasBorder ? 'hover:shadow hover:bg-gray-50 dark:hover:bg-gray-800' : '']">
        <div class="flow-root">
            <ul v-if="conversation" role="list" class="-mb-8 list-none">
                <!-- Loop through the entire conversation including the current status -->
                <li v-for="(status, index) in conversation" :key="status.id" class="relative pb-8">
                    <!-- Connector line; not shown after the last item, which is the current status -->
                    <span v-if="index !== conversation.length - 1"
                        class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-300 dark:bg-gray-700"
                        aria-hidden="true"></span>

                    <!-- Status content -->
                    <div :id="`${status.id}`" class="relative flex items-start space-x-3">
                        <div class="relative dropdown dropdown-right dropdown-hover">
                            <img
                                class="h-10 w-10 items-center justify-center rounded-full"
                                :src="`/storage/${status.user.avatar}`" alt="User Avatar" />

                                <div class="dropdown-content z-[100]">
                                    <UserInformation :user="status.user" />
                                </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <!-- Username & Badge -->
                                <div class="text-base flex justify-between items-center">
                                    <div class="flex-none">
                                        <Link :href="`/${status.user.name}`"
                                            class="ml-1 cursor-pointer underline decoration-2 decoration-theme-purple text-gray-900 dark:text-white font-semibold">
                                        {{ status.user.name }}
                                        </Link>
                                    </div>
                                    <div class="flex-none">
                                        <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
                                    </div>
                                    <div class="flex-grow text-right">
                                        <!-- Status Dropdown -->
                                        <div class="dropdown dropdown-left">
                                            <label tabindex="0" class="btn btn-circle btn-ghost text-info">
                                                <EllipsisHorizontalIcon class="h-7 w-7 text-gray-500 inline-block" />
                                            </label>
                                            <div tabindex="0"
                                                class="dropdown-content z-[100] card card-compact w-80 p-2 shadow-2xl dark:bg-gray-800 dark:hover:bg-gray-900 bg-white text-gray-900 dark:text-white">
                                                <ul class="menu rounded-box">
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                            Follow @Spring
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Block @Spring
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Follow ~Swirl
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Block ~Swirl
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Report
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Posted Date -->
                                <p class="text-sm text-gray-500 relative bottom-[13px]">{{ status.created_at_human }}</p>
                            </div>
                            <div
                                class="mb-5 text-base text-gray-700 font-medium dark:text-white whitespace-pre-line overflow-wrap break-words">
                                <p v-html="status.body"></p>
                            </div>
                            <!-- Media area -->
                            <div class="status-media mt-1" v-if="status.media && status.media.length > 0">
                                <img class="rounded-lg mx-auto border border-gray-100 dark:border-gray-700"
                                    style="max-height: 700px;" :src="status.media[0].thumbnail_path" alt="">
                            </div>
                            <!-- Option Bar -->
                            <div class="status-option-bar mt-2">
                                <div class="flex flex-row gap-3">
                                    <div
                                        class="vote-status cursor-pointer px-1 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">

                                        <!-- Like -->
                                        <div v-if="status.userLiked === 1">
                                            <SolidHandThumbUpIcon @click="likeStatus(status.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-gray-600 dark:hover:text-slate-400 text-green-700 dark:text-green-700" />
                                        </div>

                                        <div v-else-if="status.userLiked === -1">
                                            <HandThumbUpIcon @click="likeStatus(status.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-green-700 dark:hover:text-green-700 text-gray-600 dark:text-slate-400" />
                                        </div>

                                        <div v-else>
                                            <HandThumbUpIcon @click="likeStatus(status.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-green-700 dark:hover:text-green-700 text-gray-600 dark:text-slate-400" />
                                        </div>


                                        <div class="font-semibold px-2 text-gray-600 dark:text-white"> {{ status.like_count
                                        }}</div>



                                        <!-- Dislike -->
                                        <div v-if="status.userLiked === -1">
                                            <SolidHandThumbDownIcon @click="dislikeStatus(status.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-gray-600 dark:hover:text-slate-400 text-red-700 dark:text-red-700" />
                                        </div>

                                        <div v-else-if="status.userLiked === 1">
                                            <HandThumbDownIcon @click="dislikeStatus(status.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-red-700 dark:hover:text-red-700 text-gray-600 dark:text-slate-400" />
                                        </div>

                                        <div v-else>
                                            <HandThumbDownIcon @click="dislikeStatus(status.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-red-700 dark:hover:text-red-700 text-gray-600 dark:text-slate-400" />
                                        </div>




                                    </div>
                                    <Link :href="`/status/${status.id}#${status.id}`">
                                    <div
                                        class="comment-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                                        <div>
                                            <ChatBubbleLeftIcon
                                                class="h-6 w-6 text-gray-600 dark:text-slate-400 hover:scale-125 transition-transform hover:text-theme-purple dark:hover:text-theme-purple" />
                                        </div>
                                        <div class="font-semibold text-gray-600 dark:text-white ml-1">{{ status.reply_count
                                        }}</div>
                                    </div>
                                    </Link>
                                    <div
                                        class="repost-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                                        <div>
                                            <ArrowPathRoundedSquareIcon
                                                class="h-6 w-6 text-gray-600 dark:text-slate-400 hover:scale-125 transition-transform hover:text-theme-purple dark:hover:text-theme-purple" />
                                        </div>
                                        <div class="font-semibold text-gray-600 dark:text-white ml-1">{{ status.share_count
                                        }}</div>
                                    </div>
                                    <div class="px-1 py-1">
                                        <ArrowUpTrayIcon
                                            class="h-6 w-6 text-gray-600 dark:text-slate-400 hover:scale-125 transition-transform hover:text-theme-purple dark:hover:text-theme-purple" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- Single Status -->
            <template v-else>
                <li :id="`${statusData.id}`" class="relativ cursor-pointer list-none">
                    <!-- Status content -->
                    <div class="relative flex items-start space-x-3">
                        <div class="relative dropdown dropdown-right dropdown-hover">
                            <img
                                class="h-10 w-10 items-center justify-center rounded-full"
                                :src="`/storage/${statusData.user.avatar}`" alt="User Avatar" />

                                <div class="dropdown-content z-[100]">
                                    <UserInformation :user="statusData.user" />
                                </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <!-- Username & Badge -->
                                <div class="text-base flex justify-between items-center">
                                    <div class="flex-none">
                                        <Link :href="`/${statusData.user.name}`"
                                            class="ml-1 text-gray-900 cursor-pointer underline decoration-2 decoration-theme-purple dark:text-white font-semibold">
                                        {{ statusData.user.name }}
                                        </Link>
                                    </div>
                                    <div class="flex-none">
                                        <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
                                    </div>
                                    <div class="flex-grow text-right">
                                        <!-- Status Dropdown -->
                                        <div class="dropdown dropdown-left">
                                            <label tabindex="0" class="btn btn-circle btn-ghost text-info">
                                                <EllipsisHorizontalIcon class="h-7 w-7 text-gray-500 inline-block" />
                                            </label>
                                            <div tabindex="0"
                                                class="dropdown-content z-[100] card card-compact w-80 p-2 shadow-2xl dark:bg-gray-800 dark:hover:bg-gray-900 bg-white text-gray-900 dark:text-white">
                                                <ul class="menu rounded-box">
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                            </svg>
                                                            Follow @Spring
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Block @Spring
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Follow ~Swirl
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Block ~Swirl
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                                            </svg>
                                                            Report
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Posted Date -->
                                <p class=" text-sm text-gray-500 relative bottom-[13px]">{{ statusData.created_at_human }}
                                </p>
                            </div>
                            <Link :href="`/status/${statusData.id}#${statusData.id}`">
                            <div
                                class="mb-5 text-base text-gray-900 font-medium dark:text-white whitespace-pre-line overflow-wrap break-words">
                                <p v-html="statusData.body"></p>
                            </div>
                            <!-- Media area -->
                            <div class="status-media mt-1" v-if="statusData.media && statusData.media.length > 0">
                                <img class="rounded-lg mx-auto border border-gray-100 dark:border-gray-700"
                                    style="max-height: 700px;" :src="statusData.media[0].thumbnail_path" alt="">
                            </div>
                            </Link>
                            <!-- Option Bar -->
                            <div class="status-option-bar mt-2">
                                <div class="flex flex-row gap-3">
                                    <div
                                        class="vote-status px-1 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">

                                        <!-- Like -->
                                        <div v-if="props.statusData.userLiked === 1">
                                            <SolidHandThumbUpIcon @click="likeStatus(statusData.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-gray-600 dark:hover:text-slate-400 text-green-700 dark:text-green-700" />
                                        </div>

                                        <div v-else-if="props.statusData.userLiked === -1">
                                            <HandThumbUpIcon @click="likeStatus(statusData.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-green-700 dark:hover:text-green-700 text-gray-600 dark:text-slate-400" />
                                        </div>

                                        <div v-else>
                                            <HandThumbUpIcon @click="likeStatus(statusData.id)"
                                                class="h-6 w-6 hover:scale-125 transition-transform hover:text-green-700 dark:hover:text-green-700 text-gray-600 dark:text-slate-400" />
                                        </div>



                                        <div class="font-semibold px-2 text-gray-600 dark:text-white"> {{
                                            statusData.like_count }}</div>
                                        <div>



                                            <!-- Dislike -->
                                            <div v-if="props.statusData.userLiked === -1">
                                                <SolidHandThumbDownIcon @click="dislikeStatus(statusData.id)"
                                                    class="h-6 w-6 hover:scale-125 transition-transform hover:text-gray-600 dark:hover:text-slate-400 text-red-700 dark:text-red-700" />
                                            </div>

                                            <div v-else-if="props.statusData.userLiked === 1">
                                                <HandThumbDownIcon @click="dislikeStatus(statusData.id)"
                                                    class="h-6 w-6 hover:scale-125 transition-transform hover:text-red-700 dark:hover:text-red-700 text-gray-600 dark:text-slate-400" />
                                            </div>

                                            <div v-else>
                                                <HandThumbDownIcon @click="dislikeStatus(statusData.id)"
                                                    class="h-6 w-6 hover:scale-125 transition-transform hover:text-red-700 dark:hover:text-red-700 text-gray-600 dark:text-slate-400" />
                                            </div>

                                        </div>
                                    </div>
                                    <Link :href="`/status/${statusData.id}#${statusData.id}`">
                                    <div
                                        class="comment-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                                        <div>
                                            <ChatBubbleLeftIcon
                                                class="h-6 w-6 text-gray-600 dark:text-slate-400 hover:scale-125 transition-transform hover:text-theme-purple dark:hover:text-theme-purple" />
                                        </div>
                                        <div class="font-semibold text-gray-600 dark:text-white ml-1">{{
                                            statusData.reply_count }}</div>
                                    </div>
                                    </Link>
                                    <div
                                        class="repost-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                                        <div>
                                            <ArrowPathRoundedSquareIcon
                                                class="h-6 w-6 text-gray-600 dark:text-slate-400 hover:scale-125 transition-transform hover:text-theme-purple dark:hover:text-theme-purple" />
                                        </div>
                                        <div class="font-semibold text-gray-600 dark:text-white ml-1">{{
                                            statusData.share_count }}</div>
                                    </div>
                                    <div class="px-1 py-1">
                                        <ArrowUpTrayIcon
                                            class="h-6 w-6 text-gray-600 dark:text-slate-400 hover:scale-125 transition-transform hover:text-theme-purple dark:hover:text-theme-purple" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </template>
        </div>
    </div>
</template>

