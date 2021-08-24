<template>
    <div>
        <slot></slot>

        <div v-if="this.$page.props.notification.success || this.$page.props.notification.error || this.$page.props.notification.warning">
            <notification :notification="this.$page.props.notification" />
        </div>
    </div>
</template>

<script>
    import Notification from "../Components/Partials/Notification";

    export default {
        name: 'Layout',

        components: {
            Notification
        },
    }
</script>
