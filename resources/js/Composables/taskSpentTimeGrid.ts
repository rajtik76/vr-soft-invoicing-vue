import {useConfirmDialog} from "@/Composables/confirmDialog";
import {router} from "@inertiajs/vue3";
import {GridColumn} from "@/types/grid";

export function useTaskSpentTimeGrid() {

    const gridColumns: Array<GridColumn> = [{name: 'task', label: 'Task'}, {
        name: 'date', label: 'Date', sortable: true, default: {sort: 'desc'}
    }, {name: 'time', label: 'Hours'}, {name: 'note', label: 'Note'}, {name: 'actions', label: 'Actions'},

    ]

    const deleteTimeRecord = function (id: number, onSuccess: () => void): void {
        if (useConfirmDialog()) {
            router.delete(route('taskSpentTime.destroy', {taskSpentTime: id}), {
                onSuccess: () => onSuccess()
            })
        }
    }

    const editTimeRecord = function (id: number): void {
        router.get(route('taskSpentTime.edit', {taskSpentTime: id}))
    }

    return {gridColumns, deleteTimeRecord, editTimeRecord}
}