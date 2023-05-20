<script lang="ts" setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import Panel from "@/Components/Panel.vue";
import {TaskResource, TaskSpentTimeResource} from "@/types/resource";
import TaskSpentTimeForm from "@/Pages/TaskSpentTime/Partials/TaskSpentTimeForm.vue";

const props = defineProps<{
  taskSpentTime: TaskSpentTimeResource,
  tasks: Record<string, string>
}>()

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
          <TaskSpentTimeForm :task-spent-time="taskSpentTime" :tasks="tasks" />
        </Panel>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style lang="postcss" scoped>

</style>
