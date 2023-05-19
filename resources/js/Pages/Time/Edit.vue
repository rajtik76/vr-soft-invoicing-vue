<script lang="ts" setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import UpdateTaskForm from "@/Pages/Task/Partials/TaskForm.vue";
import {Task} from "@/types/task";
import DangerButton from "@/Components/DangerButton.vue";
import Panel from "@/Components/Panel.vue";
import PanelHeader from "@/Components/PanelHeader.vue";
import PanelContent from "@/Components/PanelContent.vue";
import {TimeResource} from "@/Pages/Time/Index.vue";

const props = defineProps<{
    time: TimeResource
}>()

function deleteTask() {
    if (confirm('Are you sure ?')) {
        router.delete(route('time.destroy', {time: props.time.id}))
    }
}
</script>

<template>
    <Head title="Time Log Edit"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Time Log Edit</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Panel>
<!--                    <UpdateTaskForm :contracts="contracts" :task="task"/>-->
                </Panel>

                <Panel>
                    <PanelContent>
                        <DangerButton @click.prevent="deleteTask">Tim Log Delete</DangerButton>
                    </PanelContent>
                </Panel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="postcss" scoped>

</style>
