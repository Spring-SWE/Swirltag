<script setup>
import SwirlBadge from '@/Components/SwirlBadge.vue';
import {
    EllipsisHorizontalIcon,
    ChatBubbleLeftIcon,
    ArrowPathRoundedSquareIcon,
    ArrowUpTrayIcon,
    HandThumbUpIcon,
    HandThumbDownIcon
} from '@heroicons/vue/24/outline'
import {
    CheckBadgeIcon,
} from '@heroicons/vue/24/solid'

</script>
<template>
    <div class="thread col-span-12 lg:col-span-8">
        <!-- Thread -->
        <div class="hover:cursor-pointer thread p-3 rounded border border-gray-100 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-800 shadow">
            <div class="thread-details grid grid-cols-12 gap-4">
                <div class="top-thread-left col-span-11">
                    <div class="flex justify-start pb-3">
                        <ul class="inline-flex space-x-2">
                           <SwirlBadge href="/swirl/anime">~Anime</SwirlBadge>
                           <SwirlBadge href="/swirl/videogames">~Videogames</SwirlBadge>
                        </ul>
                    </div>
                    <div class="flex">
                        <div class="flex-none">
                            <img class="mx-auto rounded-full" src="https://placewaifu.com/image/40">
                        </div>
                        <div class="flex-none">
                            <a href="#" class="ml-1 underline decoration-2 decoration-theme-purple dark:text-white font-semibold">
                                Spring
                            </a>
                        </div>
                        <div class="flex-none">
                            <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
                        </div>
                        <div class="flex-initial">
                            <span class="ml-1 text-sm dark:text-gray-400"><span class="relative bottom-1.5" style="font-size: 1.8rem;">.</span>
                                <span class="relative bottom-0.5 dark:text-gray-400"> 5 hrs ago</span></span>
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
                <div class="thread-text">
                    <p class="mx-auto font-medium pb-3 dark:text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Necessitatibus
                        provident consequuntur in accusantium cumque tempore et odio molestiae voluptatem obcaecati
                        possimus, incidunt iure, deserunt earum? Suscipit eius qui vitae ipsum?</p>
                </div>

                <div class="thread-media mt-1">
                    <img class="border dark:border-gray-800 rounded-lg w-full h-auto max-h-96" src="https://picsum.photos/384">
                </div>

                <div class="quoted-content">
                    <!-- to & do-->
                </div>

                <div class="thread-option-bar mt-2">
                    <div class="flex flex-row gap-2">
                        <div class="vote-thread px-1 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                            <div >
                                <HandThumbUpIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold px-2 text-gray-600 dark:text-white"> 17k</div>
                            <div>
                                <HandThumbDownIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                        </div>

                        <div class="comment-thread px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                            <div>
                                <ChatBubbleLeftIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold text-gray-600 dark:text-white"> 4k</div>
                        </div>

                        <div class="repost-thread px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                            <div>
                                <ArrowPathRoundedSquareIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold text-gray-600 dark:text-white"> 1k</div>
                        </div>
                        <div class="px-1 py-1">
                            <ArrowUpTrayIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                        </div>
                </div>
            </div>

        </div>
    </div>

     <!-- Thread -->
</div></template>
