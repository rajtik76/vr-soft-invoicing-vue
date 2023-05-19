<script lang="ts" setup>

import {customRef, onMounted, ref, watch} from "vue";
import axios from "axios";
import {GridColumn, Paginator} from "@/types/grid";
import {Bars3Icon, BarsArrowDownIcon, BarsArrowUpIcon} from "@heroicons/vue/24/outline";
import BaseSelect from "@/Components/Select.vue";
import BaseInput from "@/Components/TextInput.vue";

export interface PostData {
    sort: Record<string, 'asc' | 'desc'> | {},
    search: string,
    page: string,
    perPage: string
}

export interface Props {
    gridUrl: string,
    columns: Array<GridColumn>,
    updateOnStart?: boolean
}

type SortArray = [string, 'asc' | 'desc'][]

const perPageOptions: Array<Record<string, any>> = [
    {key: '10', value: '10'},
    {key: '20', value: '20'},
    {key: '50', value: '50'},
]

const props = withDefaults(defineProps<Props>(), {
    updateOnStart: true,
})

defineExpose({updateGrid})

const page = ref<string>('1')
const sort = ref<SortArray>([])
const search = useDebouncedRef('', 500)
const paginator = ref<Paginator | null>(null)
const process = ref(false)
const processTimerExpired = useDebouncedRef(false, 50)
const perPage = ref<string>('10')

function useDebouncedRef(value: any, delay: number = 200) {
    let timeout: number
    return customRef((track, trigger) => {
        return {
            get() {
                track()
                return value
            },
            set(newValue) {
                clearTimeout(timeout)
                timeout = setTimeout(() => {
                    value = newValue
                    trigger()
                }, delay)
            }
        }
    })
}

function updateGrid() {
    process.value = true
    processTimerExpired.value = true

    axios.post(props.gridUrl, getPostData())
        .then((response) => {
            paginator.value = response.data
        })
        .catch((error) => {
            console.log(error.response.data)
        })
        .finally(() => {
            process.value = false
            processTimerExpired.value = false
        })
}

function getPostData(): PostData {
    return {
        sort: Object.fromEntries(sort.value),
        search: search.value,
        page: page.value,
        perPage: perPage.value
    }
}

function getDefaultSortData(): SortArray {
    let sortData: SortArray = []
    const defaultSort = props.columns.filter((column) => column.default?.sort)

    if (defaultSort.length) {
        // default sort found = get sorted data by default sort
        defaultSort.forEach((column) => {
            const order = column.default?.sort === 'asc' ? 'asc' : 'desc'
            sortData.push([column.name, order])
        })

        return sortData
    }

    return []
}

function getColumnSortOrder(column: string): 'asc' | 'desc' | null {
    let output: 'asc' | 'desc' | null = null

    sort.value.forEach((item) => {
        let columnName: string, columnOrder: 'asc' | 'desc'
        [columnName, columnOrder] = item

        if (columnName === column) {
            output = columnOrder
        }
    })

    return output
}

function changeSort(column: string, order: 'asc' | 'desc' | null) {
    if (order === null) {
        // filter out the columns with null order
        sort.value = sort.value.filter((item) => {
            if (item[0] === column) {
                return false
            }

            return true
        })
    } else {
        // get column index from sort array
        const columnIndex = sort.value.map(item => item[0]).indexOf(column)

        if (columnIndex === -1) {
            // column not exist in array = push
            sort.value.push([column, order])
        } else {
            // column exist = change sort order
            sort.value[columnIndex] = [column, order]
        }
    }

    updateGrid()
}

function changePage(url: string | null) {
    if (url === null) {
        return
    }

    const urlInstance = new URL(url)
    const searchParams = urlInstance.searchParams

    page.value = searchParams.get('page') ?? '1'

    updateGrid()
}

watch([perPage, search], (value) => {
    page.value = '1'
    updateGrid()
})

onMounted(() => {
    // get default sort
    sort.value = getDefaultSortData()

    // update grid on mounted
    if (props.updateOnStart) {
        updateGrid()
    }
})

</script>

