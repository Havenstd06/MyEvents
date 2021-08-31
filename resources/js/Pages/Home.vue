<template>
    <default>
        <main>
            <trending-events />
        </main>
    </default>
</template>

<script>
import {Head, usePage} from '@inertiajs/inertia-vue3';
import Default from "../Layouts/Default";
import {computed} from "vue";
import TrendingEvents from "@/Components/TrendingEvents";
import Perks from "@/Components/Perks";


export default {
    name: "Home",

    components: {
        TrendingEvents,
        Perks,
        Head,
        Default
    },

    setup() {
        const app = computed(() => usePage().props.value.app)

        return {
            app
        }
    }
}
</script>
