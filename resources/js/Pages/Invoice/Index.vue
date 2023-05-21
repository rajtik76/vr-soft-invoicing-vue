<script lang="ts" setup>

import {Head, router} from "@inertiajs/vue3";
import {InvoiceResource} from "@/types/resource";
import Panel from "@/Components/Panel.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import BaseGrid from "@/Components/BaseGrid.vue";
import {GridColumn} from "@/types/grid";
import {useConfirmDialog} from "@/Composables/confirmDialog";
import {ref} from "vue";

function getColumns(): Array<GridColumn> {
    return [
        {name: 'customer', label: 'Customer'},
        {name: 'number', label: 'Invoice Number'},
        {name: 'date', label: 'Date', sortable: true, default: {sort: 'desc'}},
        {name: 'issue_date', label: 'Issue Date'},
        {name: 'due_date', label: 'Due Date'},
        {name: 'total_amount', label: 'Amount'},
        {name: 'currency', label: 'Currency'},
        {name: 'actions', label: 'Actions'},
    ]
}

const grid = ref<InstanceType<typeof BaseGrid> | null>(null)
const {confirmDialog} = useConfirmDialog()

function deleteRecord(id: number): void {
    if (confirmDialog()) {
        router.delete(route('invoice.destroy', {invoice: id}), {
            onSuccess: () => grid.value.updateGrid()
        })
    }
}

function showRecord(id: number): void {
    window.open(route('invoice.show', {invoice: id}), '_newtab')
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
                                           @click.prevent="router.get(route('invoice.create'))">
                                New Invoice
                            </PrimaryButton>
                        </div>
                    </div>
                </Panel>

                <!-- Grid -->
                <Panel class="mt-4">
                    <div class="text-gray-900 dark:text-gray-100">
                        <div class="shadow-sm overflow-hidden">
                            <BaseGrid ref="grid" :columns="getColumns()" :grid-url="route('grid.invoice')">

                                <template #customer="{ row }: { row: InvoiceResource }">
                                    {{ row.contract.customer.name }}
                                </template>

                                <template #date="{ row }: { row: InvoiceResource }">
                                    {{ row.year }}/{{ row.month }}
                                </template>

                                <!-- Actions -->
                                <template #actions="{ row }: { row: InvoiceResource }">
                                    <div class="flex gap-1">
                                        <PrimaryButton
                                            class="hover:!bg-blue-500"
                                            @click="showRecord(row.id)">
                                            SHOW
                                        </PrimaryButton>
                                        <PrimaryButton
                                            class="hover:!bg-red-500" @click="deleteRecord(row.id)">
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

<style lang="postcss" scoped>

</style>