<template>
    <div v-if="paginator">
        <div v-if="columns.filter((column) => column.searchable).length"
             class="flex justify-between text-sm pb-8 text-slate-500">
            <!-- Search -->
            <div v-if="columns.filter((column) => column.searchable).length"
                 class="flex items-center gap-2 justify-end flex-grow">
                Search
                <BaseInput v-model="search" class="border p-1.5 text-sm" type="text"/>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <!-- Loading spinner -->
            <div v-if="process && processTimerExpired"
                 class="absolute top-0 right-0 bottom-o left-0 w-full h-full bg-slate-100 opacity-75">
                <div class="grid h-full place-items-center">
                    <div class="flex items-center">
                        <svg aria-hidden="true"
                             class="inline w-8 h-8 mr-2 text-gray-200 animate-spin fill-gray-600"
                             fill="none" viewBox="0 0 100 101" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"/>
                        </svg>
                        <span class="ml-2">Loading...</span>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table class="w-full text-sm text-left text-gray-200">
                <thead class="text-base text-gray-200 bg-gray-700 border-b border-gray-600">
                <tr>
                    <th v-for="column in columns" :key="column.name" class="px-6 py-4" scope="col">
                        <span class="flex items-center gap-2">
                            <span>
                                <BarsArrowUpIcon v-if="getColumnSortOrder(column.name) === 'asc'"
                                                 class="sort-icon"
                                                 @click="changeSort(column.name, 'desc')"/>
                                <BarsArrowDownIcon v-else-if="getColumnSortOrder(column.name) === 'desc'"
                                                   class="sort-icon"
                                                   @click="changeSort(column.name, null)"/>
                                <Bars3Icon v-else-if="column.sortable && getColumnSortOrder(column.name) === null"
                                           class="sort-icon"
                                           @click="changeSort(column.name, 'asc')"/>
                            </span>
                            {{ column.label }}
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in paginator.data" :key="row[0]"
                    class="bg-gray-800 border-b border-gray-700 hover:!bg-gray-900 text-slate-400">
                    <td v-for="column in columns" :key="column.name" class="px-6 py-2">
                        <slot :name="column.name" :row="row">
                            {{ row[column.name] }}
                        </slot>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Table footer -->
        <div class="flex pt-6 px-6 justify-between items-center text-xs">
            <!-- page information -->
            <div class="font-normal text-gray-500">
                <span>
                    Showing <span class="text-gray-300">{{ String(paginator.from ?? '0') }}</span> of <span
                    class="text-gray-300">{{ String(paginator.to ?? '0') }}</span> from <span
                    class="text-gray-300">{{ String(paginator.total ?? '0') }}</span> total
                </span>
            </div>

            <!-- Per page select -->
            <div class="flex items-center gap-2 text-gray-500">
                <p class="">Per page</p>
                <BaseSelect
                    v-model="perPage"
                    :options="perPageOptions"
                    class="text-xs"
                />
            </div>

            <!-- Paginator -->
            <div class="flex items-center border border-gray-600 rounded text-gray-400 text-sm">
                <button v-for="link in paginator.links" :key="link.label"
                        :class="{'bg-gray-400 text-gray-800': link.active}"
                        :disabled="link.url === null"
                        class="px-2 py-1 disabled:text-gray-600 border-gray-600 [&:not(:last-child)]:border-r"
                        @click="changePage(link.url)"
                        v-html="link.label"/>
            </div>
        </div>
    </div>

    <!-- Loading skeleton -->
    <div v-else-if="process">
        <div class="p-4 space-y-4 border border-gray-200 divide-y divide-gray-200 rounded shadow animate-pulse md:p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
            </div>
            <div class="flex items-center justify-between pt-4">
                <div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-24 mb-2.5"></div>
                    <div class="w-32 h-2 bg-gray-200 rounded-full"></div>
                </div>
                <div class="h-2.5 bg-gray-300 rounded-full w-12"></div>
            </div>
        </div>
    </div>
</template>

<style lang="postcss" scoped>
.sort-icon {
    @apply h-5 w-5 hover:cursor-pointer mt-0.5
}
</style>
