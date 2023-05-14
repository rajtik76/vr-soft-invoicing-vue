<script lang="ts" setup>

import {GridColumns} from "@/types/grid"
import {onMounted, ref, toRaw} from "vue";
import {Link, router} from "@inertiajs/vue3";
import {Bars3Icon, BarsArrowDownIcon, BarsArrowUpIcon} from "@heroicons/vue/24/outline";
import {Paginator} from "@/types/paginator";

interface Props {
    columns: GridColumns,
    data: Paginator,
    withActions: boolean
}

const props = withDefaults(defineProps<Props>(), {
    withActions: false
})

const sort = ref<{ [key: string]: string }>({})
const filter = ref<{ [key: string]: string }>({})

onMounted(() => {
    const headersWithDefaultSort = props.columns.filter((header) => header?.default?.sort)
    const sortData: { [key: string]: string } = {}

    headersWithDefaultSort.forEach((header) => {
        sortData[header.name] = header.default?.sortOrder ?? 'asc'
    })

    sort.value = sortData

    // reload page when default sort columns exists
    if (headersWithDefaultSort.length) {
        reloadPage()
    }
})

function reloadPage() {
    let data: { sort?: { [key: string]: string } } = {}
    let sortRawData = toRaw(sort.value)

    if (Object.keys(sortRawData).length) {
        // we have sort values
        data['sort'] = sortRawData
    }

    router.visit(route(<string>route().current()), {
        data: data,
        preserveState: true
    })
}

function toggleSort(column: string, direction: string | null) {
    if (direction === null) {
        delete sort.value[column]
    } else {
        sort.value[column] = direction
    }

    reloadPage()
}
</script>

<template>
    <div class="shadow-sm overflow-hidden my-8">
        <table class="border-collapse table-auto w-full text-sm">
            <thead>
            <tr>
                <th v-for="column in columns" :key="column.name">
                    <span class="flex gap-2">
                        <BarsArrowDownIcon
                            v-if="sort[column.name] === 'desc'"
                            class="h-5 w-5 hover:cursor-pointer"
                            @click="toggleSort(column.name, null)"
                        />
                        <BarsArrowUpIcon
                            v-if="sort[column.name] === 'asc'"
                            class="h-5 w-5 hover:cursor-pointer"
                            @click="toggleSort(column.name, 'desc')"
                        />
                        <Bars3Icon
                            v-if="!sort.hasOwnProperty(column.name) && column.sort"
                            class="h-5 w-5 hover:cursor-pointer"
                            @click="toggleSort(column.name, 'asc')"
                        />
                        {{ column.title }}
                    </span>
                </th>
                <th v-if="withActions">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in data.data" :key="row[0]">
                <td v-for="column in columns" :key="column.name">
                    <slot v-if="$slots[column.name]" :name="column.name" :row="row"/>
                    <span v-else>{{ row[column.name] }}</span>
                </td>

                <td v-if="withActions">
                    <slot :row="row" name="action"/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="flex pt-6 text-sm justify-center">
            <div
                v-for="link in data.meta.links"
                :key="link.label">
                <Link
                    :class="{'bg-gray-200 text-black': link.active, 'bg-gray-900': !link.active}"
                    :disabled="link.url === null"
                    :href="link.url ?? '#'"
                    as="button"
                    class="px-2 py-1 border border-gray-800 disabled:bg-gray-600 disabled:text-slate-400 hover:bg-blue-900"
                    preserve-scroll
                    preserve-state
                    replace
                    v-html="link.label"/>
            </div>
        </div>
    </div>
</template>

<style lang="postcss" scoped>
table > thead > tr > th {
    @apply border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left
}

table > tbody > tr > td {
    @apply border-b border-slate-100 dark:border-slate-700 px-2 py-1 pl-8 text-slate-500 dark:text-slate-400
}

table > tbody > tr {
    @apply hover:bg-slate-700 even:bg-slate-800
}
</style>
