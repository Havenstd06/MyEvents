<template>
    <default>
        <div class="container mx-auto my-5 p-5">
            <div class="md:flex no-wrap md:-mx-2 ">
                <!-- Left Side -->
                <div class="w-full md:w-3/12 md:mx-2">
                    <!-- Profile Card -->
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400">
                        <div class="image overflow-hidden">
                            <img class="h-auto w-full mx-auto" :src="'/'+user.avatar" alt="">
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
                        <div v-if="this.userOrganizedTrips.length > 0" class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-3">
                            <a v-for="trip in userOrganizedTrips"
                               :key="trip.id"
                               :href="route('trips.show', {'trip_id': trip.id})"
                               class="bg-blueGray-800 px-2 py-1.5 rounded-md group">
                                <div class="text-blueGray-200 group-hover:text-gray-400 transition duration-200 ease-in-out" v-html="trip.name" />
                                <div class="text-gray-300 text-xs group-hover:text-gray-400 transition duration-200 ease-in-out" v-html="user.name" />
                            </a>
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
                        <ul
                            v-if="this.userJoinedTrips.length > 0"
                            class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-3"
                        >
                            <li
                                v-for="trip in userJoinedTrips"
                                :key="trip.id"
                            >
                                <a
                                    v-if="trip.user_id !== user.id"
                                    :href="route('trips.show', {'trip_id': trip.id})"
                                    class="bg-blueGray-800 px-2 py-1.5 rounded-md group"
                                >
                                    <div
                                        class="text-blueGray-200 group-hover:text-gray-400 transition duration-200 ease-in-out"
                                        v-html="trip.name"
                                    />
                                    <div
                                        class="text-gray-300 text-xs group-hover:text-gray-400 transition duration-200 ease-in-out"
                                        v-html="user.name"
                                    />
                                </a>
                            </li>
                        </ul>
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
import Default from "@/Layouts/Default";

export default {
    components: {
        Default,
    },

    props: {
        user: Array,
        userOrganizedTrips: Array,
        userJoinedTrips: Array,
    },
}
</script>
