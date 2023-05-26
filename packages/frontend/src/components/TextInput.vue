<script setup>
import {useAttrs} from 'vue';

const attr = useAttrs();
defineProps(['modelValue', 'placeholder']);

defineEmits(['update:modelValue']);

</script>

<template>
    <div class="mt-2 border-0 p-0 m-0">
        <input
            v-bind="attr"
            :value="modelValue"
            :placeholder="placeholder"
            @input="$emit('update:modelValue', $event.target.value)"
            class="py-1.5 w-full border border-gray-300 rounded-md font-light
             focus-within:shadow-lg focus-within:border-primary focus:outline-none
              focus:ring-0 focus:border-primary transition ease-out text-sm text-gray-600"
        />
    </div>
</template>
