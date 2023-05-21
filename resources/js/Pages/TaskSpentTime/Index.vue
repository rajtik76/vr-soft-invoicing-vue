<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Panel from "@/Components/Panel.vue";
import {TaskSpentTimeResource} from "@/types/resource";
import BaseGrid from "@/Components/BaseGrid.vue";
import {useTaskSpentTimeGrid} from "@/Composables/taskSpentTimeGrid.js";
import {ref} from "vue";

const grid = ref<InstanceType<typeof BaseGrid> | null>(null)
const {gridColumns, deleteTimeRecord, editTimeRecord} = useTaskSpentTimeGrid()

function deleteTimeLogRecordWithHook(id: number) {
  deleteTimeRecord(id, () => {
    grid.value?.updateGrid()
  })
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
                             @click.prevent="router.get(route('taskSpentTime.create'))"
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
              <BaseGrid :columns="gridColumns" :grid-url="route('grid.taskSpentTime')" ref="grid">
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
