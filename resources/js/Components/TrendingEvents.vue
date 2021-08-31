<template>
    <main class="max-w-2xl mx-auto px-4 lg:max-w-7xl lg:px-8">
        <div class="border-b border-gray-200 pt-24 pb-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-100">
                Trending Events
            </h1>
            <p class="mt-4 text-base text-gray-300">
                Discover the most popular events near Marseille!
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
                    <form class="divide-y divide-gray-200 space-y-10">
                        <div v-for="(section, sectionIdx) in filters" :key="section.name" :class="sectionIdx === 0 ? null : 'pt-10'">
                            <fieldset>
                                <legend class="block text-sm font-medium text-gray-100">
                                    {{ section.name }}
                                </legend>
                                <div class="pt-6 space-y-3">
                                    <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                                        <input :id="`${section.id}-${optionIdx}`"
                                               :name="`${section.id}[]`"
                                               :value="option.value"
                                               @change="checkboxChange"
                                               v-on:input="update(section.id + '-' + option.value)"
                                               type="checkbox"
                                               class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500"
                                        />
                                        <label :for="`${section.id}-${optionIdx}`" class="ml-3 text-sm text-gray-200">
                                            {{ option.label }}
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </aside>

            <section aria-labelledby="product-heading" class="mt-6 lg:mt-0 lg:col-span-2 xl:col-span-3">
                <h2 id="product-heading" class="sr-only">Trending Events in Marseille</h2>

                <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:gap-x-8 xl:grid-cols-3">
                    <div v-for="event in trendingEvents" :key="event.fields.id" class="group relative bg-blueGray-700 rounded-md flex flex-col overflow-hidden">
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
            </section>
        </div>
    </main>
</template>

<script>
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

    props: {
        trendingEvents: Array
    },

    setup() {
        return { filters }
    },

    methods: {
        checkboxChange: function(text) {
             // this.$emit("change", text);
            console.log(text)
        }
    }
}
</script>
