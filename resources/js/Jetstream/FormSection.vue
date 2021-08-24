<template>
    <div>
        <div class="mt-5 md:mt-0 bg-blueGray-700 shadow"
             :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md sm:rounded-bl-md sm:rounded-br-md' : 'sm:rounded-md'"
        >
            <div class="px-4 pt-5">
                <h3 class="text-lg font-medium text-gray-200">
                    <slot name="title"></slot>
                </h3>

                <p class="mt-1 text-sm text-gray-300">
                    <slot name="description"></slot>
                </p>
            </div>

            <form @submit.prevent="$emit('submitted')">
                <div class="grid grid-cols-6 gap-6 px-4 sm:p-6 ">
                    <slot name="form"></slot>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-blueGray-800 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md" v-if="hasActions">
                    <slot name="actions"></slot>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from './SectionTitle.vue'

    export default {
        emits: ['submitted'],

        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !! this.$slots.actions
            }
        }
    }
</script>
