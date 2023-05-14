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
