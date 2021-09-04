<template>
    <default>
        <main>
            <TabGroup>
                <TabList class="max-w-md mx-auto pt-24 pb-10 px-2">
                    <nav class="w-full rounded-lg shadow flex justify-center border border-blueGray-500-900" aria-label="Tabs">
                        <Tab v-slot="{ selected }" as="div"
                             class="rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-blueGray-600 py-4 px-4 text-sm font-medium text-center hover:bg-blueGray-800 focus:z-10 transition duration-200 ease-in-out cursor-pointer"
                             :class="[selected ? 'text-gray-100' : 'text-gray-200 hover:text-gray-100']"
                             :aria-current="selected ? 'page' : undefined"
                        >
                            <span>
                                Trending Events
                            </span>

                            <span aria-hidden="true"
                                  :class="[selected ? 'bg-blueGray-100' : 'bg-transparent', 'absolute inset-x-0 bottom-0 h-0.5']"
                            />
                        </Tab>
                        <Tab v-slot="{ selected }" as="div"
                             class="rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-blueGray-600 py-4 px-4 text-sm font-medium text-center hover:bg-blueGray-800 focus:z-10 transition duration-200 ease-in-out cursor-pointer"
                             :class="[selected ? 'text-gray-100' : 'text-gray-200 hover:text-gray-300']"
                             :aria-current="selected ? 'page' : undefined"
                        >
                            <span>
                                Joinable Trips
                            </span>

                            <span aria-hidden="true"
                                  :class="[selected ? 'bg-blueGray-100' : 'bg-transparent', 'absolute inset-x-0 bottom-0 h-0.5']"
                            />
                        </Tab>
                    </nav>
                </TabList>
                <TabPanels>
                    <TabPanel>
                        <trending-events />
                    </TabPanel>
                    <TabPanel>
                        <joinable-trips
                            :trips="trips"
                        />
                    </TabPanel>
                </TabPanels>
            </TabGroup>
        </main>
    </default>
</template>

<script>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue'
import {Head, usePage} from '@inertiajs/inertia-vue3';
import Default from "../Layouts/Default";
import {computed} from "vue";
import TrendingEvents from "@/Components/TrendingEvents";
import Perks from "@/Components/Perks";
import JoinableTrips from "@/Components/JoinableTrips";


export default {
    name: "Home",

    components: {
        JoinableTrips,
        TrendingEvents,
        Perks,
        Head,
        Default,
        TabGroup,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
    },

    props: {
        trips: Array
    },

    setup() {
        const app = computed(() => usePage().props.value.app)

        return {
            app
        }
    }
}
</script>
