<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="type"
        class="px-2 py-1.5 w-full flex justify-center items-center text-white bg-primary rounded shadow-lg hover:bg-orange-600 focus:ring-4 focus:ring-red-100 focus:outline-none cursor-pointer"
        >
        <slot />
        <div v-if="isLoading" class="btn-spinner ml-4"></div>
    </button>
</template>
