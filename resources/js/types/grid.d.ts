interface GridColumnItem {
    name: string,
    title: string,
    type?: string,
    sort?: boolean,
    default?: {
        sort?: boolean,
        sortOrder?: string,
        filter?: boolean,
    }
}

export interface GridColumns extends Array<GridColumnItem> {
}
