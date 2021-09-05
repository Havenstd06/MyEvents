<template>
    <main class="max-w-2xl mx-auto px-4 lg:max-w-7xl lg:px-8">
        <div class="border-b border-gray-200 pb-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-100">
                Trending Events in {{ this.city ?? 'All over the world' }}
            </h1>
            <p class="mt-4 text-base text-gray-300">
                Discover the most popular events near {{ this.city ?? 'All over the world' }}!
            </p>
        </div>

        <div class="pt-12 pb-24 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
            <aside>
                <h2 class="sr-only">Filters</h2>

                <button type="button" class="inline-flex items-center lg:hidden" @click="mobileFiltersOpen = true">
                    <span class="text-sm font-medium text-gray-700">Filters</span>
                </button>

                <div class="hidden lg:block">
                    <div class="divide-y divide-gray-200 space-y-10">
                        <div>
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    City
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div v-for="cit in cities"
                                         class="flex items-center">
                                        <input :id="cit.value"
                                               name="city"
                                               @change="cityChange(cit.label)"
                                               type="radio"
                                               class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                               :checked="cit.checked && city === cit.label"

                                        />
                                        <div class="flex items-center justify-between w-full">
                                            <label :for="cit.value"
                                                   class="ml-3 text-sm text-gray-200"
                                                   v-html="cit.label"
                                            />

                                            <div v-if="city === cit.label">
                                                <button type="button"
                                                        @click="cityChange(null)"
                                                        class="text-sm text-red-600">
                                                    <TrashIcon class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <input type="text"
                                               name="custom_city"
                                               :value="city"
                                               @change="e => this.cityChange(e.target.value)"
                                               placeholder="Marseille"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="pt-10">
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    Categories
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div v-for="cat in categories"
                                         class="flex items-center">
                                        <input :id="cat.value"
                                               name="category"
                                               @change="categoryChange(cat.label)"
                                               type="radio"
                                               class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                               :checked="category === cat.label"
                                        />
                                        <div class="flex items-center justify-between w-full">
                                            <label :for="cat.value"
                                                   class="ml-3 text-sm text-gray-200"
                                                   v-html="cat.label"
                                            />

                                            <div v-if="category === cat.label">
                                                <button type="button"
                                                        @click="categoryChange(null)"
                                                        class="text-sm text-red-600">
                                                    <TrashIcon class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <input type="text"
                                               name="custom_category"
                                               :value="category"
                                               @change="e => this.categoryChange(e.target.value)"
                                               placeholder="Concert"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="pt-10">
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    Region (ex: Provence-Alpes-Côte d'Azur)
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div>
                                        <input type="text"
                                               name="custom_region"
                                               :value="region"
                                               @change="e => this.regionChange(e.target.value)"
                                               placeholder="Provence-Alpes-Côte d'Azur"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="pt-10">
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    Department (ex: Bouches-du-Rhône)
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div>
                                        <input type="text"
                                               name="custom_placename"
                                               :value="department"
                                               @change="e => this.departmentChange(e.target.value)"
                                               placeholder="Bouches-du-Rhône"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="pt-10">
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    Place Name (ex: LA MAGALONE)
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div>
                                        <input type="text"
                                               name="custom_placename"
                                               :value="placename"
                                               @change="e => this.placenameChange(e.target.value)"
                                               placeholder="LA MAGALONE"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="pt-10">
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    Date start (ex: 2020-09-26)
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div>
                                        <input type="text"
                                               name="custom_datestart"
                                               :value="datestart"
                                               @change="e => this.datestartChange(e.target.value)"
                                               placeholder="2020-09-26"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="pt-10">
                            <fieldset role="group">
                                <legend class="block font-medium text-gray-100">
                                    Date end (ex: 2020-09-27)
                                </legend>
                                <div class="pt-3 space-y-3">
                                    <div>
                                        <input type="text"
                                               name="custom_dateend"
                                               :value="dateend"
                                               @change="e => this.dateendChange(e.target.value)"
                                               placeholder="2020-09-27"
                                               class="shadow-sm bg-blueGray-700 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        />
                                    </div>
                                </div>
                            </fieldset>
                        </div>
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
                                    <Link :href="route('events.show', {recordid: event.recordid})">
                                        <span aria-hidden="true" class="absolute inset-0" />
                                        {{ event.fields.title }}
                                    </Link>
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
import { Link } from '@inertiajs/inertia-vue3';
import { TrashIcon } from '@heroicons/vue/outline'
import Loading from "@/Components/Loading";
import Input from "@/Jetstream/Input";

const cities =
    [
        { value: 'marseille', label: 'Marseille', checked: true },
        { value: 'paris', label: 'Paris', checked: false  },
        { value: 'nice', label: 'Nice', checked: false  },
        { value: 'lyon', label: 'Lyon', checked: false  },
    ]

const categories =
    [
        { value: 'concert', label: 'Concert' },
        { value: 'spectacle', label: 'Spectacle' },
        { value: 'manifestation', label: 'Manifestation' },
        { value: 'competition', label: 'Competition' },
        { value: 'art', label: 'Art' },
        { value: 'sport', label: 'Sport' },
    ]

export default {
    name: 'trendingEvents',
    components: {
        Input,
        Loading,
        TrashIcon,
        Link
    },

    setup() {
        return {
            cities,
            categories
        }
    },

    data () {
        return {
            events: [],
            dataReady: false,
            city: 'Marseille',
            category: null,
            region: null,
            department: null,
            placename: null,
            datestart: null,
            dateend: null
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

        categoryChange: function(category) {
            this.category = category
            this.dataReady = false

            this.getEvents()
        },

        regionChange: function(region) {
            this.region = region
            this.dataReady = false

            this.getEvents()
        },

        departmentChange: function(department) {
            this.department = department
            this.dataReady = false

            this.getEvents()
        },

        placenameChange: function(placename) {
            this.placename = placename
            this.dataReady = false

            this.getEvents()
        },

        datestartChange: function(datestart) {
            this.datestart = datestart
            this.dataReady = false

            this.getEvents()
        },

        dateendChange: function(dateend) {
            this.dateend = dateend
            this.dataReady = false

            this.getEvents()
        },

        getEvents: function () {
            axios
                .get(`https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-cibul&q=&lang=fr&rows=18&facet=city${this.city !== null ? `&refine.city=${this.city}`: ''}${this.category !== null ? `&refine.tags=${this.category}` : ''}${this.region !== null ? `&refine.region=${this.region}` : ''}${this.department !== null ? `&refine.department=${this.department}` : ''}${this.placename !== null ? `&refine.placename=${this.placename}` : ''}${this.datestart !== null ? `&refine.date_start=${this.datestart}` : ''}${this.dateend !== null ? `&refine.date_end=${this.dateend}` : ''}&timezone=Europe%2FParis`, {
                    transformRequest: [function (data, headers) {
                        delete headers['X-Socket-Id'];
                        return data;
                    }]
                })
                .then(response => {
                    this.dataReady = true
                    this.events = response.data.records
                })
        }
    }
}
</script>
