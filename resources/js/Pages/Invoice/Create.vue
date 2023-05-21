<script lang="ts" setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import Panel from "@/Components/Panel.vue";
import InvoiceForm from "@/Pages/Invoice/Partials/InvoiceForm.vue";

const props = defineProps<{
    contracts: Record<number, string>
}>()

</script>

<template>
    <Head title="Create Invoice"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Invoice</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <Panel>
                    <InvoiceForm :contracts="contracts" />
                </Panel>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
