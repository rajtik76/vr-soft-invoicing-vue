<script lang="ts" setup>

import {InvoiceResource} from "@/types/resource";
import InvoiceGridPanel from "@/Pages/Invoice/Partials/InvoiceGridPanel.vue";
import InvoiceGridItem from "@/Pages/Invoice/Partials/InvoiceGridItem.vue";
import InvoiceGridItemLeftAndRight from "@/Pages/Invoice/Partials/InvoiceGridItemLeftAndRight.vue";
import InvoiceGridContent from "@/Pages/Invoice/Partials/InvoiceGridContent.vue";
import {computed, ComputedRef} from "vue";

const props = defineProps<{
    invoice: InvoiceResource
}>()

const nonCzechInvoice: ComputedRef<boolean> = computed(() => props.invoice.currency !== 'CZK')

const texts = computed(() => {
    if (!nonCzechInvoice.value) {
        return {
            panels: {
                supplier: 'Odběratel',
                customer: 'Dodavatel',
                payment: 'Platba',
                dates: 'Datumy',
                description: 'Popis',
            },

            invoice_title: 'Faktura č.',
            mobile: 'mobil',
            supplier_is_registered: 'Dodavatel je registrován v živnostenském obchodním rejstříku.',
            registration_number: 'IČO',
            vat_number: 'DIČ',
            vat_reverse_charge_1: '',
            vat_reverse_charge_2: '',

            bank_name: 'Banka',
            account_number: 'Číslo účtu',
            iban: 'IBAN',
            swift: 'SWIFT',
            reference_id: 'Variabilní symbol',

            issue_date: 'Datum vystavení',
            due_date: 'Datum plnění',

            unit_price: 'Sazba',
            quantity: 'Hodin',
            amount: 'Částka',
            invoice_based_on_contract_1: 'Na základě smlouvy ze dne',
            invoice_based_on_contract_2: 'Vám fakturuji za odvedenou práci na níže uvedených úkolech',
            subtotal: 'Mezisoučet',
            total: 'Celkem',
        }
    }

    return {
        panels: {
            supplier: 'Supplier',
            customer: 'Customer',
            payment: 'Payment',
            dates: 'Dates',
            description: 'Description',
        },

        invoice_title: 'Invoice #',
        mobile: 'mobile',
        supplier_is_registered: 'The supplier is registered in the Trade Register.',
        registration_number: 'Registration number',
        vat_number: 'VAT number',
        vat_reverse_charge_1: 'VAT is handled in reverse charge mode.',
        vat_reverse_charge_2: 'The amount of VAT is obligated to be added and declared by the customer.',

        bank_name: 'Bank name',
        account_number: 'Account number',
        iban: 'IBAN',
        swift: 'SWIFT',
        reference_id: 'Reference ID',

        issue_date: 'Issue date',
        due_date: 'Due date',

        unit_price: 'Unit price',
        quantity: 'QTY',
        amount: 'Amount',
        invoice_based_on_contract_1: 'On the basis of the contract of work dated',
        invoice_based_on_contract_2: 'I hereby invoice you the work done on the following tasks',
        subtotal: 'Subtotal',
        total: 'Total',
    }
})

</script>

