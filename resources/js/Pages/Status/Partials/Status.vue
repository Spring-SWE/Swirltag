<script setup>
import { defineProps, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { CheckBadgeIcon } from '@heroicons/vue/24/solid';
import {
  EllipsisHorizontalIcon,
  ChatBubbleLeftIcon,
  ArrowPathRoundedSquareIcon,
  ArrowUpTrayIcon,
  HandThumbUpIcon,
  HandThumbDownIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
  conversation: Array, // The entire conversation up to the current status
  hasBorder: Boolean,
  statusData: Object,
});

</script>

<template>
    <div :class="['Status p-3 border-gray-100 dark:border-gray-700 border-b  ', hasBorder ? 'shadow hover:bg-gray-50 dark:hover:bg-gray-800' : '']">
      <div class="flow-root">
        <ul v-if="conversation" role="list" class="-mb-8 list-none">
          <!-- Loop through the entire conversation including the current status -->
          <li v-for="(status, index) in conversation" :key="status.id" class="relative pb-8">
            <Link :id="`${status.id}`" :href="`/status/${status.id}#${status.id}`">

                <!-- Connector line; not shown after the last item, which is the current status -->
            <span v-if="index !== conversation.length - 1"
                  class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700"
                  aria-hidden="true"></span>

            <!-- Status content -->
            <div class="relative flex items-start space-x-3">
              <div class="relative">
                <img class="h-10 w-10 items-center justify-center rounded-full"
                     :src="'https://i.pravatar.cc/100'"
                     alt="User Avatar" />
              </div>
              <div class="min-w-0 flex-1">
                <div>
                  <!-- Username & Badge -->
                  <div class="text-base flex justify-between items-center">
                    <div class="flex-none">
                      <Link :href="`/${status.user.name}`" class="ml-1 cursor-pointer underline decoration-2 decoration-theme-purple dark:text-white font-semibold">
                        {{ status.user.name }}
                      </Link>
                    </div>
                    <div class="flex-none">
                      <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
                    </div>
                    <div class="flex-grow text-right">
                      <EllipsisHorizontalIcon class="h-7 w-7 text-gray-500 inline-block" />
                    </div>
                  </div>
                  <!-- Posted Date -->
                  <p class="mt-0.5 text-sm text-gray-500">{{ status.created_at_human }}</p>
                </div>
                <div class="mt-2 text-base text-gray-700 font-medium dark:text-white whitespace-pre-line overflow-wrap break-words">
                  <p>{{ status.body }}</p>
                </div>
                <!-- Media area -->
                <div class="status-media mt-1" v-if="status.media && status.media.length > 0">
                  <img class="rounded-lg mx-auto" style="max-height: 700px;"
                       :src="status.media[0].thumbnail_path" alt="">
                </div>
                <!-- Option Bar -->
                <div class="status-option-bar mt-2">
                  <div class="flex flex-row gap-3">
                    <div class="vote-status px-1 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                      <div>
                        <HandThumbUpIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                      <div class="font-semibold px-2 text-gray-600 dark:text-white"> 17k</div>
                      <div>
                        <HandThumbDownIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                    </div>
                    <div class="comment-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                      <div>
                        <ChatBubbleLeftIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                      <div class="font-semibold text-gray-600 dark:text-white ml-1">{{ status.reply_count }}</div>
                    </div>
                    <div class="repost-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                      <div>
                        <ArrowPathRoundedSquareIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                      <div class="font-semibold text-gray-600 dark:text-white ml-1">{{ status.share_count }}</div>
                    </div>
                    <div class="px-1 py-1">
                      <ArrowUpTrayIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </Link>
          </li>
        </ul>
        <!-- Single Status -->
        <template v-else>
            <Link :id="`${statusData.id}`" :href="`/status/${statusData.id}#${statusData.id}`">
            <li class="relativ cursor-pointer list-none">
            <!-- Status content -->
            <div class="relative flex items-start space-x-3">
              <div class="relative">
                <img class="h-10 w-10 items-center justify-center rounded-full"
                     :src="'https://i.pravatar.cc/100'"
                     alt="User Avatar" />
              </div>
              <div class="min-w-0 flex-1">
                <div>
                  <!-- Username & Badge -->
                  <div class="text-base flex justify-between items-center">
                    <div class="flex-none">
                      <Link :href="`/${statusData.user.name}`" class="ml-1 cursor-pointer underline decoration-2 decoration-theme-purple dark:text-white font-semibold">
                        {{ statusData.user.name }}
                      </Link>
                    </div>
                    <div class="flex-none">
                      <CheckBadgeIcon class="h-6 w-6 text-theme-purple" />
                    </div>
                    <div class="flex-grow text-right">
                      <EllipsisHorizontalIcon class="h-7 w-7 text-gray-500 inline-block" />
                    </div>
                  </div>
                  <!-- Posted Date -->
                  <p class="mt-0.5 text-sm text-gray-500">{{ statusData.created_at_human }}</p>
                </div>
                <div class="mt-2 text-base text-gray-700 font-medium dark:text-white whitespace-pre-line overflow-wrap break-words">
                  <p>{{ statusData.body }}</p>
                </div>
                <!-- Media area -->
                <div class="status-media mt-1" v-if="statusData.media && statusData.media.length > 0">
                  <img class="rounded-lg mx-auto" style="max-height: 700px;"
                       :src="statusData.media[0].thumbnail_path" alt="">
                </div>
                <!-- Option Bar -->
                <div class="status-option-bar mt-2">
                  <div class="flex flex-row gap-3">
                    <div class="vote-status px-1 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                      <div>
                        <HandThumbUpIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                      <div class="font-semibold px-2 text-gray-600 dark:text-white"> 17k</div>
                      <div>
                        <HandThumbDownIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                    </div>
                    <div class="comment-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                      <div>
                        <ChatBubbleLeftIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                      <div class="font-semibold text-gray-600 dark:text-white ml-1">{{ statusData.reply_count }}</div>
                    </div>
                    <div class="repost-status px-2 py-1 flex dark:border dark:border-gray-800 rounded-2xl dark:bg-gray-800">
                      <div>
                        <ArrowPathRoundedSquareIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                      </div>
                      <div class="font-semibold text-gray-600 dark:text-white ml-1">{{ statusData.share_count }}</div>
                    </div>
                    <div class="px-1 py-1">
                      <ArrowUpTrayIcon class="h-6 w-6 text-gray-600 dark:text-slate-400" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </Link>
        </template>
      </div>
    </div>
  </template>

