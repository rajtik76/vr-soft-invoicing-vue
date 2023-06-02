<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import Panel from "@/Components/Panel.vue";
import {TaskResource, TaskSpentTimeResource} from "@/types/resource";
import {useTaskSpentTimeGrid} from "@/Composables/taskSpentTimeGrid.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseGrid from "@/Components/BaseGrid.vue";
import {GridColumn} from "@/types/grid";
import {ref} from "vue";

const props = defineProps<{
  task: TaskResource,
  hours: number,
}>();

const {gridColumns, deleteTimeRecord, editTimeRecord} = useTaskSpentTimeGrid()
const grid = ref<InstanceType<typeof BaseGrid> | null>(null)

function getModifiedGridColumns(): Array<GridColumn> {
  return gridColumns.filter(item => item.name !== 'task')
}

function deleteTimeLogRecordWithHook(id: number) {
  deleteTimeRecord(id, () => {
    grid.value?.updateGrid()
  })
}

</script>

<template>
  <Head title="Task Detail"/>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-500 leading-tight flex justify-between">
        <div>
          Task: <span class="text-gray-200">{{ task.name }}</span>
        </div>
        <div>
          Total: <span class="text-gray-200">{{ hours.toFixed(1) }}</span> hours
        </div>
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Create button -->
        <Panel>
          <div class="flex justify-between items-center">
            <div>
              <PrimaryButton class="!bg-green-600 hover:!bg-green-400"
                             @click.prevent="router.get(route('taskSpentTime.create', {task_id: task.id}))">
                Create New Time Log
              </PrimaryButton>
            </div>
          </div>
        </Panel>

        <Panel class="mt-4">
          <div class="text-gray-900 dark:text-gray-100">
            <div class="shadow-sm overflow-hidden">
              <BaseGrid ref="grid"
                        :columns="getModifiedGridColumns()"
                        :grid-url="route('grid.task.show')"
                        :grid-url-custom-post-data="{ task_id: task.id }">
                <template #task="{ row }: { row: TaskSpentTimeResource }">
                  {{ row.task.name }}
                </template>
                <template #actions="{ row }: { row: TaskSpentTimeResource }">
                  <div class="flex gap-1">
                    <PrimaryButton
                      class="hover:!bg-blue-500" @click="editTimeRecord(row.id)">
                      EDIT
                    </PrimaryButton>
                    <PrimaryButton
                      class="hover:!bg-red-500" @click="deleteTimeLogRecordWithHook(row.id)">
                      DELETE
                    </PrimaryButton>
                  </div>
                </template>
              </BaseGrid>
            </div>
          </div>
        </Panel>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
