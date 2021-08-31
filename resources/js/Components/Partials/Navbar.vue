<template>
    <div class="text-blueGray-100 relative z-50">
        <div class="max-w-6xl px-5 py-6 mx-auto flex items-center justify-between">
            <Link :href="route('home')" class="cursor-pointer group flex items-center pr-2 lg:pr-8 lg:px-6 focus:outline-none">
                <cover customClass="block h-10 w-auto" fill="group-hover:text-blueGray-400" />
            </Link>

            <div v-if="displayButton">
                <div class="flex space-x-4" v-if="$page.props.auth.user">
                    <!-- Profile dropdown -->
                    <Menu as="div" class="ml-3 relative">
                        <div>
                            <MenuButton class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-10 w-10 rounded-full" :src='"/" + $page.props.auth.user.avatar' :alt="$page.props.auth.user.name" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <MenuItem v-slot="{ active }">
                                    <Link :href="route('profile')" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                        Your Profile
                                    </Link>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <form method="POST" @submit.prevent="logout">
                                        <button type="submit" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                            Sign out
                                        </button>
                                    </form>

                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>

                <div class="flex space-x-4" v-else>
                    <button-link
                        :href="route('register')"
                    >
                        Register
                    </button-link>

                    <button-link
                        :href="route('login')"
                    >
                        Login
                    </button-link>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import ButtonLink from "../Buttons/ButtonLink";
import Button from "../Buttons/Button";
import Cover from "../Assets/Logo/LogoCover";
import ButtonNormal from "../Buttons/ButtonNormal";
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
export default {
    name: "Navbar",
    props: {
        displayButton: {
            default: true,
            type: Boolean
        }
    },
    components: {
        ButtonNormal,
        Link,
        ButtonLink,
        Button,
        Cover,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
    },
    computed: {
        classes() {
            return this.processing ? 'opacity-25' : ''
        }
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'));
        },
    }
}
</script>
