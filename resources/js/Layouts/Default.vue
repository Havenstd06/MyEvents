<template>
    <div class="h-screen bg-blueGray-900 text-gray-50">
        <default-wave />

        <div class="relative z-30">
            <navbar />

            <div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "../Components/Partials/Navbar";
    import DefaultWave from "../Components/Assets/Wave/DefaultWave";
    import ButtonLink from "../Components/Buttons/ButtonLink";
    import Cover from "../Components/Assets/Logo/LogoCover";

    export default {

        components: {
            Navbar,
            DefaultWave,
            ButtonLink,
            Cover
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        }
    }
</script>
