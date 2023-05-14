<script lang="ts" setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import UpdateTaskForm from "@/Pages/Task/Partials/TaskForm.vue";
import {Task} from "@/types/task";
import DangerButton from "@/Components/DangerButton.vue";
import Panel from "@/Components/Panel.vue";
import PanelHeader from "@/Components/PanelHeader.vue";
import PanelContent from "@/Components/PanelContent.vue";

const props = defineProps<{
    task: Task,
    contracts: { [key: string]: string }
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
                <Panel>
                    <UpdateTaskForm :contracts="contracts" :task="task"/>
                </Panel>

                <Panel>
                    <PanelHeader title="Task deletion" description="Delete current task. Deleted task can't be restored so please take with care!"/>
                    <PanelContent>
                        <DangerButton @click.prevent="deleteTask">Delete Task</DangerButton>
                    </PanelContent>
                </Panel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="postcss" scoped>

</style>
