interface PaginatorWithMeta {
    meta: {
        total: number,
        links: [{
            url?: string,
            label: string,
            active: boolean,
        }]
    }
}

export interface PaginatorTask extends PaginatorWithMeta {
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
