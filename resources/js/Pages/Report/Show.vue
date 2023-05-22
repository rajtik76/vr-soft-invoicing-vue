<script lang="ts" setup>

import {ContractResource, ReportResource} from "@/types/resource";
import {computed} from "vue";
import {getCzechTranslation, getEnglishTranslation} from "@/Pages/Report/Partials/reportTranslations";

const props = defineProps<{
    reportDate: string,
    contract: ContractResource,
    taskSpentTimes: Array<ReportResource>
}>()

const total = computed(() => {
    return props.taskSpentTimes.reduce((accumulator, value) => accumulator + value.time, 0)
})

const translations = computed(() => {
    if (props.contract.bank.currency === 'CZK') {
        return getCzechTranslation()
    } else {
        return getEnglishTranslation()
    }
})

function getDayTotal(date: string) {
    return props.taskSpentTimes.reduce((accumulator, value) => accumulator + (value.date === date ? value.time : 0), 0)
}

</script>

<template>
    <div class="p-6">

        <div class="border-8 border-gray-400 rounded-lg p-8">

            <!-- Title -->
            <div class="flex justify-between uppercase text-3xl font-bold">
                <p>{{ translations.title }} {{ reportDate }}</p>
                <p>{{ total.toFixed(1) }} {{ translations.hours }} {{ translations.total }}</p>
            </div>

            <!-- Customer -->
            <div class="text-xl mt-2">
                {{ translations.customer }}: {{ contract.customer.name }}
            </div>

        </div>

        <!-- Time log -->
        <div class="mt-8">
            <div v-for="(taskSpentTime, index) in taskSpentTimes" :key="index">

                <!-- Header -->
                <div v-if="index === 0"
                     class="grid grid-cols-12 gap-4 uppercase text-xl font-bold py-4 bg-gray-400 rounded-lg mb-2 px-8 border border-gray-400">
                    <div class="border-r border-gray-500">{{ translations.date }}</div>
                    <div class="col-span-6 border-r border-gray-500">{{ translations.task }}</div>
                    <div class="border-r border-gray-500">{{ translations.hours }}</div>
                    <div class="col-span-4">{{ translations.note }}</div>
                </div>

                <!-- Rows -->
                <div class="grid grid-cols-12 gap-4 px-8 text-gray-500">
                    <div class="border-r">{{ taskSpentTime.date }}</div>
                    <div class="col-span-6 border-r">
                        <a v-if="taskSpentTime.task.url" :href="taskSpentTime.task.url" class="underline text-blue-500">{{
                                taskSpentTime.task.name
                            }}</a>
                        <div v-else>{{ taskSpentTime.task.name }}</div>
                    </div>
                    <div class="border-r">{{ taskSpentTime.time.toFixed(1) }}</div>
                    <div class="col-span-4">{{ taskSpentTime.note }}</div>
                </div>

                <!-- Day total -->
                <div
                    v-if="index < taskSpentTimes.length && ((taskSpentTime.date !== taskSpentTimes[index + 1]?.date) || (index === taskSpentTimes.length))"
                    class="px-8 py-2 uppercase bg-slate-100 my-4 rounded-lg border border-slate-200">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="border-r">{{ taskSpentTime.date }}</div>
                        <div>{{ translations.total }}</div>
                        <div class="col-span-5 border-r"></div>
                        <div class="border-r">{{ getDayTotal(taskSpentTime.date).toFixed(1) }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
