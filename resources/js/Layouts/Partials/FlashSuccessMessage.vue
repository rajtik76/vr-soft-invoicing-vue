<script lang="ts" setup>
import {ref} from "vue";
import {XMarkIcon} from "@heroicons/vue/24/outline";

defineProps<{
    message: string
}>()

const displayFlashMessage = ref(true)
</script>

<template>
    <div v-if="message && displayFlashMessage">
        <div class="text-gray-200 p-6 mb-2 bg-green-800">
            <div class="flex justify-between">
                <span>{{ message }}</span>
                <span><XMarkIcon class="w-6 h-6 hover:cursor-pointer" @click="displayFlashMessage = false"/></span>
            </div>
        </div>
    </div>
</template>
