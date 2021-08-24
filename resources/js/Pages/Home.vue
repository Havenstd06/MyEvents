<template>
    <default>
        <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
            <div class="max-w-xl sm:mx-auto lg:max-w-2xl">
                <div class="flex flex-col mb-16 sm:text-center sm:mb-0">
                    <a href="/" class="mb-6 sm:mx-auto">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-teal-accent-400">
                            <svg
                                class="w-24 h-24 text-deep-purple-900"
                                stroke="currentColor"
                                viewBox="0 0 52 52"
                            >
                                <polygon
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    fill="none"
                                    points="29 13 14 29 25 29 23 39 38 23 27 23"
                                />
                            </svg>
                        </div>
                    </a>
                    <div class="max-w-xl mb-4 md:mx-auto sm:text-center lg:max-w-2xl md:mb-6">
                        <h2 class="max-w-lg mb-6 font-sans text-3xl font-bold leading-none tracking-tight text-white sm:text-4xl md:mx-auto">
                                        <span class="relative inline-block">
                                          <svg
                                              viewBox="0 0 52 24"
                                              fill="currentColor"
                                              class="absolute top-0 left-0 z-0 hidden w-32 -mt-8 -ml-20 text-deep-purple-accent-100 lg:w-32 lg:-ml-28 lg:-mt-10 sm:block"
                                          >
                                            <defs>
                                              <pattern
                                                  id="700c93bf-0068-4e32-aafe-ef5b6a647708"
                                                  x="0"
                                                  y="0"
                                                  width=".135"
                                                  height=".30"
                                              >
                                                <circle cx="1" cy="1" r=".7" />
                                              </pattern>
                                            </defs>
                                            <rect
                                                fill="url(#700c93bf-0068-4e32-aafe-ef5b6a647708)"
                                                width="52"
                                                height="24"
                                            />
                                          </svg>
                                            <span class="flex flex-col space-y-2 relative">
                                                <span>
                                                    {{ app.name }}
                                                </span>
                                            </span>

                                        </span>

                        </h2>
                    </div>
                    <div>
                        <button-link>
                            Get started for free
                        </button-link>
                    </div>
                </div>
            </div>
        </div>
    </default>
</template>

<script>
import {Head, Link, usePage} from '@inertiajs/inertia-vue3';
import Default from "../Layouts/Default";
import {computed} from "vue";
import ButtonLink from "../Components/Buttons/ButtonLink";
import Notification from "../Components/Partials/Notification";

export default {
    name: "Home",

    components: {
        Notification,
        Head,
        Default,
        ButtonLink
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    },

    setup() {
        const app = computed(() => usePage().props.value.app)
        return { app }
    }
}
</script>

<style scoped>

</style>
