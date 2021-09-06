<template>

    <Popper
        arrow
        :hover="true"
        placement="top"
        :content="message.user.name"
    >
    <div class="w-24 flex flex-col items-center space-y-1 p-2 rounded-md">
        <img class="flex items-center justify-center h-8 w-auto rounded-full flex-shrink-0"
             :src="'/' + message.user.avatar"
             :alt="message.user.name + '\'s avatar'" />


        <h3 class="font-medium text-center text-sm"
            v-html="message.user.name.split(' ')[0]"
        />
    </div>
    </Popper>

    <Popper
        arrow
        :hover="true"
        placement="top"
        :content="readableDate(message.created_at)"
    >
        <div
            class="relative text-sm py-2 px-4 shadow rounded-xl ml-1"
            :class="decorativeClasses"
        >
            <a v-if="message.text.substring(0, 8) === 'https://'"
               :href="message.text"
               target="_blank"
               v-html="message.text"
               class="text-blue-500 hover:text-blue-600 underline"
            >
            </a>
            <span v-else v-html="message.text" />
        </div>
    </Popper>

</template>

<script>
import Popper from "vue3-popper";

export default {
  props: ['message', 'self'],

    components: {
        Popper,
    },

  computed: {
    decorativeClasses () {
      if (this.self) {
        return 'bg-blueGray-900'
      }
      return 'bg-gray-900'
    },
  },
  methods: {
    readableDate (date) {
      return (new Date(date)).toLocaleString()
    }
  }
}
</script>

<style scoped>
:deep(.popper) {
    background: #0F172A;
    padding: 0.375rem 0.5rem;
    border-radius: 50px;
    color: #F8FAFC;
    font-weight: 500;
    font-size: 0.875rem;
    line-height: 1.25rem;
}

:deep(.popper #arrow::before) {
    background: #0F172A;
}

:deep(.popper:hover),
:deep(.popper:hover > #arrow::before) {
    background: #0F172A;
}
</style>

