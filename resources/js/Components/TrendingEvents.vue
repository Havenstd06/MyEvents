<template>
<!--        <section aria-labelledby="trending-heading">-->
<!--            <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:pt-32 lg:px-8 z-50">-->
<!--                <div class="md:flex md:items-center md:justify-between">-->
<!--                    <h2 id="favorites-heading" class="text-2xl font-extrabold tracking-tight text-gray-50">-->
<!--                        Trending Events in Marseille-->
<!--                    </h2>-->
<!--                    <a href="#" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 md:block">-->
<!--                        Find more Events<span aria-hidden="true"> &rarr;</span>-->
<!--                    </a>-->
<!--                </div>-->

<!--                <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">-->
<!--                    <div v-for="event in trendingEvents" :key="event.id" class="group relative">-->
<!--                        <div class="w-full h-56 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80">-->
<!--                            <img :src="event.fields.image" :alt="event.fields.placename" class="w-full h-full object-center object-cover" />-->
<!--                        </div>-->
<!--                        <h3 class="mt-4 text-sm text-gray-100">-->
<!--                            <a href="">-->
<!--                                <span class="absolute inset-0" />-->
<!--                                {{ event.fields.placename }} - {{ event.fields.title }}-->
<!--                            </a>-->
<!--                        </h3>-->
<!--                        <p class="mt-1 text-sm text-gray-300">-->
<!--                            {{ event.fields.address }}-->
<!--                        </p>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="mt-8 text-sm md:hidden">-->
<!--                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Shop the collection<span aria-hidden="true"> &rarr;</span></a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->
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
                                        <input :id="`${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" />
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
                        <div class="aspect-w-3 aspect-h-4 bg-gray-200 group-hover:opacity-75 sm:aspect-none sm:h-96">
                            <img :src="event.fields.image"
                                 @error="$event.target.src='https://limg.app/i/gHlTvX.png'"
                                 :alt="event.fields.placename"
                                 class="w-full h-full object-center object-cover sm:w-full sm:h-full"
                            />
                        </div>
                        <div class="flex-1 p-4 space-y-2 flex flex-col">
                            <h3 class="text-sm font-medium text-gray-100">
                                <a href="">
                                    <span aria-hidden="true" class="absolute inset-0" />
                                    {{ event.fields.placename }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-300 line-clamp-3"
                               :title="event.fields.free_text">
                                {{ event.fields.free_text }}
                            </p>
                            <div class="flex-1 flex flex-col justify-end">
                                <p class="text-sm italic text-gray-300">
                                    {{ event.fields.address }}
                                </p>
                                <p class="text-base font-medium text-gray-300">
                                    {{ event.fields.pricing_info }}
                                </p>
                            </div>
                        </div>
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
            { value: 'compétition', label: 'Compétition' },
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
    }
}
</script>
