import {TaskResource} from "@/types/resource";

export interface Paginator {
    data: any,
    meta: {
        total: number,
        links: [{
            url?: string,
            label: string,
            active: boolean,
        }]
    }
}

export interface PaginatorTask extends Paginator {
    data: [{
        id: number,
        url?: string,
        name: string,
        hours: number,
        customer: {
            name: string,
        },
        created_at: string,
    }]
}

export interface PaginatorTaskSpentTime extends Paginator {
    data: [
        {
            id: number,
            task_id: number,
            task: TaskResource,
            date: string,
            time: number,
            note: string | null
        }
    ]
}
