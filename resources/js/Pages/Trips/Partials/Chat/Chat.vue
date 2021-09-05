<template>
    <div class="flex flex-col justify-between h-full overflow-x-auto overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
        <message-box :messages="messages" />

        <input-box :room="trip.id" @messageSent="getMessages" />
    </div>
</template>

<script>
import MessageBox from './MessageBox'
import InputBox from './InputBox'

export default {
  components: {
    InputBox,
    MessageBox
  },

    props: {
      trip: Array
    },

  data () {
      this.connectToPusher()

    return {
      messages: []
    }
  },

    ready() {
        window.addEventListener('beforeunload', this.leaveRoom);
    },

  methods: {
    getMessages () {
      axios.get(`/trips/chat/rooms/${this.trip.id}/messages`)
        .then(response => {
          this.messages = response.data
        })
        .catch(e => console.error(e.message()))
    },

    connectToPusher () {
      let $vm = this
      this.getMessages()
      Echo.private(`Chat.Room.${this.trip.id}`)
        .listen('NewMessageReceived', (e) => {
          $vm.getMessages()
        })
    },

    leaveRoom () {
      Echo.leave(`Chat.Room.${this.trip.id}`)
    }
  }
}
</script>

<style scoped>
.scrollbar-w-2::-webkit-scrollbar {
    width: 0.25rem;
    height: 0.25rem;
}

.scrollbar-track-blue-lighter::-webkit-scrollbar-track {
    --bg-opacity: 1;
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--bg-opacity));
}

.scrollbar-thumb-blue::-webkit-scrollbar-thumb {
    --bg-opacity: 1;
    background-color: #edf2f7;
    background-color: rgba(237, 242, 247, var(--bg-opacity));
}

.scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
    border-radius: 0.25rem;
}
</style>
