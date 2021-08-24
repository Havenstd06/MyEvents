<template>
    <div class="h-screen bg-blueGray-900">

        <AuthWave />

        <div class="fixed w-full z-30">
            <Navbar :displayButton="false" />

            <div class="relative px-4 md:px-0 py-6 sm:py-0 md:h-screen flex justify-center items-center">
                <div class="transform md:-translate-y-16 w-full sm:max-w-md p-6 bg-blueGray-800 shadow-md overflow-hidden rounded-lg">
                    <Transition
                        enter-active-class="transition-opacity duration-75"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="transition-opacity duration-150"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div v-if="show">
                            <div v-if="route().current() === 'login' || route().current() === 'register'">
                                <sign-in-with />
                            </div>

                            <slot />
                        </div>
                    </Transition>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { ref } from 'vue'
    import AuthWave from "../Components/Assets/Wave/AuthWave";
    import ButtonLink from "../Components/Buttons/ButtonLink";
    import Cover from "../Components/Assets/Logo/LogoCover";
    import Navbar from "../Components/Partials/Navbar";
    import SignInWith from "../Components/Partials/SignInWith";

    export default {
        components: {
            AuthWave,
            ButtonLink,
            Cover,
            Navbar,
            SignInWith
        },

        setup() {
            const show = ref(true)

            return {
                show,
            }
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        }
    }
</script>
