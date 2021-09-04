<template>
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

            <button type="button"
                    @click="setIsSettingsOpen(true)"
                    class="w-full text-center uppercase bg-blueGray-800 hover:bg-blueGray-900 transition duration-200 ease-in-out px-1.5 py-1 rounded-md text-gray-200 tracking-wide"
            >
                Trip settings
            </button>

            <TransitionRoot as="template" :show="isSettingsOpen">
                <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto" @close="isSettingsOpen = false">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                            <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                        </TransitionChild>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <div class="inline-block align-bottom bg-blueGray-700 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6">
                                <h2 class="text-xl text-center text-gray-50 uppercase tracking-wide mb-3">
                                    {{ trip.name }}'s trip infos
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

                                    <form @submit.prevent="updateTrip"
                                          class="border-b border-gray-50 pb-6 pt-2"
                                    >
                                            <div class="space-y-6 sm:space-y-5">
                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                                    <label for="name" class="block text-sm font-medium text-gray-100 sm:mt-px sm:pt-2">
                                                        Trip name
                                                    </label>
                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                        <input type="text"
                                                               name="name"
                                                               id="name"
                                                               v-model="updateTripForm.name"
                                                               class="max-w-lg block w-full shadow-sm focus:ring-blueGray-500 focus:border-blueGray-500 sm:max-w-xs sm:text-sm border-blueGray-300 rounded-md"
                                                               placeholder="My Awesome Trip"
                                                               required
                                                        />
                                                        <jet-input-error :message="updateTripForm.errors.name"
                                                                         class="mt-2"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                    <label for="max_person"
                                                           class="block text-sm font-medium text-gray-100 sm:mt-px sm:pt-2"
                                                    >
                                                        Max trip participants
                                                    </label>
                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                                        <input type="number"
                                                               name="max_person"
                                                               id="max_person"
                                                               v-model="updateTripForm.max_person"
                                                               min="1"
                                                               class="max-w-lg block w-full shadow-sm focus:ring-blueGray-500 focus:border-blueGray-500 sm:max-w-xs sm:text-sm border-blueGray-300 rounded-md"
                                                               placeholder="10"
                                                               required
                                                        />
                                                        <jet-input-error :message="updateTripForm.errors.max_person"
                                                                         class="mt-2"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-b sm:border-gray-200 sm:py-4">
                                                    <label for="is_public"
                                                           class="flex flex-col text-sm font-medium text-gray-100 sm:mt-px sm:pt-2"
                                                    >
                                            <span>
                                                Public Trip
                                            </span>
                                                        <span class="text-xs">
                                                (Anybody will be able to join)
                                            </span>
                                                    </label>
                                                    <div class="mt-1 sm:mt-0">
                                                        <input type="checkbox"
                                                               name="is_public"
                                                               id="is_public"
                                                               v-model="updateTripForm.is_public"
                                                               class="block mt-2.5 shadow-sm focus:ring-blueGray-500 focus:border-blueGray-500 sm:text-sm border-blueGray-300 rounded-md"
                                                        />
                                                        <jet-input-error :message="updateTripForm.errors.is_public"
                                                                         class="mt-2"
                                                        />
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="mt-5 sm:mt-6">
                                            <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm">
                                                Update Trip
                                            </button>
                                        </div>
                                    </form>

                                    <div class="border-b border-gray-50 pb-6 pt-2">
                                        <h3 class="text-gray-100 tracking-wide mb-1.5">
                                            Remove participant from your trip
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:items-start">
                                            <a v-for="participant in trip.participants"
                                               onclick="return confirm('Are you sure you want to remove this participant from your trip ?')"
                                               :href="route('trips.remove.user', {
                                                   'trip_id': trip.id,
                                                   'user_id': participant.id
                                               })"
                                               class="bg-blueGray-800 hover:bg-blueGray-900 transition duration-200 ease-in-out flex justify-center items-center rounded-md p-2 group"
                                            >
                                                <img :src="'/' + participant.avatar"
                                                     :alt="participant.name + '\'s avatar'"
                                                     class="w-8 h-8 rounded-md"
                                                />

                                                <span v-html="participant.name"
                                                      class="ml-2 text-gray-200 group-hover:text-gray-50 text-sm"
                                                />
                                            </a>
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <a onclick="return confirm('Are you sure you want to delete this trip')"
                                           :href="route('trips.delete', {'trip_id': trip.id})"
                                           class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm">
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>

        </div>
    </div>

    <notification v-if="notification" :notification="notification" />
</template>

<script>
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot
} from '@headlessui/vue'
import JetInputError from '@/Jetstream/InputError'
import Notification from "@/Components/Partials/Notification";
import {ref} from "vue";

export default {
    components: {
        Notification,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        JetInputError
    },

    props: {
        organizer: Array,
        event: Array,
        trip: Array
    },

    data() {
        let isSettingsOpen = ref(false);

        return {
            isSettingsOpen,
            setIsSettingsOpen: function(value) {
                isSettingsOpen.value = value
            },

            updateTripForm: this.$inertia.form({
                _method: 'POST',
                name: this.trip.name,
                max_person: this.trip.max_person,
                is_public: this.trip.is_public === 'public'
            }),

            notification: null
        }
    },

    methods: {
        updateTrip: function () {
            this.updateTripForm.post(route('trips.update', {'trip_id': this.trip.id}), {
                preserveScroll: true,
                onSuccess: (res) => {
                    this.notification = {
                        'success': 'You have successfully updated the trip!'
                    },

                    this.setIsSettingsOpen(false)
                },
            });
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
