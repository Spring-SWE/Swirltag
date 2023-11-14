<script setup>
import { BookOpenIcon,
         ChatBubbleBottomCenterIcon,
         PhotoIcon,
         UsersIcon,
         HandThumbUpIcon }
from '@heroicons/vue/24/outline'

const tabs = [
    { name: 'Posts', href: '#', current: true, icon: BookOpenIcon },
    { name: 'Replies', href: '#', current: false, icon: ChatBubbleBottomCenterIcon },
    { name: 'Media', href: '#', current: false, icon: PhotoIcon},
    { name: 'Likes', href: '#', current: false, icon: HandThumbUpIcon},
    { name: 'Swirls', href: '#', current: false, icon: UsersIcon },
]
</script>

<template>
    <div class="lg:border lg:border-gray-300 lg:dark:border-gray-700 lg:dark:bg-gray-800 mt-3">
        <div class="sm:flex sm:flex-wrap sm:items-baseline items-center">
            <div class="mt-4  sm:mt-0">
                <nav class="-mb-px flex space-x-1 flex-wrap lg:space-x-8">
                    <a v-for="tab in tabs"
                        :key="tab.name"
                        :href="tab.href"
                        :class="[tab.current ? 'lg:border-theme-purple lg:bg-theme-purple text-white font-extrabold' : 'border-transparent dark:text-gray-300 text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 p-3 text-sm flex items-center']"
                        :aria-current="tab.current ? 'page' : undefined">
                        <component :is="tab.icon" class="h-6 w-6 shrink-0 mr-2" aria-hidden="true" />
                        {{ tab.name }}
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>
