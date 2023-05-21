<script lang="ts" setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import {useForm} from '@inertiajs/vue3'
import {TaskSpentTimeResource} from "@/types/resource";
import NumberInput from "@/Components/NumberInput.vue";
import Select from "@/Components/Select.vue";

const props = defineProps<{
  taskSpentTime: TaskSpentTimeResource,
  tasks: Record<string, string>,
}>()

const form = useForm({
  id: props.taskSpentTime.id,
  task_id: props.taskSpentTime?.task_id ?? null,
  date: props.taskSpentTime.date,
  time: props.taskSpentTime.time,
  note: props.taskSpentTime.note,
})

function goBack() {
  window.history.back()
}

</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Time Log</h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Fill time track log record.
      </p>
    </header>

    <form class="mt-6 space-y-6"
          @submit.prevent="taskSpentTime.id ? form.patch(route('taskSpentTime.update', {taskSpentTime: taskSpentTime.id})) : form.post(route('taskSpentTime.store'))">
      <div>
        <InputLabel for="task" value="Task"/>

        <Select
          id="task"
          v-model="form.task_id"
          :options="tasks"
          autofocus
          required
        />
      </div>

      <div>
        <InputLabel for="date" value="Date"/>

        <TextInput
          id="date"
          v-model="form.date"
          class="mt-1 block w-full"
          required
          type="date"
        />

        <InputError :message="form.errors.date" class="mt-2"/>
      </div>

      <div>
        <InputLabel for="time" value="Hours"/>

        <NumberInput
          id="time"
          v-model="form.time"
          class="mt-1 block w-full"
          required
          step="0.1"
          type="number"
        />

        <InputError :message="form.errors.time" class="mt-2"/>
      </div>

      <div>
        <InputLabel for="note" value="Note"/>

        <TextInput
          id="note"
          v-model="form.note"
          class="mt-1 block w-full"
          type="text"
        />

        <InputError :message="form.errors.note" class="mt-2"/>
      </div>

      <div class="flex items-center gap-4 justify-between">
        <PrimaryButton @click.prevent="goBack">Back</PrimaryButton>
        <PrimaryButton :disabled="form.processing" type="submit">Save</PrimaryButton>
      </div>
    </form>
  </section>
</template>
