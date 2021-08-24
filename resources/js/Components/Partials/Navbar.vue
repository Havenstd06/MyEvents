<template>
    <div class="text-blueGray-100">
        <div class="max-w-6xl px-5 py-6 mx-auto flex items-center justify-between">
            <Link :href="route('home')" class="cursor-pointer group flex items-center pr-2 lg:pr-8 lg:px-6 focus:outline-none">
                <cover customClass="block h-10 w-auto" fill="group-hover:text-blueGray-400" />
            </Link>

            <div v-if="displayButton">
                <div class="flex space-x-4" v-if="$page.props.auth.user">
                    <button-link
                    >
                        {{ $page.props.auth.user.name }}
                    </button-link>
                    <form method="POST" @submit.prevent="logout">
                        <button-normal>
                            Logout
                        </button-normal>
                    </form>
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
            Cover
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
