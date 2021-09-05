<template>
    <div class="w-full flex flex-col justify-center pl-1 pb-2.5">
        <TripSettings
            :organizer="organizer"
            :event="event"
            :trip="trip"
        />

        <h2 class="text-lg uppercase text-gray-200 tracking-wide">
            Participants (<span v-html="participants.length" />/<span v-html="trip.max_person" />)
        </h2>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div
            v-for="participant in participants"
            :key="participant.id"
            class="relative rounded-md border border-gray-300 bg-blueGray-900 px-6 py-5 shadow-sm flex flex-col justify-center items-center space-y-2 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blueGray-500"
        >
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" :src="'/' + participant.avatar" alt="" />
            </div>
            <div class="flex-1 text-center min-w-0">
                <Link :href="route('profile.show', {'user': participant.id})"
                   class="focus:outline-none"
                >
                    <span class="absolute inset-0" aria-hidden="true" />
                    <p class="text-sm font-medium text-gray-200">
                        {{ participant.name }}
                    </p>
                    <p class="text-sm text-gray-400 truncate uppercase">
                        <span v-if="organizer.id === participant.id" >
                            Organizer
                        </span>
                        <span v-else>
                            Participant
                        </span>
                    </p>
                </Link>
            </div>
        </div>
    </div>

    <notification v-if="notification" :notification="this.notification" />
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Notification from "@/Components/Partials/Notification";
import TripSettings from "@/Pages/Trips/Partials/TripSettings";
export default {
    name: "Participants",

    components: {
        TripSettings,
        Notification,
        Link
    },

    props: {
        trip: Array,
        participants: Array,
        organizer: Array
    },

    data() {
        return {
            notification: null
        }
    },

    methods: {
        handleCopy: function (text) {
            navigator.clipboard.writeText(text)

            this.notification = {
                'success': 'Copied to clipboard!'
            }
        }
    }
}
</script>

<style scoped>

</style>
