export interface PaginatorLink {
    url: string | null,
    label: string,
    active: boolean
}

export interface Paginator {
    data: Record<string, any>,
    links: Array<PaginatorLink>,
    current_page: number,
    from: number,
    last_page: number,
    path: string,
    per_page: number,
    to: number,
    total: number
}

export interface GridColumn {
    name: string,
    label: string,
    searchable?: boolean,
    sortable?: boolean,
    filterable?: boolean,
    filterOptions?: Record<(number | boolean | string), string>
    default?: {
        sort?: 'asc' | 'desc',
        filter?: (number | boolean | string)
    }
}
