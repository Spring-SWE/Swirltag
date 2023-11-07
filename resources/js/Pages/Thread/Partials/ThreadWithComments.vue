<script setup>
import { Link } from '@inertiajs/vue3';
import SwirlBadge from '@/Components/SwirlBadge.vue';
import QuickReply from '@/Pages/Compose/Partials/QuickReply.vue';
import Comments from '@/Pages/Thread/Partials/Comments.vue';
import {
    EllipsisHorizontalIcon,
    ChatBubbleLeftIcon,
    ArrowPathRoundedSquareIcon,
    ArrowUpTrayIcon,
    HandThumbUpIcon,
    HandThumbDownIcon,
    ArrowLeftIcon

} from '@heroicons/vue/24/outline'
import {
    CheckBadgeIcon,
} from '@heroicons/vue/24/solid'

const props = defineProps({
    thread: {
        type: Object
    },
    comments: {
        type: Array
    },
});

function goBack() {
  history.back();
}

</script>

<template>
    <div class="flex border-gray-200 dark:border-gray-700 border-r pt-3">
        <div class="arrow-container hover:bg-gray-200 dark:hover:bg-gray-600 hover:rounded-full p-2 cursor-pointer"
             @click="goBack()"
        >
            <ArrowLeftIcon class="h-5 w-5 text-gray-600 dark:text-white" />
        </div>
        <p class="dark:text-white text-theme-purple font-extrabold text-2xl ml-5">
            Post
        </p>
    </div>
    <!-- Thread -->
    <div class="thread p-3 border-gray-200 border-r dark:border-gray-700">
        <div>
            <div class="thread-details grid grid-cols-12 gap-4">
                <div class="top-thread-left col-span-11">
                    <div class="flex justify-start pb-3">
                        <ul class="inline-flex space-x-2">
                            <!-- <SwirlBadge href="/swirl/anime">~Anime</SwirlBadge>
                           <SwirlBadge href="/swirl/videogames">~Videogames</SwirlBadge> -->
                        </ul>
                    </div>
                    <div class="flex">
                        <div class="flex-none">
                            <img class="mx-auto rounded-full" src="https://placewaifu.com/image/40">
                        </div>
                        <div class="flex-none ml-3">
                            <Link :href="`/profile/${props.thread.user.name}`" class=" ml-1 text-lg cursor-pointer underline decoration-2 decoration-theme-purple dark:text-white
                        font-semibold">
                            {{ props.thread.user.name }}
                            </Link>
                        </div>
                        <div class="flex-none">
                            <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
                        </div>
                    </div>

                </div>
                <div class="top-thread-right col-span-1">
                    <div class="justify-self-auto">
                        <EllipsisHorizontalIcon class="h-7 w-7 text-gray-500" />
                    </div>
                </div>
            </div>
            <div class="thread-content justify-center items-center">
                <div class="thread-text whitespace-pre-line overflow-wrap break-words">
                    <p class="mx-auto mt-2 font-medium pb-3 dark:text-white">
                        {{ props.thread.body }}
                    </p>
                </div>

                <div class="thread-media mt-2 pb-2">
                    <img class="rounded-lg mx-auto"
                     style="max-height: 700px;"
                    v-if="props.thread.media && props.thread.media.length > 0"
                    :src="props.thread.media[0].thumbnail_path" alt="User media">
                </div>

                <div class="flex-initial">
                    <span class="ml-1 text-sm text-center dark:text-gray-400">

                        <span class="relative bottom-0.5 dark:text-gray-400" style="left:2px;">
                            Posted {{ props.thread.created_at_human }}
                        </span></span>
                </div>

                <div class="quoted-content">
                    <!-- to & do-->
                </div>

                <div class="thread-option-bar mt-2 border border-l-0 border-r-0 p-3 border-gray-200 dark:border-gray-700">
                    <div class="flex flex-row gap-2 justify-between">
                        <div
                            class="vote-thread px-1 py-1 flex  ">
                            <div>
                                <HandThumbUpIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold px-2 text-gray-600 dark:text-white"> 17k</div>
                            <div>
                                <HandThumbDownIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                        </div>

                        <div
                            class="comment-thread px-2 py-1 flex ">
                            <div>
                                <ChatBubbleLeftIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold text-gray-600 dark:text-white ml-1"> {{ props.thread.comment_count }}
                            </div>
                        </div>

                        <div
                            class="repost-thread px-2 py-1 flex  ">
                            <div>
                                <ArrowPathRoundedSquareIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold text-gray-600 dark:text-white ml-1"> {{ props.thread.repost_count }} </div>
                        </div>
                        <div class="px-1 py-1">
                            <ArrowUpTrayIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Quick reply Component -->
    <QuickReply
     :threadId="props.thread.id"/>

    <!-- Comments Component -->
    <Comments v-for="(comment, index) in props.comments"
                :key="comment.id"
                :user="comment.user.name"
                :commentData="comment"
    />


</div>
<!-- Thread --></template>
