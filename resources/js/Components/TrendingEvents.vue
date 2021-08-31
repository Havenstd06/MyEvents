<template>
    <main class="max-w-2xl mx-auto px-4 lg:max-w-7xl lg:px-8">
        <div class="border-b border-gray-200 pt-24 pb-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-100">
                Trending Events in {{ this.city }}
            </h1>
            <p class="mt-4 text-base text-gray-300">
                Discover the most popular events near {{ this.city }}!
            </p>
        </div>

        <div class="pt-12 pb-24 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
            <aside>
                <h2 class="sr-only">Filters</h2>

                <button type="button" class="inline-flex items-center lg:hidden" @click="mobileFiltersOpen = true">
                    <span class="text-sm font-medium text-gray-700">Filters</span>
                    <PlusSmIcon class="flex-shrink-0 ml-1 h-5 w-5 text-gray-400" aria-hidden="true" />
                </button>

                <div class="hidden lg:block">
                    <div class="divide-y divide-gray-200 space-y-10">
                        <fieldset role="group">
                            <legend class="block text-sm font-medium text-gray-100">
                                City
                            </legend>
                            <div class="pt-6 space-y-3">
                                <div class="flex items-center">
                                    <input id="place-1"
                                           name="place"
                                           @change="cityChange('Marseille')"
                                           type="radio"
                                           class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                           checked
                                    />
                                    <label for="place-1" class="ml-3 text-sm text-gray-200">
                                        Marseille
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="place-2"
                                           name="place"
                                           @change="cityChange('Paris')"
                                           type="radio"
                                           class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                    />
                                    <label for="place-2" class="ml-3 text-sm text-gray-200">
                                        Paris
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="place-3"
                                           name="place"
                                           @change="cityChange('Nice')"
                                           type="radio"
                                           class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                    />
                                    <label for="place-3" class="ml-3 text-sm text-gray-200">
                                        Nice
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input id="place-4"
                                           name="place"
                                           @change="cityChange('Lyon')"
                                           type="radio"
                                           class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                    />
                                    <label for="place-4" class="ml-3 text-sm text-gray-200">
                                        Lyon
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </aside>

            <section aria-labelledby="product-heading" class="mt-6 lg:mt-0 lg:col-span-2 xl:col-span-3">
                <h2 id="product-heading" class="sr-only">Trending Events in Marseille</h2>

                <div v-if="dataReady" class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8 xl:grid-cols-3">
                    <div v-for="event in events" :key="event.fields.id" class="group relative bg-blueGray-700 rounded-md flex flex-col overflow-hidden">
                        <a :href="route('events.show', {recordid: event.recordid})">
                            <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-96">
                                <img :src="event.fields.image ?? 'https://limg.app/i/gHlTvX.png'"
                                     :alt="event.fields.placename"
                                     class="w-full h-full object-center object-cover sm:w-full sm:h-full"
                                />
                            </div>
                            <div class="flex-1 p-4 space-y-2 flex flex-col">
                                <h3 class="text-sm font-medium text-gray-100">
                                    <a :href="route('events.show', {recordid: event.recordid})">
                                        <span aria-hidden="true" class="absolute inset-0" />
                                        {{ event.fields.title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-300 line-clamp-3"
                                   :title="event.fields.free_text">
                                    {{ event.fields.free_text }}
                                </p>
                                <div class="flex-1 flex flex-col justify-end">
                                    <p class="text-sm italic text-gray-300">
                                        {{ event.fields.placename }}, {{ event.fields.address }}
                                    </p>
                                    <p class="text-sm mt-2 font-medium text-gray-300">
                                        Price: {{ event.fields.pricing_info ?? 'No price available' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div v-else class="w-full mt-20 flex justify-center items-center">
                    <Loading />
                </div>
            </section>
        </div>
    </main>
</template>

<script>
import Loading from "@/Components/Loading";
const filters = [
    {
        id: 'category',
        name: 'Category',
        options: [
            { value: 'concert', label: 'Concert' },
            { value: 'spectacle', label: 'Spectacle' },
            { value: 'manifestation', label: 'Manifestation' },
            { value: 'competition', label: 'Competition' },
            { value: 'art', label: 'Art' },
            { value: 'sport', label: 'Sport' },
        ],
    },
    {
        id: 'place',
        name: 'Places',
        options: [
            { value: 'marseille', label: 'Marseille' },
            { value: 'paris', label: 'Paris' },
            { value: 'lyon', label: 'Lyon' },
        ],
    },
]

export default {
    name: 'trendingEvents',
    components: {Loading},
    setup() {
        return { filters }
    },

    data () {
        return {
            events: [],
            dataReady: false,
            city: 'Marseille'
        }
    },

    mounted () {
        this.getEvents()
    },

    methods: {
        cityChange: function(city) {
            this.city = city
            this.dataReady = false

            this.getEvents()
        },

        getEvents: function () {
            axios
                .get(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&lang=fr&rows=18&facet=city&refine.city=${this.city}&timezone=Europe%2FParis`)
                .then(response => {
                    this.dataReady = true
                    this.events = response.data.records
                })
        }
    }
}
</script>
