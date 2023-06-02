<script lang="ts" setup>
import {onMounted, ref, watch} from "vue";
import {XMarkIcon} from "@heroicons/vue/24/outline";

const props = defineProps<{
    message: string
}>()

const displayFlashMessage = ref(true)

onMounted(() => {
    console.log('Flash: ', props.message.length > 0 && displayFlashMessage.value)
    if (props.message.length > 0 && displayFlashMessage.value) {
        setTimeout(function () {
            displayFlashMessage.value = false
        }, 10000)
    }
})
</script>

<template>
    <Transition>
        <div v-if="message && displayFlashMessage">
            <div class="text-gray-200 p-6 mb-2 bg-green-800">
                <div class="flex justify-between">
                    <span>{{ message }}</span>
                    <span><XMarkIcon class="w-6 h-6 hover:cursor-pointer" @click="displayFlashMessage = false"/></span>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
