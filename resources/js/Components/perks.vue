<template>
    <section aria-labelledby="perks-heading" class="bg-blueGray-800">
        <h2 id="perks-heading" class="sr-only">Our perks</h2>

        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 sm:py-32 lg:px-8">
            <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-0">
                <div v-for="perk in perks" :key="perk.name" class="text-center md:flex md:items-start md:text-left lg:block lg:text-center">
                    <div class="md:flex-shrink-0">
                        <div class="flow-root">
                            <img class="-my-1 h-24 w-auto mx-auto" :src="perk.imageUrl" alt="" />
                        </div>
                    </div>
                    <div class="mt-6 md:mt-0 md:ml-4 lg:mt-6 lg:ml-0">
                        <h3 class="text-sm font-semibold tracking-wide uppercase text-gray-100">
                            {{ perk.name }}
                        </h3>
                        <p class="mt-3 text-sm text-gray-300">
                            {{ perk.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {computed} from "vue";
    import {usePage} from "@inertiajs/inertia-vue3";

    const perks = [
        {
            name: 'Free returns',
            imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-returns-light.svg',
            description: 'Not what you expected? Place it back in the parcel and attach the pre-paid postage stamp.',
        },
        {
            name: 'Same day delivery',
            imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-calendar-light.svg',
            description:
                'We offer a delivery service that has never been done before. Checkout today and receive your products within hours.',
        },
        {
            name: 'All year discount',
            imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-gift-card-light.svg',
            description: 'Looking for a deal? You can use the code "ALLYEAR" at checkout and get money off all year round.',
        },
        {
            name: 'For the planet',
            imageUrl: 'https://tailwindui.com/img/ecommerce/icons/icon-planet-light.svg',
            description: 'We’ve pledged 1% of sales to the preservation and restoration of the natural environment.',
        },
    ]

    export default {
        name: 'perks',

        setup() {
            const app = computed(() => usePage().props.value.app)

            return {
                app,
                perks
            }
        }
    }
</script>
