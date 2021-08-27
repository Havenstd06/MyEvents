
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

                                        <div class="sm:col-span-6">
                                            <label for="photo" class="block text-sm font-medium text-blue-gray-900">
                                                Photo
                                            </label>
                                            <div class="mt-1 flex items-center">
                                                <img class="inline-block h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2.5&w=256&h=256&q=80" alt="" />
                                                <div class="ml-4 flex">
                                                    <div class="relative bg-white py-2 px-3 border border-blue-gray-300 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                                        <label for="user-photo" class="relative text-sm font-medium text-black pointer-events-none">
                                                            <span>Change</span>
                                                            <span class="sr-only"> user photo</span>
                                                        </label>
                                                        <input id="user-photo" name="user-photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md" />
                                                    </div>
                                                    <button type="button" class="ml-3 bg-transparent py-2 px-3 border border-transparent rounded-md text-sm font-medium text-blue-gray-900 hover:text-blue-gray-700 focus:outline-none focus:border-blue-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-gray-50 focus:ring-blue-500">
                                                        Remove
                                                    </button>
                                                </div>
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

                                        <p class="text-sm text-blue-gray-500 sm:col-span-6 flex flex-col space-y-1">
                                            <span>
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
                                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-blue-gray-900 hover:bg-blue-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
