<script lang="ts" setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import {router, useForm} from '@inertiajs/vue3'
import {Task} from "@/types/task"
import Checkbox from "@/Components/Checkbox.vue";
import Select from "@/Components/Select.vue";

const props = defineProps<{
    task: Task,
    contracts: Array<Record<string, string>>
}>()

const form = useForm({
    contract_id: props.task.contract_id,
    name: props.task.name,
    url: props.task.url,
    note: props.task.note,
    active: props.task.active,
})

function goBack() {
    router.get(route('task.index'))
}

function sendData() {
    if (props.task.id) {
        // if task have ID = edit task
        form.patch(route('task.update', {task: props.task.id}))
    } else {
        // if task haven't ID = create task
        form.post(route('task.store'))
    }
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Task Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your task information.
            </p>
        </header>

        <form class="mt-6 space-y-6" @submit.prevent="sendData">
            <div>
                <InputLabel for="contract" value="Contract - Customer"/>

                <Select
                    id="contract"
                    v-model="form.contract_id"
                    :options="contracts"
                    autofocus
                    class="mt-1 block w-full"
                    required
                />

                <InputError :message="form.errors.url" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    v-model="form.name"
                    autocomplete="name"
                    class="mt-1 block w-full"
                    required
                    type="text"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="url" value="URL"/>

                <TextInput
                    id="url"
                    v-model="form.url"
                    class="mt-1 block w-full"
                    type="text"
                />

                <InputError :message="form.errors.url" class="mt-2"/>
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


            <div>
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.active" name="active"/>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Active task</span>
                </label>
                <InputError :message="form.errors.active" class="mt-2"/>
            </div>


            <div class="flex items-center gap-4 justify-between">
                <PrimaryButton @click.prevent="goBack">Back</PrimaryButton>
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
