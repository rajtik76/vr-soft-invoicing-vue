<script lang="ts" setup>
import {onMounted, ref} from 'vue';

defineProps<{
    modelValue: any,
    options: object[]
}>();

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({focus: () => input.value?.focus()});
</script>

<template>
    <select
        ref="input"
        :value="modelValue"
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >
        <option v-for="(value, key) in options" :key="key" :value="Object.values(value)[0]">
            {{ Object.values(value)[1] }}
        </option>
    </select>
</template>
