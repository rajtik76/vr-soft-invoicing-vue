<script lang="ts" setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import UpdateTaskForm from "@/Pages/Task/Partials/TaskForm.vue";
import {Task} from "@/types/task";
import Panel from "@/Components/Panel.vue";

defineProps<{
    task: Task,
    contracts: Array<Record<string, string>>
}>()
</script>

<template>
    <Head title="Task Create"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Task Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Panel>
                    <UpdateTaskForm :contracts="contracts" :task="task"/>
                </Panel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="postcss" scoped>

</style>
