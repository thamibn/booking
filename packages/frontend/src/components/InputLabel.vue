<script setup>
defineProps(['value']);
</script>

<template>
    <label for="email" class="font-light">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot/></span>
    </label>
</template>
