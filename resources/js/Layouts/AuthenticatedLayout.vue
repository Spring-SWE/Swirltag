<script setup>
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import CreateStatusButton from '@/Pages/Compose/Partials/CreateStatusButton.vue';
import { Link, usePage, } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import { ref, watch, onMounted } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
    Bars3Icon,
    PlusIcon,
    EnvelopeIcon,
    HeartIcon,
    HomeIcon,
    UsersIcon,
    XMarkIcon,
    MagnifyingGlassIcon,
    BellIcon,
    UserIcon,
} from '@heroicons/vue/24/outline'

const sidebarOpen = ref(false)
const page = usePage().props;
const userName = page.auth.user.name;
const userAvatar = page.auth.user.avatar;
const navigation = [
    { name: 'Dashboard', href: '/dashboard', icon: HomeIcon, current: false },
    { name: 'Notifications', href: '/notifications', icon: BellIcon, current: false },
    { name: 'Swirls', href: '#', icon: UsersIcon, current: false },
    { name: 'Messages', href: '#', icon: EnvelopeIcon, current: false },
    { name: 'Profile', href: `/${userName}`, icon: UserIcon, current: false },
]
const notificationCount = ref(0);
const toast = useToast();

//Methods.
navigation.forEach(item => {
    if (item.name.toLowerCase() === 'profile') {
        item.current = page.ziggy.location.includes(item.name.toLowerCase());
    } else {
        item.current = page.ziggy.location.endsWith(item.href);
    }
});

watch(() => usePage().props.flash, flash => {
    let toastId = null;

    if (flash.message) {
        toast(flash.message);
    }
    if (flash.success) {
        toast.success(flash.success);
    }
    if (flash.error) {
        toast.error(flash.error);
    }

    if (toastId !== null) {
        setTimeout(() => toast.dismiss(toastId), 5000)
    }
}, { deep: true })


const fetchInitialNotifications = () => {
    axios.get('/getunreadnotifications')
        .then(response => {
            notificationCount.value = response.data.unreadCount;
        })
        .catch(error => {
            console.error('Error fetching notifications:', error);
            // Handle the error as needed, e.g., showing a toast notification
        });
};

onMounted(() => {
    fetchInitialNotifications();
    Echo.private(`App.Models.User.${page.auth.user.id}`)
        .notification((notification) => {
            if (notification.liked_by !== page.auth.user.id) {
                console.log(notification);
                notificationCount.value++;
            }
        });
});

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

                            <!-- Sidebar component for mobile -->
                            <div
                                class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-gray-900 px-6 pb-2 ring-1 ring-white/10">
                                <div class="flex h-16 shrink-0 items-center">
                                    <img class="h-auto w-16 md:w-20 lg:w-24"
                                        src="http://localhost/storage/media/logo/Original_Logo_Symbol-removebg.png"
                                        alt="Swirltag Logo" />
                                </div>
                                <nav class="flex flex-1 flex-col">
                                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                        <li>
                                            <ul role="list" class="-mx-2 space-y-1">
                                                <li v-for="item in navigation" :key="item.name">
                                                    <Link :href="item.href"
                                                        :class="[item.current ? 'bg-gray-300 text-gray-800 dark:bg-gray-800 dark:text-white' : 'text-gray-400 dark:hover:text-white dark:hover:bg-gray-800 hover:bg-gray-300', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                                    <component :is="item.icon" class="h-6 w-6 shrink-0"
                                                        aria-hidden="true" />
                                                    {{ item.name }}
                                                    </Link>
                                                </li>
                                                <li>
                                                    <ThemeSwitcher />
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="-mx-5 mt-auto text-center">
                                            <CreateStatusButton />
                                        </li>
                                        <!-- Dropdown component -->
                                        <li class="-mx-6 mt-auto w-">
                                            <Dropdown width="64">
                                                <template #trigger>
                                                    <button href="#"
                                                        class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold min-w-full leading-6 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-800">
                                                        <img class="h-8 w-8 rounded-full bg-gray-800"
                                                            :src="`/storage/${userAvatar}`" alt="" />
                                                        <span class="sr-only">Your profile</span>
                                                        <span aria-hidden="true">{{ userName }}</span>
                                                    </button>
                                                </template>

                                                <template #content>
                                                    <!-- Dropdown menu -->
                                                    <div
                                                        class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                                            <li>
                                                                <DropdownLink href="/settings">Settings</DropdownLink>
                                                            </li>
                                                            <li>
                                                                <Link
                                                                    class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                                                    href="/logout" method="post" as="button" type="button">
                                                                Logout</Link>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </template>
                                            </Dropdown>
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
                    <img class="h-auto w-16 md:w-20 lg:w-24"
                        src="http://localhost/storage/media/logo/Original_Logo_Symbol-removebg.png" alt="Swirltag Logo" />
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <Link :href="item.href"
                                        :class="[item.current ? 'bg-gray-300 text-gray-800 dark:bg-gray-800 dark:text-white' : 'text-gray-600 dark:hover:text-white dark:hover:bg-gray-800 hover:bg-gray-300', 'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold']">
                                    <component :is="item.icon" class="h-6 w-6 shrink-0" aria-hidden="true" />
                                    {{ item.name }}
                                    <!-- Notification Badge -->
                                    <span v-if="notificationCount > 0 && item.name === 'Notifications'"
                                        class="inline-flex items-center justify-center px-2 py-1 ml-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                        {{ notificationCount }}
                                    </span>
                                    </Link>
                                </li>
                                <li>
                                    <ThemeSwitcher />
                                </li>
                            </ul>
                        </li>
                        <li class="-mx-5 mt-auto text-center">
                            <CreateStatusButton />
                        </li>
                        <!-- Dropdown component -->
                        <li class="-mx-6 mt-auto w-">
                            <Dropdown width="64">
                                <template #trigger>
                                    <button href="#"
                                        class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold min-w-full leading-6 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-800">
                                        <img class="h-8 w-8 rounded-full bg-gray-800" :src="`/storage/${userAvatar}`"
                                            alt="" />
                                        <span class="sr-only">Your profile</span>
                                        <span aria-hidden="true">{{ userName }}</span>
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Dropdown menu -->
                                    <div class="z-10 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                            <li>
                                                <DropdownLink href="/settings">Settings</DropdownLink>
                                            </li>
                                            <li>
                                                <Link
                                                    class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                                    href="/logout" method="post" as="button" type="button">Logout</Link>
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                            </Dropdown>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="sticky top-0 z-40 flex items-center gap-x-6 dark:bg-gray-900 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
            <button type="button" class="-m-2.5 p-2.5 text-gray-600 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>
            <div class="flex-1 text-sm font-semibold leading-6 dark:text-white">Home</div>
            <a href="#">
                <span class="sr-only">Your profile</span>
                <img class="h-8 w-8 rounded-full bg-gray-800" :src="`/storage/${userAvatar}`" alt="" />
            </a>
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
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Support</span>
                            <HeartIcon class="h-6 w-6 text-theme-purple" aria-hidden="true" />
                        </button>
                        <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">New Swirl</span>
                            <PlusIcon class="h-6 w-6 text-gray-500" aria-hidden="true" />
                        </button>
                    </div>
                    <!-- Toast -->

                </div>
            </div>
        </div>
        <!-- Main content Area -->
        <div class="bg-white dark:bg-gray-900 pb-10 lg:ml-3 lg:pl-72 grid grid-cols-12 gap-4">
            <slot />
        </div>

    </div>
</template>


