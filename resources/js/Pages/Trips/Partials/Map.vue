<template>
    <GoogleMap
        api-key="AIzaSyAYM1kuVvZl8vVLfAXUzeClpVvR9n5jXFU"
        class="w-full h-64"
        :center="center"
        :zoom="15"
    >
        <Marker :options="{ position: center }" />
    </GoogleMap>
</template>

<script>
import { GoogleMap, Marker } from 'vue3-google-map'

export default {
    components: {
        GoogleMap,
        Marker
    },

    props: {
        event: Array
    },

    data() {
        const center = { lat: this.event.fields.latlon[0], lng: this.event.fields.latlon[1] }

        return { center }
    },
}
</script>

<style scoped>

</style>
