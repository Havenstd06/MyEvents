<template>
    <default>
        <div class="container mx-auto my-5 p-5">
            <div class="md:flex no-wrap md:-mx-2 ">
                <!-- Left Side -->
                <div class="w-full md:w-3/12 md:mx-2">
                    <!-- Profile Card -->
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400">
                        <div class="image overflow-hidden">
                            <img class="h-auto w-full mx-auto" :src="'/' + user.avatar" :alt="user.name + '\'s avatar'">
                        </div>
                        <h1 class="text-gray-100 font-bold text-xl leading-8 my-1" v-html="user.name" />
                        <p class="text-sm text-gray-300 leading-6" v-html="user.description ?? 'No description'" />
                    </div>
                    <!-- End of profile card -->
                </div>
                <!-- Right Side -->
                <div class="w-full md:w-9/12 mx-2 h-64 space-y-6">

                    <!-- Organized trips -->
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400 shadow-sm">
                        <div class="flex items-center space-x-2 font-semibold text-gray-200 leading-8 mb-3">
                            <span class="tracking-wide text-lg">
                               Organized Trips
                            </span>
                        </div>
                        <div v-if="userOrganizedTrips.length > 0"
                             class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-3"
                        >
                            <Link v-for="trip in userOrganizedTrips"
                               :key="trip.id"
                               :href="route('trips.show', {'trip_id': trip.id})"
                               class="bg-blueGray-800 hover:bg-blueGray-900 transition duration-200 ease-in-out px-2 py-1.5 rounded-md group">
                                <div class="flex items-center justify-between space-x-4 group">
                                    <div>
                                        <div class="text-blueGray-200 group-hover:text-gray-400 transition duration-200 ease-in-out" v-html="trip.name" />
                                        <div class="text-blueGray-300 text-xs group-hover:text-gray-400 transition duration-200 ease-in-out" >
                                            by <span v-html="trip.user.name" />
                                        </div>
                                    </div>
                                    <div class="text-xs text-blueGray-300 group-hover:text-gray-400" v-html="(trip.participants.length ?? 'x') + ' participants'" />
                                </div>
                            </Link>
                        </div>
                        <div v-else>
                            <h2 class="text-lg text-gray-50">
                                No Organized Trip
                            </h2>
                        </div>
                    </div>
                    <!-- End of Organized trips -->

                    <!-- Joined trips -->
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400 shadow-sm">
                        <div class="flex items-center space-x-2 font-semibold text-gray-200 leading-8 mb-3">
                            <span class="tracking-wide text-lg">
                               Joined Trips
                            </span>
                        </div>
                        <div v-if="userJoinedTrips.length > 0"
                             class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-3"
                        >
                            <Link v-for="trip in userJoinedTrips"
                               :key="trip.id"
                               :href="route('trips.show', {'trip_id': trip.id})"
                               class="bg-blueGray-800 hover:bg-blueGray-900 transition duration-200 ease-in-out px-2 py-1.5 rounded-md">
                                <div class="flex items-center justify-between space-x-4 group">
                                    <div>
                                        <div class="text-blueGray-200 group-hover:text-gray-400 transition duration-200 ease-in-out" v-html="trip.name" />
                                        <div class="text-blueGray-300 text-xs group-hover:text-gray-400 transition duration-200 ease-in-out" >
                                            by <span v-html="trip.user.name" />
                                        </div>
                                    </div>
                                    <div class="text-xs text-blueGray-300 group-hover:text-gray-400" v-html="(trip.participants.length ?? 'x') + ' participants'" />
                                </div>
                            </Link>
                        </div>
                        <div v-else>
                            <h2 class="text-lg text-gray-50">
                                No Joined Trip
                            </h2>
                        </div>
                    </div>
                    <!-- End of Joined trips -->
                </div>
            </div>
        </div>
    </default>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Default from "@/Layouts/Default";

export default {
    components: {
        Default,
        Link
    },

    props: {
        user: Array,
        userOrganizedTrips: Array,
        userJoinedTrips: Array,
    },
}
</script>
