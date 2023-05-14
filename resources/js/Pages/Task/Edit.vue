<script lang="ts" setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import UpdateTaskForm from "@/Pages/Task/Partials/TaskForm.vue";
import {Task} from "@/types/task";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps<{
    task: Task,
    contracts: [{
        id: number,
        name: string,
    }]
}>()

function deleteTask() {
    if (confirm('Are you sure ?')) {
        router.delete(route('task.destroy', {task: props.task.id}))
    }
}
</script>

<template>
    <Head title="Task Edit"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Task Edit</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdateTaskForm :task="task" :contracts="contracts"/>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Task deletion</h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Delete current task. Deleted task can't be restored so please take with care!
                            </p>
                        </header>
                        <div class="mt-6 space-y-6">
                            <DangerButton @click.prevent="deleteTask">Delete Task</DangerButton>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="postcss" scoped>

</style>
