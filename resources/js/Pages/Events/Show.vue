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
                            <a href="#" class="inline-flex justify-center items-center w-full px-4 py-2.5 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-100 ring-transparent hover:bg-blueGray-700 hover:text-blueGray-200 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Organize a trip
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">
                        Description
                    </h3>

                    <div class="text-base text-gray-300 space-y-6" v-html="event.fields.free_text" />
                </div>
            </div>
            <div v-else class="w-full mt-32 flex items-center justify-center">
                <Loading />
            </div>
        </div>
    </default>
</template>

<script>
import Default from "@/Layouts/Default";
import Loading from "@/Components/Loading";

export default {
    components: {
        Loading,
        Default,
    },

    data() {
        return {
            event: [],
            dataReady: false,
            recordId: this.$page.props.recordid
        }
    },

    mounted () {
        this.getEvent()
    },

    methods: {
        getEvent: function () {
            axios
                .get(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&rows=18&facet=recordid&refine.recordid=${this.recordId}&timezone=Europe%2FParis`)
                .then(response => {
                    this.event = response.data.records[0]
                    this.dataReady = true
                })
        }
    }
}
</script>
