<template>
    <Link
        :method="method"
        :href="href"
        class="px-3 md:px-5 py-2 text-base font-medium text-white transition duration-300 ease-in-out transform bg-blueGray-500 border-blueGray-600 rounded-md focus:outline-none focus:ring-0 hover:bg-blueGray-600"
        :class="classes"
        :disabled="processing"
    >
        <slot></slot>
    </Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            href: {
                type: String
            },
            method: {
                default: '',
                type: String
            },
            processing: {
                type: Boolean
            }
        },

        components: {
            Link,
        },

        computed: {
            classes() {
                return this.processing ? 'opacity-25' : ''
            }
        }
    }
</script>
