<template>
    <div class="w-full md:flex flex-col justify-center pl-1 pb-2.5">
        <h2 class="text-lg uppercase text-gray-200 tracking-wide">
            Trip & Event info
        </h2>
    </div>
    <div class="md:flex justify-center md:justify-start items-center md:space-x-4 space-y-4 md:space-y-0 font-semibold text-gray-200 leading-8">
        <div class="bg-blueGray-900 rounded-md p-2 h-48 w-48 bg-center bg-cover"
            :style="{backgroundImage: `url(${event.fields.image ?? 'https://limg.app/i/gHlTvX.png'})`}"
        />
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 w-full">
            <div
                v-for="info in infos"
                :key="info.title"
                class="bg-blueGray-900 overflow-hidden shadow rounded-md"
            >
                <div class="px-3 py-2 h-full">
                    <div class="flex items-center h-full">
                        <div class="flex-shrink-0">
                            <component :is="info.icon" class="h-6 w-6 text-gray-200" aria-hidden="true" />
                        </div>
                        <div class="ml-3 flex-1 flex flex-col justify-center">
                                <div class="text-lg font-medium text-gray-300 truncate"
                                    v-html="info.title"
                                />
                                <div class="text-sm font-medium text-gray-400"
                                     v-html="info.text"
                                />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {
    CalendarIcon,
    CurrencyEuroIcon,
    LocationMarkerIcon,
    ScaleIcon,
    UserGroupIcon,
    UserIcon
} from "@heroicons/vue/outline";

export default {
    name: "EventInfo",

    props: {
        trip: Array,
        event: Array,
        organizer: Array,
    },

    data() {
        const infos = [
            { title: `Trip Name - ${this.capitalizeWords(this.trip.is_public)} trip`, href: '#', icon: CalendarIcon, text: this.trip.name },
            { title: 'Organizer', href: '#', icon: UserIcon, text: this.organizer.name },
            { title: 'Max Participants', href: '#', icon: UserGroupIcon, text: this.trip.max_person },
            { title: 'Event Name', href: '#', icon: CalendarIcon, text: this.event.fields.title },
            { title: 'Location', href: '#', icon: LocationMarkerIcon, text: `${this.event.fields.placename}, ${this.event.fields.address}` },
            { title: 'Price', href: '#', icon: CurrencyEuroIcon, text: this.event.fields.pricing_info ?? 'No price given' },
        ]

        return {
            infos
        }
    },

    methods: {
        capitalizeWords: function (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }
}
</script>
