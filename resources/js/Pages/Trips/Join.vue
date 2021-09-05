<template>
   <default>
       <div class="md:h-screen md:flex items-center">

           <div class="relative max-w-3xl md:rounded-md mx-auto bg-blueGray-700 py-16 px-4 overflow-hidden sm:px-6 lg:px-8 lg:py-18 md:-mt-24 lg:-mt-32">
               <div class="text-center">
                   <div class="tracking-tight text-gray-100 space-y-1">
                       <h2 class="text-xl sm:text-3xl font-extrabold">
                           Join "{{ trip.name }}"
                       </h2>
                       <h2 class="text-xl font-semibold">
                           Organized by {{ organizer.name }}
                       </h2>
                   </div>
                   <p class="mt-4 text-lg leading-6 text-gray-300">
                       To join the trip organized by {{ organizer.name }} you just have to click on the join button.
                   </p>
               </div>

               <div class="mt-4">
                   <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                       <div class="sm:col-span-2">
                           <div class="flex items-center justify-center mb-3">
                               <p class="text-base leading-6 text-gray-200">
                                   By clicking "Join the trip", you automatically accept the
                                   <a href="https://youtu.be/dQw4w9WgXcQ" target="_blank" class="font-medium text-gray-300 hover:text-gray-400 transition duration-200 ease-in-out underline">
                                       Terms of Service</a>.
                               </p>
                           </div>
                       </div>

                       <div class="col-span-2">
                           <form class="sm:col-span-2 mb-5">
                               <span v-if="! hasClickedJoinedLoading" class="w-full inline-flex rounded-md shadow-sm" x-data="{ hasClickedJoinedLoading: false }">
                                    <button type="submit" @click="joinTrip()" :disabled="hasClickedJoinedLoading"
                                            :class="{ 'cursor-not-allowed': hasClickedJoinedLoading, 'hover:bg-blueGray-900 hover:border-blueGray-50 hover:text-blueGray-50': !hasClickedJoinedLoading }"
                                            class="w-full inline-flex items-center justify-center px-6 py-3 border-blueGray-400 border-2 text-lg leading-6 font-medium rounded-md text-blueGray-300 focus:outline-none focus:ring transition ease-in-out duration-200">
                                        Join the trip
                                    </button>
                               </span>

                               <div v-else class="w-full flex justify-center">
                                   <loading />
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </default>
</template>

<script>

import Default from "@/Layouts/Default";
import Loading from "@/Components/Loading";
export default {
    name: "Join",

    components: {
        Loading,
        Default
    },

    props: {
        trip: Array,
        organizer: Array,
        recordid: Array
    },

    data() {
        return {
            hasClickedJoinedLoading: false
        }
    },

    methods: {
        joinTrip: function () {
            this.hasClickedJoinedLoading = true

            this.$inertia.put(route('trips.join', {
                'trip_id': this.trip.id,
                'recordid': this.trip.event_id
            }), {}, {
                preserveScroll: true,
                onSuccess: () => {
                    this.hasClickedJoinedLoading = false
                },
            })
        },
    }
}
</script>
