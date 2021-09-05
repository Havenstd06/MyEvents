<template>
    <div class="flex flex-col h-full overflow-y-auto">
        <div class="h-full flex flex-col-reverse overflow-y-auto">

            <div
                v-for="(message, index) in messages"
                :key="index"
            >
                <div
                    class="flex"
                    :class="isCurrentUserSender(message) ?
                    'items-center justify-start flex-row-reverse' :
                    'flex-row items-center'"
                >
                    <message-item
                        :message="message"
                        :self="isCurrentUserSender(message)"
                    />
                </div>

            </div>

        </div>
    </div>
</template>

<script>
import MessageItem from './MessageItem'

export default {
  components: { MessageItem },

  props: ['messages'],

  computed: {
    currentUser () {
      return this.$page.props.auth.user
    }
  },

  methods: {
    isCurrentUserSender (message) {
      return this.currentUser.id === message.user_id
    }
  }
}
</script>

