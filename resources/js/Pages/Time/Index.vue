<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import {Paginator, PaginatorTask} from "@/types/paginator";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {GridColumn} from "@/types/grid";
import Panel from "@/Components/Panel.vue";
import {TaskResource} from "@/types/resource";
import BaseGrid from "@/Components/BaseGrid.vue";

export interface TimeResource {
    id: number,
    task_id: number,
    task: TaskResource,
    date: string,
    time: number,
    note: string | null
}

export interface PaginatorTime extends Paginator {
    data: Array<TimeResource>
}

const props = defineProps<{
    times: PaginatorTask
}>();

const gridColumns: Array<GridColumn> = [
    {
        name: 'task',
        label: 'Task',
    },
    {
        name: 'date',
        label: 'Date',
        sortable: true,
        default: {
            sort: 'desc',
        }
    },
    {
        name: 'time',
        label: 'Hours',
    },
    {
        name: 'note',
        label: 'Note',
    },
]

function toggleActive() {
    router.post(route('task.toggle-active'))
}

</script>

<template>
    <Head title="Time Tracking List"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Time Tracking List</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Top panel -->
                <Panel>
                    <div class="flex justify-between items-center">
                        <div>
                            <PrimaryButton class="!bg-green-600 hover:!bg-green-400"
                                           @click.prevent="router.get(route('time.create'))"
                            >
                                Create New Time Log
                            </PrimaryButton>
                        </div>
                    </div>
                </Panel>

                <!-- Grid -->
                <Panel class="mt-4">
                    <div class="text-gray-900 dark:text-gray-100">
                        <div class="shadow-sm overflow-hidden">
                            <BaseGrid :columns="gridColumns" :grid-url="route('grid.time')">
                                <template #task="{ row }: { row: TimeResource }">
                                    {{ row.task.name }}
                                </template>
                            </BaseGrid>
                        </div>
                    </div>
                </Panel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
