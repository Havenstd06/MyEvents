<template>
    <default>
        <main>
            <link rel="stylesheet" href="">
                <trending-events :trending-events="trendingEvents" />
            <perks />
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

    props: {
        trendingEvents: Array
    },

    setup() {
        const app = computed(() => usePage().props.value.app)

        return {
            app
        }
    }
}
</script>
