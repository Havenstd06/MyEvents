<template>
    <button :type="type" class="px-3 py-1.5 text-base font-medium text-white transition duration-300 ease-in-out transform bg-blueGray-500 border-blueGray-600 rounded-md focus:outline-none focus:ring-0 hover:bg-blueGray-600">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    }
</script>
