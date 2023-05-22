<script lang="ts" setup>

import {ContractResource, ReportResource} from "@/types/resource";
import {computed} from "vue";

const props = defineProps<{
    reportDate: string,
    contract: ContractResource,
    taskSpentTimes: Array<ReportResource>
}>()

const total = computed(() => {
    return props.taskSpentTimes.reduce((accumulator, value) => accumulator + value.time, 0)
})

function getDayTotal(date) {
    return props.taskSpentTimes.reduce((accumulator, value) => accumulator + (value.date === date ? value.time : 0), 0)
}

</script>

<template>
    <div class="p-6">

        <!-- Title -->
        <div class="flex justify-between uppercase text-4xl font-bold">
            <p>Time log overview {{ reportDate }}</p>
            <p>{{ total.toFixed(1) }} hours</p>
        </div>

        <!-- Customer -->
        <div class="text-2xl mt-6">
            {{ contract.customer.name }}
        </div>

        <!-- Time log -->
        <div class="mt-16">
            <div v-for="(taskSpentTime, index) in taskSpentTimes" :key="index">

                <!-- Header -->
                <div v-if="index === 0"
                     class="grid grid-cols-12 gap-4 uppercase text-xl font-bold py-4 bg-gray-300 rounded-lg mb-2 px-8">
                    <div>Date</div>
                    <div class="col-span-6">Task</div>
                    <div>Hours</div>
                    <div class="col-span-4">Note</div>
                </div>

                <!-- Rows -->
                <div class="grid grid-cols-12 gap-4 px-8">
                    <div>{{ taskSpentTime.date }}</div>
                    <div class="col-span-6">
                        <a v-if="taskSpentTime.task.url" :href="taskSpentTime.task.url" class="underline text-blue-800">{{
                                taskSpentTime.task.name
                            }}</a>
                        <div v-else>{{ taskSpentTime.task.name }}</div>
                    </div>
                    <div>{{ taskSpentTime.time.toFixed(1) }}</div>
                    <div class="col-span-4">{{ taskSpentTime.note }}</div>
                </div>

                <!-- Day total -->
                <div v-if="index < taskSpentTimes.length && ((taskSpentTime.date !== taskSpentTimes[index + 1]?.date) || (index === taskSpentTimes.length))"
                     class="px-8 py-4 uppercase font-bold text-lg bg-slate-100 my-6 rounded-lg">
                    <div class="grid grid-cols-12 gap-4">
                        <div>{{ taskSpentTimes[index - 1].date }}</div>
                        <div>Total</div>
                        <div class="col-span-5"></div>
                        <div>{{ getDayTotal(taskSpentTimes[index - 1].date).toFixed(1) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
