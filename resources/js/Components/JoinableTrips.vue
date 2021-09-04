<template>
    <div class="flex flex-col max-w-6xl mx-auto pb-24 ">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blueGray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                Event
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                Trip
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                Organizer
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">
                                Participants
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Join</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-blueGray-700 divide-y divide-gray-500">
                        <Link as="tr"
                              v-for="trip in trips"
                              :key="trip.id"
                              :href="route('trips.show', {
                                  'trip_id': trip.id
                              })"
                              class="cursor-pointer hover:bg-blueGray-800 transition duration-200 ease-in-out"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" :src="trip.event_data.image" alt="" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-300">
                                            {{ trip.event_data.name }}
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            {{ trip.event_data.date }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-300">
                                    {{ trip.name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-300">
                                    {{ trip.user.name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-300">
                                    {{ trip.participants.length }}/{{ trip.max_person }} participants
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <Link :href="route('trips.join', {
                                    'trip_id': trip.id,
                                    'recordid': trip.event_id
                                })"
                                   class="text-gray-300 hover:text-gray-50 bg-blueGray-900 hover:bg-blueGray-600 rounded-md px-3 py-2 transition duration-200 ease-in-out"
                                >
                                    Join
                                </Link>
                            </td>
                        </Link>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link
    },

    props: {
        trips: Array
    },
}
</script>
