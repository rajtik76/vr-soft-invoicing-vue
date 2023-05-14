<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {PaginatorTask} from "@/types/paginator";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {GridColumns} from "@/types/grid";
import Grid from "@/Components/Grid.vue";
import {PencilSquareIcon} from "@heroicons/vue/24/outline";

const props = defineProps<{
    tasks: PaginatorTask
}>();

const gridColumns = <GridColumns>[
    {
        name: 'customer',
        title: 'Customer',
    },
    {
        name: 'name',
        title: 'Name',
        sort: true
    },
    {
        name: 'hours',
        title: 'Hours',
    },
    {
        name: 'created_at',
        title: 'Created',
        sort: true,
        default: {
            sort: true,
            sortOrder: 'desc'
        }
    },
]

function toggleActive() {
    router.post(route('task.toggle-active'))
}

</script>

<template>
    <Head title="Task list"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Task list</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Top panel -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input :checked="$page.props.taskActive" class="sr-only peer" type="checkbox"
                                           @change="toggleActive">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span
                                        class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Active Task</span>
                                </label>
                            </div>
                            <div>
                                <PrimaryButton class="!bg-green-600 hover:!bg-green-400"
                                               @click.prevent="router.get(route('task.create'))"
                                >
                                    Create New Task
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="shadow-sm overflow-hidden my-8">
                            <Grid :columns="gridColumns" :data="tasks" :withActions="true">
                                <template #name="{ row }">
                                    <span v-if="row.url">
                                        <a
                                            :href="row.url"
                                            class="underline"
                                            target="_blank"
                                        >
                                            {{ row.name }}
                                        </a>
                                    </span>
                                    <span v-else>{{ row.name }}</span>
                                </template>
                                <template #action="{ row }">
                                    <div class="flex gap-1 my-0.5">
                                        <Link
                                            :href="route('task.edit', {task: row.id})"
                                            as="button"
                                            class="bg-gray-600 rounded py-1 px-3 !bg-blue-800 hover:!bg-blue-500"
                                        >
                                            <PencilSquareIcon class="w-5 h-5 text-white"/>
                                        </Link>
                                    </div>
                                </template>
                            </Grid>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="postcss">
table > thead > tr > th {
    @apply border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left
}

table > tbody > tr > td {
    @apply border-b border-slate-100 dark:border-slate-700 p-2 pl-8 text-slate-500 dark:text-slate-400
}
</style>
