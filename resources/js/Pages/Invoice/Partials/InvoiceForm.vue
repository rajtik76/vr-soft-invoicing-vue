<script lang="ts" setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import {useForm} from '@inertiajs/vue3'
import NumberInput from "@/Components/NumberInput.vue";
import Select from "@/Components/Select.vue";

const props = defineProps<{
    contracts: Record<number, string>,
}>()

function getIssueDate(): Date {
    const today = new Date()
    today.setDate(today.getDate() + 7)

    return today
}

const form = useForm({
    contract_id: null,
    number: null,
    year: new Date().getFullYear(),
    month: new Date().getMonth(),
    issue_date: new Date().toISOString().split('T')[0],
    due_date: getIssueDate().toISOString().split('T')[0],
})

function goBack() {
    window.history.back()
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">New Invoice</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                To create new invoice please fill next inputs properly.
            </p>
        </header>

        <form class="mt-6 space-y-6"
              @submit.prevent="form.post(route('invoice.store'))">
            <div>
                <InputLabel for="contract_id" value="Customer"/>

                <Select
                    id="contract_id"
                    v-model="form.contract_id"
                    :options="contracts"
                    autofocus
                    required
                />

                <InputError :message="form.errors.contract_id" class="mt-2"/>
            </div>

            <div>
                <InputLabel for="number" value="Number"/>

                <TextInput
                    id="number"
                    v-model="form.number"
                    class="mt-1 block w-full"
                    required
                    type="number"
                />

                <InputError :message="form.errors.number" class="mt-2"/>
            </div>

            <div class="flex gap-4">
                <div>
                    <InputLabel for="year" value="Year"/>

                    <NumberInput
                        id="year"
                        v-model="form.year"
                        class="mt-1 block w-full"
                        required
                        type="number"
                    />

                    <InputError :message="form.errors.year" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="month" value="Month"/>

                    <NumberInput
                        id="month"
                        v-model="form.month"
                        class="mt-1 block w-full"
                        required
                        type="number"
                    />

                    <InputError :message="form.errors.month" class="mt-2"/>
                </div>
            </div>

            <div class="flex gap-4">
                <div>
                    <InputLabel for="issue_date" value="Issue date"/>

                    <TextInput
                        id="issue_date"
                        v-model="form.issue_date"
                        class="mt-1 block w-full"
                        type="date"
                    />

                    <InputError :message="form.errors.issue_date" class="mt-2"/>
                </div>

                <div>
                    <InputLabel for="due_date" value="Due date"/>

                    <TextInput
                        id="due_date"
                        v-model="form.due_date"
                        class="mt-1 block w-full"
                        type="date"
                    />

                    <InputError :message="form.errors.due_date" class="mt-2"/>
                </div>
            </div>

            <div class="flex items-center gap-4 justify-between">
                <PrimaryButton @click.prevent="goBack">Back</PrimaryButton>
                <PrimaryButton :disabled="form.processing" type="submit">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
