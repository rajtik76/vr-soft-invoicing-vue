<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {PaginatorTask} from "@/types/paginator";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseGrid from "@/Components/BaseGrid.vue";
import {PencilSquareIcon} from "@heroicons/vue/24/outline";
import Panel from "@/Components/Panel.vue";
import {TaskIndexResource, TaskResource} from "@/types/resource";
import {GridColumn} from "@/types/grid";

const props = defineProps<{
  tasks: PaginatorTask
}>();

const gridColumns: Array<GridColumn> = [
  {name: 'customer', label: 'Customer'},
  {name: 'name', label: 'Name', sortable: true},
  {name: 'hours', label: 'Hours'},
  {name: 'created_at', label: 'Created', sortable: true, default: {sort: 'desc'}},
  {name: 'action', label: 'Action'}
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
        <Panel>
          <div>
            <PrimaryButton class="!bg-green-600 hover:!bg-green-400"
                           @click.prevent="router.get(route('task.create'))"
            >
              Create New Task
            </PrimaryButton>
          </div>
        </Panel>

        <!-- Grid -->
        <Panel class="mt-4">
          <div class="text-gray-900 dark:text-gray-100">
            <div class="shadow-sm overflow-hidden">
              <BaseGrid :columns="gridColumns" :grid-url="route('grid.task')">
                <template #name="{ row }: { row: TaskIndexResource }">
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
                <template #hours="{ row }: { row: TaskIndexResource }">
                  <Link :href="route('task.show', { task: row.id })" v-text="row.hours" class="underline"/>
                </template>
                <template #action="{ row }: { row: TaskIndexResource }">
                  <div class="flex gap-1 my-0.5">
                    <Link
                      :href="route('task.edit', {task: row.id})"
                      as="button"
                      class="bg-gray-600 rounded px-2 py-1 !bg-blue-800 hover:!bg-blue-500"
                    >
                      <PencilSquareIcon class="w-5 h-5 text-white"/>
                    </Link>
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
