<template>
    <default>
        <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div v-if="dataReady">
                <div class="md:flex space-x-8">

                    <div class="md:w-1/3">
                        <img :src="event.fields.image ?? 'https://limg.app/i/gHlTvX.png'"
                             :alt="event.fields.placename"
                             class="w-full h-full object-center object-cover sm:rounded-lg"
                        />
                    </div>

                    <!-- Event info -->
                    <div class="md:w-3/4 mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0 flex flex-col justify-between">
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight text-gray-100">
                                {{ event.fields.date_start ?? 'No date start' }}
                                to
                                {{ event.fields.date_end ?? 'No date end' }}
                            </h1>

                            <div class="mt-3">
                                <h2 class="sr-only">
                                    Title
                                </h2>
                                <p class="text-3xl uppercase text-gray-200">
                                    {{ event.fields.title }}
                                </p>
                                <p class="text-xl text-gray-200">
                                    {{ event.fields.placename }}, {{ event.fields.address }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 md:w-1/3">
                            <div v-if="$page.props.auth.user">
                                <button type="button" @click="setIsTripOpen(true)" class="inline-flex justify-center items-center w-full px-4 py-2.5 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-100 ring-transparent hover:bg-blueGray-700 hover:text-blueGray-200 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Organize a trip
                                </button>
                            </div>

                            <div v-else>
                                <button type="button" class="inline-flex justify-center items-center w-full px-4 py-2.5 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-100 ring-transparent transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-not-allowed">
                                    You must be authenticated to organize a trip
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">
                        Description
                    </h3>

                    <div class="text-base text-gray-300 space-y-6" v-html="event.fields.free_text" />
                </div>

                <div v-if="$page.props.auth.user" class="mt-6">
                    <my-trips :user-trips="this.$page.props.userTrips"/>
                </div>
            </div>
            <div v-else class="w-full mt-32 flex items-center justify-center">
                <Loading />
            </div>
        </div>

        <TransitionRoot as="template" :show="isTripOpen">
            <Dialog as="div" class="fixed z-40 inset-0 overflow-y-auto" @close="isTripOpen = false">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                        <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="inline-block align-bottom bg-blueGray-700 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full sm:p-6">
                        <h2 class="text-3xl text-center text-gray-50 uppercase tracking-wide mb-3">
                            Organize a trip
                        </h2>
                            <form
                                v-if="! isCreateTripLoading && ! tripJoinLink"
                                @submit.prevent="createTrip"
                            >
                                <div class="space-y-6 sm:space-y-5">
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                        <label for="name" class="block text-sm font-medium text-gray-100 sm:mt-px sm:pt-2">
                                            Trip name
                                        </label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                                            <input type="text"
                                                   name="name"
                                                   id="name"
                                                   v-model="createTripForm.name"
                                                   class="max-w-lg block w-full shadow-sm focus:ring-blueGray-500 focus:border-blueGray-500 sm:max-w-xs sm:text-sm border-blueGray-300 rounded-md"
                                                   placeholder="My Awesome Trip"
                                                   required
                                            />
                                            <jet-input-error :message="createTripForm.errors.name"
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
                                                   v-model="createTripForm.max_person"
                                                   min="2"
                                                   class="max-w-lg block w-full shadow-sm focus:ring-blueGray-500 focus:border-blueGray-500 sm:max-w-xs sm:text-sm border-blueGray-300 rounded-md"
                                                   placeholder="10"
                                                   required
                                            />
                                            <jet-input-error :message="createTripForm.errors.max_person"
                                                             class="mt-2"
                                            />
                                        </div>
                                    </div>
                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                        <label for="is_public"
                                               class="flex flex-col text-sm font-medium text-gray-100 sm:mt-px sm:pt-2"
                                        >
                                            <span>
                                                Public Trip
                                            </span>
                                            <span class="text-xs">
                                                (Checked: anybody will be able to join)
                                            </span>
                                        </label>
                                        <div class="mt-1 sm:mt-0">
                                            <input type="checkbox"
                                                   v-model="createTripForm.is_public"
                                                   class="block mt-2.5 shadow-sm focus:ring-blueGray-500 focus:border-blueGray-500 sm:text-sm border-blueGray-300 rounded-md"
                                            />
                                            <jet-input-error :message="createTripForm.errors.is_public"
                                                             class="mt-2"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm">
                                        Create Trip
                                    </button>
                                </div>
                            </form>

                            <div v-if="tripJoinLink && trip">
                                <div v-if="trip.is_public === 'public'">
                                    <h3 class="text-gray-100 mb-3">
                                        Here is your invitation link, send it to your friends to invite them to your trip!
                                    </h3>

                                    <div class="w-full rounded-md break-words bg-blueGray-800 px-4 py-2">
                                        <Link class="text-gray-100 hover:text-gray-200 focus:outline-none transition duration-200 ease-in-out"
                                              :href="tripJoinLink"
                                              v-html="tripJoinLink"
                                        >
                                        </Link>
                                    </div>

                                    <button type="submit" @click="handleCopy(tripJoinLink)" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm mt-4">
                                        Copy Link to clipboard
                                    </button>
                                </div>
                                <div v-else>
                                    <h3 class="text-gray-100 mb-3">
                                        To invite participants to your private trip, go to your trip page and click on "Add participants".
                                    </h3>
                                </div>

                                <Link :href="route('trips.show', {'trip_id': tripId})" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blueGray-900 text-base font-medium text-white hover:bg-blueGray-800 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blueGray-500 sm:text-sm mt-3">
                                    Visit my Trip Page
                                </Link>
                            </div>

                            <div v-if="isCreateTripLoading">
                                <Loading />
                            </div>
                        </div>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>
    </default>

    <notification v-if="notification" :notification="this.notification" />
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Default from "@/Layouts/Default";
import Loading from "@/Components/Loading";
import { ref } from "vue";
import { CheckIcon } from '@heroicons/vue/outline'
import JetInputError from '@/Jetstream/InputError'
import {
    Dialog,
    DialogOverlay,
    DialogTitle,
    TransitionChild,
    TransitionRoot
} from '@headlessui/vue'
import Notification from "@/Components/Partials/Notification";
import MyTrips from "@/Pages/Events/Partials/MyOrganizedTrips";

export default {
    components: {
        MyTrips,
        Notification,
        Loading,
        Default,
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        CheckIcon,
        JetInputError,
        Link
    },

    setup() {
        let isTripOpen = ref(false);

        return {
            isTripOpen,
            setIsTripOpen(value) {
                isTripOpen.value = value;
            },
        };
    },

    data() {
        return {
            event: [],
            dataReady: false,
            recordId: this.$page.props.recordid,
            notification: null,

            isCreateTripLoading: false,
            tripJoinLink: null,
            tripId: null,
            trip: null,

            createTripForm: this.$inertia.form({
                _method: 'POST',
                name: null,
                max_person: null,
                is_public: true,
            }),
        }
    },

    mounted () {
        this.getEvent()
    },

    methods: {
        getEvent: function () {
            axios
                .get(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&rows=18&facet=recordid&refine.recordid=${this.recordId}&timezone=Europe%2FParis`, {
                    transformRequest: [function (data, headers) {
                        delete headers['X-Socket-Id'];
                        return data; // fix socket id error
                    }]
                })
                .then(response => {
                    this.event = response.data.records[0]
                    this.dataReady = true
                })
        },

        createTrip: function () {
            this.isCreateTripLoading = true

            this.createTripForm.transform((data) => ({
                ...data,
                'event_name': this.event.fields.title,
                'event_image': this.event.fields.image,
                'event_date': this.event.fields.date_start + ' to ' + this.event.fields.date_end,
            }))
                .post(route('trips.create', {
                    'recordid': this.recordId
                }), {
                preserveScroll: true,
                onSuccess: (res) => {
                    this.isCreateTripLoading = false
                    this.tripJoinLink = res.props.data.tripJoinLink
                    this.tripId = res.props.data.tripId
                    this.trip = res.props.data.trip
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
