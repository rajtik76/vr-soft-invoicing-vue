export interface TaskResource {
    id: number,
    contract_id: number,
    name: string,
    url: string | null,
    note: string | null,
    active: boolean
}

export interface TaskIndexResource {
    id: number,
    name: string,
    url: string | null,
    note: string | null,
    active: boolean,
    hours: number,
    customer: string,
    created_at: string | null,
}

export interface TaskSpentTimeResource {
    id: number,
    task_id: number,
    task: TaskResource,
    date: string,
    time: number,
    note: string | null
}