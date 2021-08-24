<template>
    <div class="min-h-screen bg-blueGray-900">
        <Disclosure as="header" class="bg-blueGray-700 shadow py-1" v-slot="{ open }">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
                <div class="relative h-16 flex justify-between">
                    <div class="relative z-10 px-2 flex lg:px-0">
                        <Link :href="route('panel.feed.show')" class="flex items-center focus:outline-none group cursor-pointer">
                            <cover class="block h-8 w-auto" fill="group-hover:text-blueGray-400" />
                        </Link>
                    </div>
                    <div class="relative z-10 flex items-center lg:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton class="rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900">
                            <span class="sr-only">Open menu</span>
                            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                    <div class="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center">
                        <!-- Profile dropdown -->
                        <Menu as="div" class="flex-shrink-0 relative ml-4">
                            <div>
                                <MenuButton class="bg-blueGray-700 rounded-full flex focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-700 ring-opacity-50">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" :src="user.profile_photo_url" :alt="user.name" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <Link
                                            :href="item.href"
                                            :method="item.method"
                                            :class="[active ? 'bg-gray-100' : '', 'cursor-pointer block py-2 px-4 text-sm text-gray-700']"
                                        >
                                            {{ item.name }}
                                        </Link>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>

                        <Button type="button" class="ml-6" @click="showModal">
                            Upload
                        </Button>
                    </div>
                </div>
            </div>

            <DisclosurePanel as="nav" class="lg:hidden" aria-label="Global">
                <div class="border-t border-gray-200 pt-4 pb-3">
                    <div class="px-4 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="user.profile_photo_url" alt="" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-100">{{ user.name }}</div>
                            <div class="text-sm font-medium text-gray-200">{{ user.email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <Link
                            v-for="item in userNavigation"
                            :key="item.name"
                            :href="item.href"
                            :method="item.method"
                            class="block rounded-md py-2 px-3 text-base font-medium text-gray-200 hover:bg-gray-50 hover:text-gray-900">
                            {{ item.name }}
                        </Link>
                        <button type="button" class="block rounded-md py-2 px-3 text-base font-medium text-gray-200 hover:bg-gray-50 hover:text-gray-900" @click="showModal">
                            Upload
                        </button>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="sm:px-6 lg:max-w-7xl lg:px-4 lg:grid lg:grid-cols-8 lg:gap-8">
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-2">
                    <nav class="sticky bg-blueGray-700 p-4 rounded-md space-y-1.5">
                        <Link v-for="item in subNavigation" :key="item.name" :href="item.href" :class="[route().current() === item.route ? 'bg-blueGray-200 text-blueGray-900' : 'text-blueGray-100 hover:bg-blueGray-200 hover:text-blueGray-900', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md transition duration-300 ease-in-out']" :aria-current="route().current() === item.route ? 'page' : undefined">
                            <component :is="item.icon" :class="[route().current() === item.route ? 'text-blueGray-500' : 'text-blueGray-400 group-hover:text-blueGray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                            <span class="truncate">
                              {{ item.name }}
                            </span>
                        </Link>
                    </nav>
                </aside>

                <div class="lg:col-span-6 text-blueGray-50">
                    <slot />
                </div>
            </div>
        </main>
    </div>
    <upload-slide-over
        :openSlideOver="openSlideOver"
        v-show="openSlideOver"
        @close="closeModal"
    />

    <div v-if="! this.$page.props.user.password">
        <modal :show="true" max-width="2xl">
            <form @submit.prevent="setUserPassword">
                <div class="px-6 py-4">
                    <div class="text-lg">
                        Set password account
                    </div>

                    <div class="mt-4">
                        It seems that you have registered with a provider, please enter a password to access your panel.

                        <div class="mt-4 space-y-3">
                            <div>
                                <input type="hidden" :value="this.$page.props.email" autocomplete="name" />

                                <jet-label for="password" value="Password" />
                                <Input
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full md:w-2/3"
                                    v-model="form.password"
                                    ref="password"
                                    autocomplete="new-password"
                                    autofocus
                                />

                                <Input-error
                                    :message="form.errors.password"
                                    class="mt-2"
                                />
                            </div>

                            <div>
                                <jet-label for="password_confirmation" value="Password Confirmation" />
                                <Input
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full md:w-2/3"
                                    v-model="form.password_confirmation"
                                    autocomplete="new-password"
                                />

                                <Input-error
                                    :message="form.errors.password_confirmation"
                                    class="mt-2"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-blueGray-900 flex justify-between">
                    <danger-button-link :href="route('home')" class="mr-2">
                        Back
                    </danger-button-link>
                    <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </Button>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
import {computed, ref} from 'vue'
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
    Switch,
    SwitchGroup,
    SwitchLabel,
} from '@headlessui/vue'
import { QuestionMarkCircleIcon, SearchIcon } from '@heroicons/vue/solid'
import {
    BellIcon,
    MenuIcon,
    XIcon,
} from '@heroicons/vue/outline'
import Cover from "../Components/Assets/Logo/LogoCover";
import Button from "../Components/Buttons/Button";
import {Link, usePage} from "@inertiajs/inertia-vue3";
import ViewListIcon from "@heroicons/vue/outline/ViewListIcon";
import CloudIcon from "@heroicons/vue/outline/CloudIcon";
import CollectionIcon from "@heroicons/vue/outline/CollectionIcon";
import AdjustmentsIcon from "@heroicons/vue/outline/AdjustmentsIcon";
import UploadSlideOver from "../Components/Upload/UploadSlideOver";
import Notification from "../Components/Partials/Notification";
import Modal from "../Jetstream/Modal";
import Input from "../Jetstream/Input";
import InputError from "../Jetstream/InputError";
import JetLabel from '../Jetstream/Label.vue'
import ButtonLink from "../Components/Buttons/ButtonLink";
import DangerButtonLink from "../Jetstream/DangerButtonLink";

const userNavigation = [
    { name: 'Sign out', href: route('logout'), method: 'POST' },
]

const subNavigation = [
    { name: 'Feed', href: route('panel.feed.show'), route: 'panel.feed.show', icon: ViewListIcon },
    { name: 'Api', href: route('panel.api.show'), route: 'panel.api.show', icon: CloudIcon },
    { name: 'Gallery', href: '#', route: 'panel.gallery', icon: CollectionIcon },
    { name: 'Settings', href: route('panel.settings.show'), route: 'panel.settings.show', icon: AdjustmentsIcon },
]

export default {
    components: {
        DangerButtonLink,
        ButtonLink,
        UploadSlideOver,
        Link,
        Cover,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        RadioGroup,
        RadioGroupDescription,
        RadioGroupLabel,
        RadioGroupOption,
        Switch,
        SwitchGroup,
        SwitchLabel,
        BellIcon,
        MenuIcon,
        QuestionMarkCircleIcon,
        SearchIcon,
        XIcon,
        Button,
        Modal,
        Input,
        InputError,
        JetLabel
    },

    data() {
        return {
            openSlideOver: ref(false),

            form: this.$inertia.form({
                _method: 'PUT',
                password: '',
                password_confirmation: '',
            }),
        }
    },

    setup() {
        const user = computed(() => usePage().props.value.auth.user)

        const open = ref(false)

        return {
            user,
            userNavigation,
            subNavigation,
            open
        }
    },

    methods: {
        closeModal() {
            this.openSlideOver = false

            console.log(this.openSlideOver)
        },
        showModal() {
            this.openSlideOver = true

            console.log(this.openSlideOver)
        },

        setUserPassword() {
            this.form.put(route('social.set-user-password'), {
                errorBag: 'setUserPassword',
                preserveScroll: true,
                onSuccess: () => this.form.reset(),
                onError: () => {
                    if (this.form.errors.password) {
                        this.form.reset('password', 'password_confirmation')
                        this.$refs.password.focus()
                    }
                }
            })
        },
    }
}
</script>
