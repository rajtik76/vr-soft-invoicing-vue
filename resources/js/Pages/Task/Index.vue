<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {PencilSquareIcon} from "@heroicons/vue/24/outline";
import {PaginatorTask} from "@/types/paginator";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps<{
    'paginator': PaginatorTask
}>();

</script>

<template>
    <Head title="Task list"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Task list</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-right">
                            <PrimaryButton @click.prevent="router.get(route('task.create'))">Create New Task</PrimaryButton>
                        </div>
                        <div class="shadow-sm overflow-hidden my-8">
                            <table v-if="paginator.meta.total" class="border-collapse table-auto w-full text-sm">
                                <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Name</th>
                                    <th>Hours</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800">
                                <tr
                                    v-for="task in paginator.data"
                                    :key="task.id"
                                    class="hover:bg-gray-700"
                                >
                                    <td>{{ task.customer.name }}</td>
                                    <td>
                                        <a
                                            v-if="task.url"
                                            class="underline"
                                            :href="task.url"
                                            target="_blank"
                                        >
                                            {{ task.name }}
                                        </a>
                                        <span v-else>
                                        {{ task.name }}
                                    </span>
                                    </td>
                                    <td>{{ task.hours }}</td>
                                    <td>{{ task.created_at }}</td>
                                    <td>
                                        <div class="flex gap-1 my-0.5">
                                            <Link
                                                as="button"
                                                class="bg-gray-600 rounded p-2 hover:bg-blue-600"
                                                :href="route('task.edit', {task: task.id})"
                                            >
                                                <PencilSquareIcon class="w-5 h-5"/>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="flex pt-6 pl-8 text-sm">
                                <div
                                    v-for="link in paginator.meta.links"
                                    :key="link.label">
                                    <Link
                                        :class="{'bg-gray-200 text-black': link.active, 'bg-gray-900': !link.active}"
                                        :disabled="link.url === null"
                                        :href="link.url ?? '#'"
                                        as="button"
                                        class="px-2 py-1 border border-gray-800 disabled:bg-gray-600"
                                        preserve-scroll
                                        replace
                                        v-html="link.label"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="postcss">
table > thead > tr > th {
    @apply border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left
}

table > tbody > tr > td {
    @apply border-b border-slate-100 dark:border-slate-700 p-2 pl-8 text-slate-500 dark:text-slate-400
}
</style>
