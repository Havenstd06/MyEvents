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
                    <span class="ml-2">
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
      message: ''
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
      axios
        .post(`/trips/chat/${this.room}`, {
          text: this.message
        })
        .then(response => {
          if (response.status === 201) {
            this.message = ''
            this.$emit('messageSent')
          }
        })
        .catch(error => console.log(error.message))
    }
  }
}
</script>

