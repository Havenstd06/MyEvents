<template>
    <Head title="Register" />

    <auth>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="description" value="description" />
                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" required autocomplete="description" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-200 hover:text-gray-200">
                    Already registered?
                </Link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </jet-button>
            </div>
        </form>
    </auth>
</template>

<script>
    import JetButton from '../../Jetstream/Button.vue'
    import JetInput from '../../Jetstream/Input.vue'
    import JetCheckbox from '../../Jetstream/Checkbox.vue'
    import JetLabel from '../../Jetstream/Label.vue'
    import JetValidationErrors from '../../Jetstream/ValidationErrors.vue'
    import Auth from "../../Layouts/Auth";
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Auth,
            Head,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    description: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
