<template>
    <div class="w-full flex flex-col justify-center pl-1 pb-2.5">
        <div v-if="organizer.id === $page.props.auth.user.id">
            <h3 class="text-gray-100 mb-1">
                Organizer Settings
            </h3>
            <div class="flex flex-col space-y-2 mb-3">
                <button type="submit"
                        @click="handleCopy(route('trips.join.show', {
                            'trip_id': trip.id,
                            'recordid': trip.event_id
                        }))"
                        class="w-full text-center uppercase bg-blueGray-800 hover:bg-blueGray-900 transition duration-200 ease-in-out px-1.5 py-1 rounded-md text-gray-200 tracking-wide"
                >
                    Copy invite url
                </button>

                <a onclick="return confirm('Are you sure you want to delete this trip')"
                   :href="route('trips.delete', {'trip_id': trip.id})"
                   class="w-full text-center uppercase bg-blueGray-800 hover:bg-blueGray-900 transition duration-200 ease-in-out px-1.5 py-1 rounded-md text-gray-200 tracking-wide"
                >
                    Delete the trip
                </a>
            </div>
        </div>
        <h2 class="text-lg uppercase text-gray-200 tracking-wide">
            Participants (<span v-html="participants.length" />/<span v-html="trip.max_person" />)
        </h2>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div
            v-for="participant in participants"
            :key="participant.id"
            class="relative rounded-md border border-gray-300 bg-blueGray-900 px-6 py-5 shadow-sm flex flex-col justify-center items-center space-y-2 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blueGray-500"
        >
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" :src="'/' + participant.avatar" alt="" />
            </div>
            <div class="flex-1 text-center min-w-0">
                <a :href="route('profile.show', {'user': participant.id})"
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
                </a>
            </div>
        </div>
    </div>

    <notification v-if="notification" :notification="this.notification" />
</template>

<script>
import Notification from "@/Components/Partials/Notification";
export default {
    name: "Participants",

    components: {
        Notification
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
