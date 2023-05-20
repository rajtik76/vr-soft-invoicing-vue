<script lang="ts" setup>
import {computed, onMounted, ref} from 'vue';

const props = defineProps<{
    modelValue: string | number | boolean | null,
    options: Record<string, string | number>
}>();

defineEmits(['update:modelValue']);

const input = ref<HTMLInputElement | null>(null);

const sortedOptions = computed(() => {
  return Object.entries(props.options).sort((a, b) => {
    if (a[1] > b[1]) {
      return 1
    } else if (a[1] < b[1]) {
      return -1
    }

    return 0
  })
})

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
        <option v-for="(value) in sortedOptions" :key="value[0]" :value="value[0]">
            {{ value[1] }}
        </option>
    </select>
</template>
