<template>
    <div>
        <slot></slot>

        <notification />
    </div>
</template>

<script>
    import Notification from "../Components/Partials/Notification";

    export default {
        name: 'Layout',

        components: {
            Notification
        }
    }
</script>
