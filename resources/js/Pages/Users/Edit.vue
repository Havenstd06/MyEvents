
<template>
    <default>
        <div class="flex-1 min-w-0 flex flex-col overflow-hidden mb-6">
            <main class="flex-1 flex overflow-hidden">
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <div class="flex-1 flex">
                        <div class="flex-1 max-h-screen xl:overflow-y-auto">
                            <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:py-12 lg:px-8">
                                <h1 class="text-3xl font-extrabold text-blueGray-100">Account</h1>

                                <form @submit.prevent="updateProfileInformation"
                                      class="mt-6 space-y-8 divide-y divide-y-blueGray-200"
                                >
                                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                        <div class="sm:col-span-6">
                                            <h2 class="text-xl font-medium text-blueGray-200">Profile</h2>
                                            <p class="mt-1 text-sm text-blueGray-300">
                                                This information will be displayed publicly so be careful what you share.
                                            </p>
                                        </div>


                                        <div class="sm:col-span-3">
                                            <label for="name" class="block text-sm font-medium text-blueGray-100">
                                                Name
                                            </label>
                                            <div class="mt-1 flex flex-col rounded shadow-sm">
                                                <input type="text" name="name" id="name" v-model="form.name" autocomplete="username" class="flex-1 block w-full min-w-0 border-blueGray-300 rounded text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500" />
                                                <jet-input-error :message="form.errors.name" class="mt-2" />
                                            </div>
                                        </div>


                                        <div class="sm:col-span-5">
                                            <!-- Profile Avatar File Input -->
                                            <input type="file" class="hidden"
                                                   ref="avatar"
                                                   @change="updateAvatarPreview">

                                            <label for="avatar" class="block text-sm font-medium text-blueGray-100">
                                                Avatar
                                            </label>
                                            <div class="mt-1 flex items-center">
                                                <!-- Current Profile Avatar -->
                                                <div class="mt-2" v-show="! avatarPreview">
                                                    <img :src="'/' + user.avatar" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                                                </div>

                                                <!-- New Profile Avatar Preview -->
                                                <div class="mt-2" v-show="avatarPreview">
                    <span class="block rounded-full w-20 h-20"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + avatarPreview + '\');'">
                    </span>
                                                </div>

                                                <div class="ml-4 flex items-center">
                                                    <button type="button"
                                                            @click.prevent="selectNewAvatar"
                                                            class="relative bg-blueGray-700 py-2 px-3 border border-blueGray-300 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-blueGray-800 focus-within:outline-none transition duration-200 ease-in-out focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blueGray-50 focus-within:ring-blue-500"
                                                    >
                                                       Change
                                                    </button>
                                                    <button type="button"
                                                            @click.prevent="deleteAvatar"
                                                            v-if="user.avatar !== 'avatars/default.png'"
                                                            class="ml-3 bg-transparent py-2 px-3 border border-transparent rounded-md text-sm font-medium text-blueGray-100 hover:text-blueGray-200 focus:outline-none transition duration-200 ease-in-out focus:border-blueGray-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blueGray-50 focus:ring-blue-500"
                                                    >
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                            <jet-input-error :message="form.errors.avatar" class="mt-2" />

                                        </div>
                                    </div>

                                    <div class="pt-8 grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                        <div class="sm:col-span-6">
                                            <h2 class="text-xl font-medium text-blueGray-100">Personal Information</h2>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="email-address" class="block text-sm font-medium text-blueGray-100">
                                                Email address
                                            </label>
                                            <input type="text" name="email" v-model="form.email" id="email-address" autocomplete="email" class="mt-1 block w-full border-blueGray-300 rounded-md shadow-sm text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500" />
                                            <jet-input-error :message="form.errors.email" class="mt-2" />
                                        </div>

                                        <div class="sm:col-span-7 ">
                                            <label for="description" class="block text-sm font-medium text-blueGray-100">
                                                Description
                                            </label>
                                            <textarea cols="10" name="description" v-model="form.description" id="description" autocomplete="description" class="mt-1 h-36 block w-full border-blueGray-300 rounded-md shadow-sm text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500" />
                                            <jet-input-error :message="form.errors.description" class="mt-2" />
                                        </div>

                                        <p class="text-sm text-blueGray-200 sm:col-span-6 flex flex-col space-y-1">
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
                                        <ButtonNormal type="submit" class="ml-3">
                                            Save
                                        </ButtonNormal>
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
import ButtonNormal from "@/Components/Buttons/ButtonNormal";

export default {
    components: {
        ButtonNormal,
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
                avatar: null,
            }),

            avatarPreview: null,
        }
    },

    methods: {
        updateProfileInformation() {
            if (this.$refs.avatar) {
                this.form.avatar = this.$refs.avatar.files[0]
            }

            this.form.post(route('profile.update', {
                'user': this.user.id
            }), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => (this.clearAvatarFileInput()),
            });
        },

        selectNewAvatar() {
            this.$refs.avatar.click();
        },

        updateAvatarPreview() {
            const avatar = this.$refs.avatar.files[0];

            if (! avatar) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.avatarPreview = e.target.result;
            };

            reader.readAsDataURL(avatar);
        },

        deleteAvatar() {
            this.$inertia.delete(route('profile.current-user-avatar.destroy'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.avatarPreview = null;
                    this.clearAvatarFileInput();
                },
            });
        },

        clearAvatarFileInput() {
            if (this.$refs.avatar?.value) {
                this.$refs.avatar.value = null;
            }
        },
    },
}
</script>
