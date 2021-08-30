<template>
    <svg
        viewBox="0 0 24 24"
        :class="customClass"
    >
        <path d="M17 10H7v2h10v-2zm2-7h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-5-5H7v2h7v-2z" class='transition duration-300 ease-in-out fill-current text-white' :class="fill" />
    </svg>
    <h2 class="ml-2 text-lg transition duration-300 ease-in-out fill-current text-white" :class="fill">
        MyEvents
    </h2>
</template>

<script>
export default {
    name: "Cover",

    props: ['customClass', 'fill'],
}
</script>

<style scoped>

</style>
