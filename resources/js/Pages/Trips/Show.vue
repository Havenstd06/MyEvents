<template>
    <default>
        <div v-if="dataReady" class="container mx-auto my-5 p-5 space-y-4">
            <div class="flex flex-col no-wrap space-y-4">
                <!-- Event Info -->
                <div class="w-full">
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400">
                        <EventInfo
                            :trip="trip"
                            :event="event"
                            :organizer="organizer"
                        />
                    </div>
                </div>
                <!-- End of Event Info -->

                <!-- Event Info -->
                <div class="w-full">
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400">
                        <Map
                            :event="event"
                        />
                    </div>
                </div>
                <!-- End of Event Info -->
            </div>


            <div class="md:flex no-wrap md:-mx-2 space-y-4 md:space-y-0">
                <!-- Left Side -->
                <div class="w-full md:w-3/12 md:mx-2">
                    <!-- Participants Card -->
                    <div class="bg-blueGray-700 p-3 border-t-4 border-blueGray-400">
                        <Participants
                            :trip="trip"
                            :participants="participants"
                            :organizer="organizer"
                        />
                    </div>
                    <!-- End of profile card -->
                </div>
                <!-- Right Side -->
                <div class="w-full md:w-9/12 md:mx-2"
                     :class="`${$page.props.auth.user.id === organizer.id ?
                         participants.length >= 3 ? 'h-106' : 'h-76' :
                         participants.length >= 3 ? 'h-84' : 'h-76'
                     }`"
                >
                    <!-- Chat -->
                    <div class="bg-blueGray-700 h-full p-3 border-t-4 border-blueGray-400 shadow-sm">
                        <Chat
                            :trip="trip"
                        />
                    </div>
                    <!-- End of Chat -->
                </div>
            </div>
        </div>
        <div v-else class="w-full mt-32 flex items-center justify-center">
            <Loading />
        </div>
    </default>
</template>

<script>
import Default from "@/Layouts/Default";
import EventInfo from "@/Pages/Trips/Partials/EventInfo";
import Map from "@/Pages/Trips/Partials/Map";
import Participants from "@/Pages/Trips/Partials/Participants";
import Loading from "@/Components/Loading";
import Chat from "@/Pages/Trips/Partials/Chat/Chat";
export default {
    name: "Show",
    components: {
        Window,
        Loading,
        Chat,
        Participants,
        Map,
        EventInfo,
        Default
    },

    props: {
        trip: Array,
        organizer: Array,
        participants: Array
    },

    data() {
        return {
            event: null,
            dataReady: false
        }
    },

    mounted() {
        this.getEvent()
    },

    methods: {
        getEvent: function () {
            axios
                .get(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&rows=18&facet=recordid&refine.recordid=${this.trip.event_id}&timezone=Europe%2FParis`, {
                    transformRequest: [function (data, headers) {
                        delete headers['X-Socket-Id'];
                        return data;
                    }]
                })
                .then(response => {
                    this.event = response.data.records[0]
                    this.dataReady = true
                })
        },
    }
}
</script>
