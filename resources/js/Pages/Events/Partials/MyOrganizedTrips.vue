<template>
    <h2 class="text-2xl text-gray-50 w-full border-b border-gray-50 pb-3 mb-6">
        My organized trips on this event
    </h2>

    <div v-if="this.userTrips.length > 0" class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6">
        <div v-for="trip in this.userTrips"
             :key="trip.id"
             @click="setIsTripOpen(true); setSelectedTrip(trip.id)"
             class="bg-blueGray-700 border-blueGray-600 text-gray-50 | p-4 rounded-lg border-2 | flex justify-around cursor-pointer | hover:bg-blueGray-800 | transition-colors duration-500"
        >
            <div>

                <span class="flex flex-col justify-center text-gray-50 font-semibold">
                    {{ trip.name }}
                </span>

                <TransitionRoot as="template" v-if="this.selectedTrip === trip.id" :show="isTripOpen">
                    <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto" @close="isTripOpen = false">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                                <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                            </TransitionChild>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <div class="inline-block align-bottom bg-blueGray-700 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6">
                                    <h2 class="text-xl text-center text-gray-50 uppercase tracking-wide mb-3">
                                        {{ trip.name }}'s infos
                                    </h2>

                                    <div class="space-y-4">
                                        <div class="border-b border-gray-50 pb-6">
                                            <h4 class="px-2 text-gray-100 mb-3">
                                                Here is your invitation link, send it to your friends to invite them to your trip!
                                            </h4>

                                            <div class="w-full rounded-md break-words bg-blueGray-800 px-4 py-2">
                                                <a class="text-gray-100 hover:text-gray-200 focus:outline-none transition duration-200 ease-in-out"
                                                   :href="route('trips.join.show', {
                                                        'trip_id': trip.id,
                                                        'recordid': trip.event_id
                                                    })"
                                                   v-html="route('trips.join.show', {
                                                        'trip_id': trip.id,
                                                        'recordid': trip.event_id
                                                    })"
                                                >
                                                </a>
                                            </div>

                                            <button type="submit" @click="handleCopy(tripJoinLink)" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm mt-4">
                                                Copy Link to clipboard
                                            </button>
                                        </div>

                                        <div class="border-b border-gray-50 pb-6 pt-2">
                                            <a :href="route('trips.show', {'trip_id': trip.id})" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm">
                                                Visit my Trip Page
                                            </a>
                                        </div>

                                        <div class="pt-3">
                                            <h4 class="px-2 text-gray-100 mb-3">
                                                Here you have all the users registered on your trip.
                                            </h4>

                                            <div v-if="trip.participants" class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-2">
                                                <div v-for="participant in trip.participants" class="bg-blueGray-700 border-blueGray-600 text-gray-50 | py-2 px-4 text-center rounded-lg border-2 | flex justify-around cursor-pointer | hover:bg-blueGray-800 | transition-colors duration-500">
                                                    <a :href="route('profile.show', {'user': participant.id})">
                                                        {{ participant.name }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div v-else class="px-2 text-md text-gray-300">
                                                No user registered on your trip
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </TransitionChild>
                        </div>
                    </Dialog>
                </TransitionRoot>
            </div>
        </div>

    </div>
    <div v-else>
        <h2 class="text-lg text-gray-50">
            No Organized Trip
        </h2>
    </div>

    <notification v-if="notification" :notification="this.notification" />
</template>

<script>
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot
} from '@headlessui/vue'
import Loading from "@/Components/Loading";
import {ref} from "vue";
import Notification from "@/Components/Partials/Notification";
export default {
    name: "MyTrips",

    components: {
        Notification,
        Loading,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
    },

    props: {
      userTrips: Array
    },

    data() {
        let isTripOpen = ref(false);

        return {
            isTripOpen,
            setIsTripOpen: function(value) {
                isTripOpen.value = value
            },

            isTripLoading: false,
            selectedTrip: null,
            notification: null,
        }
    },

    methods: {
        setSelectedTrip: function (value) {
            this.selectedTrip = value
        },

        handleCopy: function (text) {
            navigator.clipboard.writeText(text)

            this.notification = {
                'success': 'Copied to clipboard!'
            }
        }
    }
}
</script>
