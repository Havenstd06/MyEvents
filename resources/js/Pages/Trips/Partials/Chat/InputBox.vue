<template>

    <div class="h-12 flex items-end rounded-md bg-blueGray-900 w-full mt-1 py-2 px-1.5">
        <div class="flex flex-row items-center h-full w-full">
            <div class="flex-grow">
                <div class="relative w-full">
                    <input type="text"
                           v-model="message"
                           @keyup.enter="sendMessage"
                           class="flex w-full border border-gray-900 rounded-md focus:outline-none focus:border-blueGray-500 focus:ring-0 bg-blueGray-800 h-8"
                           placeholder="What's up Epitech?"
                    />
                </div>
            </div>
            <div class="ml-2">
                <button
                    @click="sendMessage"
                    class="flex items-center justify-center bg-blueGray-500 hover:bg-blueGray-600 rounded-md text-white px-4 py-1.5 flex-shrink-0"
                >
                    <span>Send</span>

                    <span v-if="loading"
                          class="ml-2"
                    >
                         <svg class="animate-spin h-4 w-4 -mt-2 -mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>

                    <span v-else
                          class="ml-2"
                    >
                  <svg class="w-4 h-4 transform rotate-45 -mt-px -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                  </svg>
                </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: ['room'],
  data () {
    return {
      message: '',
      loading: false
    }
  },
  methods: {
    /**
     * Send the message to the corresponding room.
     *
     */
    sendMessage () {
      if (!this.message) {
        return
      }
        var newMessage = this.message
      this.message = ''
      this.loading = true

        axios.post(`/trips/chat/${this.room}`, {
          text: newMessage
        }).then(response => {
          if (response.status === 201) {
              newMessage = ''
              this.loading = false
              this.$emit('messageSent')
          }
        }).catch(error => console.log(error.message))
    }
  }
}
</script>

