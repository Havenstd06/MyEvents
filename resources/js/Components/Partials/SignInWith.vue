<template>
    <div>
        <div>
            <p class="text-sm font-medium text-blueGray-50">
                Sign in with
            </p>

            <div class="mt-1 grid grid-cols-4 gap-3">
                <div>
                    <a :href="route('social.oauth', {driver: 'github'})"
                    class="w-full inline-flex justify-center py-2 px-4 rounded-md shadow-sm bg-blueGray-700 text-sm font-medium text-blueGray-200 hover:bg-blueGray-900 hover:text-blueGray-50 transition duration-200 ease-in-out">
                        <span class="sr-only">Sign in with Github</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                <div>
                    <a :href="route('social.oauth', {driver: 'twitter'})"
                    class="w-full inline-flex justify-center py-2 px-4 rounded-md shadow-sm bg-blueGray-700 text-sm font-medium text-blueGray-200 hover:bg-blueGray-900 hover:text-blueGray-50 transition duration-200 ease-in-out">
                        <span class="sr-only">Sign in with Twitter</span>
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img"  class="w-5 h-5" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69c.88-.53 1.56-1.37 1.88-2.38c-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29c0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15c0 1.49.75 2.81 1.91 3.56c-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07a4.28 4.28 0 0 0 4 2.98a8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21C16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56c.84-.6 1.56-1.36 2.14-2.23z" fill="currentColor" />
                        </svg>
                    </a>
                </div>

                <div>
                    <a :href="route('social.oauth', {driver: 'discord'})"
                    class="w-full inline-flex justify-center py-2 px-4 rounded-md shadow-sm bg-blueGray-700 text-sm font-medium text-blueGray-200 hover:bg-blueGray-900 hover:text-blueGray-50 transition duration-200 ease-in-out">
                    <span class="sr-only">Sign in with Discord</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"
                            fill="currentColor"/>
                    </svg>
                    </a>
                </div>

                <div>
                    <a :href="route('social.oauth', {driver: 'facebook'})"
                    class="w-full inline-flex justify-center py-2 px-4 rounded-md shadow-sm bg-blueGray-700 text-sm font-medium text-blueGray-200 hover:bg-blueGray-900 hover:text-blueGray-50 transition duration-200 ease-in-out">
                    <span class="sr-only">Sign in with Facebook</span>
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M12 2.04c-5.5 0-10 4.49-10 10.02c0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89c1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02z" fill="currentColor" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-6 relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-blueGray-300"/>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-blueGray-800 text-blueGray-50">
                  Or continue with
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SignInWith"
}
</script>
