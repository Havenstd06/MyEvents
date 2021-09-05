<template>

    <div class="flex flex-col items-center space-y-1 p-2 rounded-md">
        <img class="flex items-center justify-center h-8 w-auto rounded-full flex-shrink-0"
             :src="'/' + message.user.avatar"
             alt="Havens" />

        <h3 class="font-medium text-sm">
            {{ message.user.name }}
        </h3>
    </div>

    <Popper
        arrow
        :hover="true"
        placement="top"
        :content="readableDate(message.created_at)"
    >
        <div
            class="relative text-sm py-2 px-4 shadow rounded-xl ml-1"
            :class="decorativeClasses"
            v-html="message.text"
        />
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
    }
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
    font-weight: 600;
    text-transform: uppercase;
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

