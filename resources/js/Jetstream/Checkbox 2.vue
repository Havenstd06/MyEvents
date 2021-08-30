<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="rounded border-blueGray-300 text-blueGray-800 shadow-sm focus:border-blueGray-600 focus:ring focus:ring-blueGray-200 focus:ring-opacity-50">
</template>

<script>
export default {
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
}
</script>
