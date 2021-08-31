
<template>
    <default>
        <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
            <main class="flex-1 flex overflow-hidden">
                <div class="flex-1 flex flex-col overflow-y-auto xl:overflow-hidden">
                    <div class="flex-1 flex xl:overflow-hidden">
                        <div class="flex-1 max-h-screen xl:overflow-y-auto">
                            <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                                <h1 class="text-3xl font-extrabold text-blue-gray-900">Account</h1>

                                <form @submit.prevent="updateProfileInformation"
                                      class="mt-6 space-y-8 divide-y divide-y-blue-gray-200"
                                >
                                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                        <div class="sm:col-span-6">
                                            <h2 class="text-xl font-medium text-blue-gray-900">Profile</h2>
                                            <p class="mt-1 text-sm text-blue-gray-500">This information will be displayed publicly so be careful what you share.</p>
                                        </div>


                                        <div class="sm:col-span-6">
                                            <label for="name" class="block text-sm font-medium text-blue-gray-900">
                                                Username
                                            </label>
                                            <div class="mt-1 flex flex-col rounded shadow-sm">
                                                <input type="text" name="name" id="name" v-model="form.name" autocomplete="username" class="flex-1 block w-full min-w-0 border-blue-gray-300 rounded text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500" />
                                                <jet-input-error :message="form.errors.name" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-8 grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                        <div class="sm:col-span-6">
                                            <h2 class="text-xl font-medium text-blue-gray-900">Personal Information</h2>
                                            <p class="mt-1 text-sm text-blue-gray-500">This information will be displayed publicly so be careful what you share.</p>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="email-address" class="block text-sm font-medium text-blue-gray-900">
                                                Email address
                                            </label>
                                            <input type="text" name="email" v-model="form.email" id="email-address" autocomplete="email" class="mt-1 block w-full border-blue-gray-300 rounded-md shadow-sm text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500" />
                                            <jet-input-error :message="form.errors.email" class="mt-2" />
                                        </div>

                                        <div class="sm:col-span-7 ">
                                            <label for="description" class="block text-sm font-medium text-blue-gray-900">
                                                Description
                                            </label>
                                            <textarea cols="10" name="description" v-model="form.description" id="description" autocomplete="description" class="mt-1 h-36 block w-full border-blue-gray-300 rounded-md shadow-sm text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500" />
                                            <jet-input-error :message="form.errors.description" class="mt-2" />
                                        </div>

                                        <p class="text-sm text-blue-gray-500 sm:col-span-6 flex flex-col space-y-1">
                                            <span v-if="user.provider">
                                                This account was linked with
                                                {{ user.provider }}.
                                            </span>
                                            <span>
                                                This account was created on
                                                {{ userCreatedAtForHumans }}.
                                            </span>
                                        </p>

                                    </div>

                                    <div class="pt-8 flex justify-end">
                                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-900 hover:bg-blue-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Cancel
                                        </button>
                                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </default>
</template>

<script>
import Default from "@/Layouts/Default";
import JetInputError from '@/Jetstream/InputError.vue'

export default {
    components: {
        Default,
        JetInputError
    },

    props: {
        user: Array,
        userCreatedAtForHumans: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: 'POST',
                name: this.user.name,
                email: this.user.email,
                description: this.user.description,
            }),
        }
    },

    methods: {
        updateProfileInformation() {
            this.form.post(route('profile.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => (console.log("successfully updated")),
            });
        },
    },
}
</script>
