<script setup>
import { Link } from '@inertiajs/vue3';
import SwirlBadge from '@/Components/SwirlBadge.vue';
import QuickReply from '@/Pages/Compose/Partials/QuickReply.vue';
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
    threadsDisplayMethod: {
        type: String,
    },
    user: {
        type: String,
    },
    threadData: {
        type: Object
    }
});
</script>

<template>
    <div class="flex border-gray-200 dark:border-gray-700  border-b pt-3 pb-3">
        <ArrowLeftIcon class="h-6 w-6 cursor:pointer text-gray-600 dark:text-white" />
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
                            <Link :href="`/profile/`" class=" ml-1 text-lg cursor-pointer underline decoration-2 decoration-theme-purple dark:text-white
                        font-semibold">
                            Spring
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum hendrerit viverra metus
                        sed finibus. Sed neque dolor, posuere et aliquet id, commodo et nunc. Morbi faucibus neque
                        metus, vel accumsan nisl sagittis vitae. Morbi vel rhoncus ex. Pellentesque id elit nec felis
                        laoreet lacinia sit amet vehicula libero. Praesent congue sem odio. Aliquam a luctus sem.
                        Quisque iaculis aliquam mi ut auctor. Curabitur dictum, justo vel eleifend lacinia, eros enim
                        facilisis eros,
                        id rhoncus felis nunc sed erat. Nam venenatis magna at velit porttitor, sit amet convallis arcu
                        interdum.
                        Quisque semper nisi lectus, sed feugiat enim volutpat at. Mauris eget dui iaculis, pretium massa
                        eget, dictum
                        turpis. Praesent iaculis rhoncus pharetra. Curabitur dictum vulputate ullamcorper. Cras tincidunt
                        diam sapien, nec egestas
                        tellus faucibus sed. Vivamus ullamcorper sem blandit magna bibendum, vitae condimentum ipsum
                        posuere. Pellentesque
                        lacinia, dui at vulputate pretium, nisi lorem porta neque, at volutpat velit sem id turpis. Nam ac
                        eros quam. Nullam
                        gravida convallis nisl a elementum. Integer eu dignissim tellus. Phasellus viverra metus eget orci
                        fermentum gravida.
                    </p>
                </div>

                <div class="thread-media mt-2 pb-2">
                    <img class="rounded-lg mx-auto" style="max-height: 700px;" src="https://placewaifu.com/image/500"
                        alt="">
                </div>

                <div class="flex-initial">
                    <span class="ml-1 text-sm text-center dark:text-gray-400">
                        <span class="relative bottom-1.5" style="font-size: 1.8rem;"></span>
                        <span class="relative bottom-0.5 dark:text-gray-400" style="left:2px;">Posted 5 hours
                            ago</span></span>
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
                            <div class="font-semibold text-gray-600 dark:text-white"> 0
                            </div>
                        </div>

                        <div
                            class="repost-thread px-2 py-1 flex  ">
                            <div>
                                <ArrowPathRoundedSquareIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                            </div>
                            <div class="font-semibold text-gray-600 dark:text-white"> 0 </div>
                        </div>
                        <div class="px-1 py-1">
                            <ArrowUpTrayIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <QuickReply />

    <!-- Start comments -->
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
                <Link :href="`/profile/`" class=" ml-1 text-lg cursor-pointer underline decoration-2 decoration-theme-purple dark:text-white
            font-semibold">
                Spring
                </Link>
            </div>

            <div class="flex-none">
                <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
            </div>

            <div class="flex-initial">
        <span class="ml-1 text-sm text-center dark:text-gray-400">
            <span class="relative bottom-1.5" style="font-size: 1.8rem;"></span>
            <span class="relative bottom-0.5 dark:text-gray-400" style="left:2px;">Posted 5 hours
                ago</span></span>
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
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum hendrerit viverra metus
            sed finibus. Sed neque dolor, posuere et aliquet id, commodo et nunc. Morbi faucibus neque
            metus, vel accumsan nisl sagittis vitae. Morbi vel rhoncus ex. Pellentesque id elit nec felis
            laoreet lacinia sit amet vehicula libero. Praesent congue sem odio. Aliquam a luctus sem.
        </p>
    </div>

    <div class="thread-media mt-2 pb-2">
        <img class="rounded-lg mx-auto" style="max-height: 700px;" src="https://placewaifu.com/image/500/200"
            alt="">
    </div>

    <div class="quoted-content">
        <!-- to & do-->
    </div>

    <div class="thread-option-bar mt-2  p-3">
        <div class="flex flex-row gap-2 justify-between">
            <div
                class="vote-thread px-1 py-1 flex ">
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
                <div class="font-semibold text-gray-600 dark:text-white"> 0
                </div>
            </div>

            <div
                class="repost-thread px-2 py-1 flex ">
                <div>
                    <ArrowPathRoundedSquareIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                </div>
                <div class="font-semibold text-gray-600 dark:text-white"> 0 </div>
            </div>
            <div class="px-1 py-1">
                <ArrowUpTrayIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
            </div>
        </div>
    </div>
</div>
</div>

</div>
<!-- Thread --></template>
