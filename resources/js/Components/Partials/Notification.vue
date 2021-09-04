<template>
    <!-- Global notification live region, render this permanently at the end of the document -->
    <div class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-50">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-center">
            <!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
            <transition
                enter-active-class="transform ease-out duration-300 transition"
                enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-if="($page.props.notification.success || $page.props.notification.error || $page.props.notification.warning) && show"
                     class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
                >
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0" v-if="$page.props.notification.success">
                                <check-circle-icon class="h-6 w-6 text-green-400" />
                            </div>
                            <div class="flex-shrink-0" v-if="$page.props.notification.error">
                                <exclamation-circle-icon class="h-6 w-6 text-red-400" />
                            </div>
                            <div class="flex-shrink-0" v-if="$page.props.notification.warning">
                                <exclamation-icon class="h-6 w-6 text-orange-400" />
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5" v-if="$page.props.notification.success">
                                <p class="text-sm font-medium text-gray-900">
                                    Success!
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $page.props.notification.success }}
                                </p>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5" v-if="$page.props.notification.error">
                                <p class="text-sm font-medium text-gray-900">
                                    Error!
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $page.props.notification.error }}
                                </p>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5" v-if="$page.props.notification.warning">
                                <p class="text-sm font-medium text-gray-900">
                                    Warning!
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $page.props.notification.warning }}
                                </p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import { CheckCircleIcon, ExclamationCircleIcon, ExclamationIcon } from '@heroicons/vue/outline'
import { XIcon } from '@heroicons/vue/solid'

export default {
    name: 'Notification',

    components: {
        CheckCircleIcon,
        XIcon,
        ExclamationCircleIcon,
        ExclamationIcon
    },

    data() {
        return {
          show: true,
        }
    },

    watch: {
      '$page.props.notification': {
        handler() {
          this.show = true
        },
        deep: true,
      },
    },

    created() {
        this.timeout = setTimeout(() => {
          this.show = false
        }, 4000)
    }
}
</script>
