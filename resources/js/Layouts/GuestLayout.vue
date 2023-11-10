<script setup>
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
    Bars3Icon,
    HomeIcon,
    XMarkIcon,
    MagnifyingGlassIcon,
} from '@heroicons/vue/24/outline'

const navigation = [
    { name: 'Home', href: '/dashboard', icon: HomeIcon, current: true },
]

const sidebarOpen = ref(false)

</script>

<template>
    <div class="bg-white dark:bg-gray-900">
        <TransitionRoot as="template" :show="sidebarOpen">
            <Dialog as="div" class="relative z-50 lg:hidden" @close="sidebarOpen = false">
                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                    leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-900/80" />
                </TransitionChild>

                <div class="fixed inset-0 flex">
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                        enter-from="-translate-x-full" enter-to="translate-x-0"
                        leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                        leave-to="-translate-x-full">
                        <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
                                leave-to="opacity-0">
                                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-gray-900 px-6 pb-2 ring-1 ring-white/10">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-auto w-16 md:w-20 lg:w-24" src="http://localhost/storage/media/logo/Original_Logo_Symbol-removebg.png"
                        alt="Swirltag Logo" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <Link :href="item.href"
                                                        :class="[item.current ? 'bg-gray-800 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                    <component :is="item.icon" class="h-6 w-6 shrink-0"
                                                        aria-hidden="true" />
                                                    {{ item.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- Static sidebar for desktop -->
        <div
            class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col border-r border-gray-100 dark:border-r dark:border-slate-700">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg:white dark:bg-gray-900 px-6">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-auto w-16 md:w-20 lg:w-24" src="http://localhost/storage/media/logo/Original_Logo_Symbol-removebg.png"
                        alt="Swirltag Logo" />
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <Link :href="item.href"
                                        :class="[item.current ? 'bg-gray-300 dark:bg-gray-800 dark:text-white' : 'text-gray-400 dark:hover:text-white dark:hover:bg-gray-800 hover:bg-gray-300', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                    <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                    {{ item.name }}
                                    </Link>
                                </li>
                                <li>
                                    <ThemeSwitcher />
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-gray-900 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-gray-400 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
            <div class="flex-1 text-sm font-semibold leading-6 text-white">Home</div>

        </div>

        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white dark:border-slate-700 dark:bg-gray-900 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">

                <!-- Search & Header -->
                <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />

                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                    <form class="relative flex flex-1" action="#" method="GET">
                        <label for="search-field" class="sr-only">Search</label>
                        <MagnifyingGlassIcon class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                            aria-hidden="true" />
                        <input id="search-field"
                            class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 bg-transparent focus:ring-0 sm:text-sm"
                            placeholder="Search..." type="search" name="search" />
                    </form>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <Link href='/login'>
                        <PrimaryButton>Login</PrimaryButton>
                        </Link>

                        <Link href='/register'>
                        <PrimaryButton>Join now</PrimaryButton>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content Area -->
        <div class="bg-white dark:bg-gray-900 pb-10 pt-3 lg:ml-3 lg:pl-72 grid grid-cols-12 gap-4">
            <slot />
        </div>

    </div>
</template>


