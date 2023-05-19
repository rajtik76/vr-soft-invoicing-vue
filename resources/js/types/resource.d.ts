export interface TaskResource {
    id: number,
    contract_id: number,
    name: string,
    url: string | null,
    note: string | null,
    active: boolean
}
