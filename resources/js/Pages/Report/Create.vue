<script lang="ts" setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import {Head, useForm} from '@inertiajs/vue3'
import NumberInput from "@/Components/NumberInput.vue";
import Select from "@/Components/Select.vue";
import Panel from "@/Components/Panel.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps<{
  contracts: Record<number, string>,
}>()

const form = useForm({
  contract_id: null,
  year: new Date().getFullYear(),
  month: new Date().getMonth() + 1,
})

function goBack() {
  window.history.back()
}

</script>

<template>

  <Head title="Create Report"/>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">New Report</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <Panel>
          <section>
            <header>
              <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">New Report</h2>

              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                To create new report please fill next inputs properly.
              </p>
            </header>

            <form class="mt-6 space-y-6"
                  @submit.prevent="form.post(route('report.show'))">
              <div>
                <InputLabel for="contract_id" value="Customer"/>

                <Select
                    id="contract_id"
                    v-model="form.contract_id"
                    :options="contracts"
                    :pick-first-on-null="true"
                    autofocus
                    required
                />

                <InputError :message="form.errors.contract_id" class="mt-2"/>
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

              <div class="flex items-center gap-4 justify-between">
                <PrimaryButton :disabled="form.processing" type="submit">Show</PrimaryButton>
                <PrimaryButton @click.prevent="goBack">Back</PrimaryButton>
              </div>
            </form>
          </section>
        </Panel>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