<template>
    <div class="grid grid-cols-2 gap-4 p-4">

        <!-- Invoice number -->
        <div class="col-span-2 uppercase font-bold text-6xl">{{ texts.invoice_title }} {{ invoice.number }}</div>

        <!-- Supplier -->
        <InvoiceGridPanel :background="'bg-blue-200'" class="border-blue-200">

            <template #title>{{ texts.panels.supplier }}</template>

            <div class="grid grid-flow-row-dense auto-rows-max">
                <InvoiceGridItem class="text-xl font-bold">{{ invoice.contract.supplier.name }}</InvoiceGridItem>
                <InvoiceGridItem>{{ invoice.contract.supplier.address.street_name }}</InvoiceGridItem>
                <InvoiceGridItem>{{ invoice.contract.supplier.address.zip }} {{
                        invoice.contract.supplier.address.city
                    }}
                </InvoiceGridItem>
                <InvoiceGridItem>{{ invoice.contract.supplier.address.country }}</InvoiceGridItem>
                <InvoiceGridItem
                    v-if="invoice.contract.supplier.company.mobile && invoice.contract.supplier.company.email"
                    class="text-xs italic">{{ texts.mobile }}: {{ invoice.contract.supplier.company.mobile }}, email:
                    {{ invoice.contract.supplier.company.email }}
                </InvoiceGridItem>
                <InvoiceGridItem v-else class="text-xs italic">&nbsp;</InvoiceGridItem>
                <InvoiceGridItem>&nbsp;</InvoiceGridItem>
                <InvoiceGridItem class="text-blue-500 text-sm">{{ texts.supplier_is_registered }}
                </InvoiceGridItem>
                <InvoiceGridItem class="text-blue-500 text-sm">&nbsp;</InvoiceGridItem>
                <InvoiceGridItem>&nbsp;</InvoiceGridItem>
                <InvoiceGridItem>
                    {{ texts.registration_number }}: {{ invoice.contract.supplier.company.registration_number }}
                </InvoiceGridItem>
                <InvoiceGridItem
                    v-if="nonCzechInvoice"
                    class="font-bold">
                    {{ texts.vat_number }}: {{ invoice.contract.supplier.company.vat_number }}
                </InvoiceGridItem>
            </div>
        </InvoiceGridPanel>

        <!-- Customer -->
        <InvoiceGridPanel :background="'bg-green-200'" class="border-green-200">

            <template #title>{{ texts.panels.customer }}</template>

            <div class="grid grid-flow-row-dense auto-rows-max">
                <InvoiceGridItem class="text-xl font-bold">{{ invoice.contract.customer.name }}</InvoiceGridItem>
                <InvoiceGridItem>{{ invoice.contract.customer.address.street_name }}</InvoiceGridItem>
                <InvoiceGridItem>
                    {{ invoice.contract.customer.address.zip }} {{ invoice.contract.customer.address.city }}
                </InvoiceGridItem>
                <InvoiceGridItem>{{ invoice.contract.customer.address.country }}</InvoiceGridItem>
                <InvoiceGridItem
                    v-if="invoice.contract.customer.company.mobile && invoice.contract.supplier.company.email"
                    class="text-xs italic">
                    {{ texts.mobile }}: {{ invoice.contract.customer.company.mobile }},
                    email: {{ invoice.contract.customer.company.email }}
                </InvoiceGridItem>
                <InvoiceGridItem v-else class="text-xs italic">&nbsp;</InvoiceGridItem>
                <InvoiceGridItem>&nbsp;</InvoiceGridItem>

                <div v-if="nonCzechInvoice">
                    <InvoiceGridItem class="text-blue-500 text-sm"> {{ texts.vat_reverse_charge_1 }}</InvoiceGridItem>
                    <InvoiceGridItem class="text-blue-500 text-sm"> {{ texts.vat_reverse_charge_2 }}</InvoiceGridItem>
                </div>

                <div v-else>
                    <InvoiceGridItem>&nbsp;</InvoiceGridItem>
                    <InvoiceGridItem>&nbsp;</InvoiceGridItem>
                </div>

                <InvoiceGridItem>&nbsp;</InvoiceGridItem>

                <InvoiceGridItem v-if="invoice.contract.customer.company.registration_number">
                    {{ texts.registration_number }}: {{ invoice.contract.customer.company.registration_number }}
                </InvoiceGridItem>
                <InvoiceGridItem v-else>&nbsp;</InvoiceGridItem>
                <InvoiceGridItem
                    v-if="nonCzechInvoice"
                    class="font-bold">
                    {{ texts.vat_number }}: {{ invoice.contract.customer.company.vat_number }}
                </InvoiceGridItem>
            </div>
        </InvoiceGridPanel>

        <!-- Payment -->
        <InvoiceGridPanel :background="'bg-orange-200'" class="border-orange-200">

            <template #title>{{ texts.panels.payment }}</template>

            <!-- bank name -->
            <InvoiceGridItemLeftAndRight>
                <template #left><span>{{ texts.bank_name }}:</span></template>
                <template #right><span>{{ invoice.contract.bank.bank_name }}</span></template>
            </InvoiceGridItemLeftAndRight>

            <!-- account number -->
            <InvoiceGridItemLeftAndRight>
                <template #left><span>{{ texts.account_number }}:</span></template>
                <template #right><span>{{ invoice.contract.bank.number }} / {{ invoice.contract.bank.bank_code }}</span>
                </template>
            </InvoiceGridItemLeftAndRight>

            <!-- iban -->
            <InvoiceGridItemLeftAndRight v-if="nonCzechInvoice">
                <template #left><span>{{ texts.iban }}:</span></template>
                <template #right><span>{{ invoice.contract.bank.iban }}</span></template>
            </InvoiceGridItemLeftAndRight>

            <!-- swift -->
            <InvoiceGridItemLeftAndRight v-if="nonCzechInvoice">
                <template #left><span>{{ texts.swift }}:</span></template>
                <template #right><span>{{ invoice.contract.bank.swift }}</span></template>
            </InvoiceGridItemLeftAndRight>

            <!-- reference id -->
            <InvoiceGridItemLeftAndRight>
                <template #left><span>{{ texts.reference_id }}:</span></template>
                <template #right><span>{{ invoice.number }}</span></template>
            </InvoiceGridItemLeftAndRight>

        </InvoiceGridPanel>

        <!-- Dates -->
        <InvoiceGridPanel :background="'bg-orange-200'" class="border-orange-200">

            <template #title>{{ texts.panels.dates }}</template>

            <!-- issue date -->
            <InvoiceGridItemLeftAndRight>
                <template #left><span>{{ texts.issue_date }}:</span></template>
                <template #right><span>{{ invoice.issue_date }}</span></template>
            </InvoiceGridItemLeftAndRight>

            <!-- due date -->
            <InvoiceGridItemLeftAndRight class="row-span-6">
                <template #left><span>{{ texts.due_date }}:</span></template>
                <template #right><span>{{ invoice.due_date }}</span></template>
            </InvoiceGridItemLeftAndRight>

        </InvoiceGridPanel>

        <!-- Content -->
        <InvoiceGridPanel :background="'bg-gray-200'" class="col-span-2 border-gray-200">

            <template #title>
                <div class="grid grid-cols-12">
                    <div class="col-span-9">{{ texts.panels.description }}</div>
                    <div class="px-1 border-x border-gray-300 text-center">{{ texts.unit_price }}</div>
                    <div class="px-1 border-r border-gray-300 text-center">{{ texts.quantity }}</div>
                    <div class="text-right">{{ texts.amount }}</div>
                </div>
            </template>

            <!-- contract statement -->
            <InvoiceGridContent>
                <template #item>
                    {{ texts.invoice_based_on_contract_1 }}: {{ invoice.contract.signed_at }},
                    {{ texts.invoice_based_on_contract_2 }}:
                </template>
            </InvoiceGridContent>

            <InvoiceGridContent class="bg-gray-50">
                <template #item>&nbsp;</template>
            </InvoiceGridContent>

            <InvoiceGridContent
                v-for="invoiceContent in invoice.content" :key="invoiceContent.name"
                class="odd:bg-gray-50">
                <template #item>
                    <a v-if="invoiceContent.url" :href="invoiceContent.url"
                       class="underline text-blue-500">{{ invoiceContent.name }}</a>
                    <span v-else>{{ invoiceContent.name }}</span>
                </template>
                <template #price>
                    {{ invoice.price_per_unit.toLocaleString() }} {{ invoice.currency_symbol }}
                </template>
                <template #quantity>{{ invoiceContent.hours.toFixed(1) }}</template>
                <template #subTotal>
                    {{ (invoiceContent.hours * invoice.price_per_unit).toLocaleString() }}
                    {{ invoice.currency_symbol }}
                </template>
            </InvoiceGridContent>

            <!-- Subtotal -->
            <template #footer>
                <div class="grid grid-cols-12">
                    <div class="col-span-10">{{ texts.subtotal }}</div>
                    <div class="border-x border-gray-300 px-1 text-center">{{
                            invoice.content.reduce((accumulator, currentValue) => accumulator + currentValue.hours, 0).toFixed(1)
                        }}
                    </div>
                    <div class="text-right">
                        {{ invoice.total_amount.toLocaleString() }} {{ invoice.currency_symbol }}
                    </div>
                </div>
            </template>
        </InvoiceGridPanel>

        <!-- Total -->
        <div class="grid grid-cols-12 col-span-2 pt-8">
            <div
                class="uppercase font-bold text-5xl col-end-13 col-span-5 border-4 border-gray-500 rounded-xl p-4 text-right bg-gray-200">
                {{ texts.total }}: {{ invoice.total_amount.toLocaleString() }} {{ invoice.currency_symbol }}
            </div>
        </div>
    </div>
</template>

<style lang="postcss" scoped>

</style>
