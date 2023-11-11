
<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {
    ArrowTrendingUpIcon,
} from '@heroicons/vue/24/outline'
</script>

<template>
<!-- Thread Trending Tab-->
    <div
        class="w-full max-w-md p-4 bg-white border-gray-100 shadow rounded-lg  sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center mb-3">
            <ArrowTrendingUpIcon class="h-10 w-10 pr-2 flex-none text-theme-purple" />
            <h5 class="text-2xl grow font-bold leading-none text-gray-900 dark:text-white">Trending Swirls
            </h5>
            <a href="#" class="text-sm flex-none font-medium text-blue-600 hover:underline dark:text-blue-500">
                More
            </a>
        </div>
        <div class="flow-root">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="https://i.pravatar.cc/40" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Anime & Manga
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Lorem ipsum dolor, sit amet
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <PrimaryButton>Join</PrimaryButton>
                        </div>
                    </div>
                </li>

                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="https://i.pravatar.cc/40" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Videogames
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Lorem ipsum dolor, sit amet
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <PrimaryButton>Join</PrimaryButton>
                        </div>
                    </div>
                </li>


                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="https://i.pravatar.cc/40" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Technology
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Lorem ipsum dolor, sit amet
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <PrimaryButton>Join</PrimaryButton>
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="https://i.pravatar.cc/40" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Fandoms
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Lorem ipsum dolor, sit amet
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <PrimaryButton>Join</PrimaryButton>
                        </div>
                    </div>
                </li>
                <li class="py-3 sm:py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-8 h-8 rounded-full" src="https://i.pravatar.cc/40" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Apple
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Lorem ipsum dolor, sit amet
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            <PrimaryButton>Join</PrimaryButton>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>

</template>
