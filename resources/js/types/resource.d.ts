export interface BankAccountResource {
    id: number,
    bank_name: string,
    bank_code: number,
    number: number,
    iban: string,
    swift: string,
    currency: string,
}

export interface CompanyDetailResource {
    id: number,
    vat_number: string,
    registration_number: string | null,
    mobile: string | null,
    email: string | null,
}

export interface AddressResource {
    id: number,
    street_name: string,
    city: string,
    zip: string,
    country: string,
}

export interface SupplierResource {
    id: number,
    name: string,

    address: AddressResource,
    company: CompanyDetailResource,
}

export interface CustomerResource {
    id: number,
    name: string,

    company: CompanyDetailResource,
    address: AddressResource,
}

export interface ContractResource {
    id: number,
    number: number,
    signed_at: string,
    price_per_unit: number,
    created_at: string,
    updated_at: string,

    customer: CustomerResource,
    supplier: SupplierResource,
    bank: BankAccountResource,
}

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

export interface InvoiceContentResource {
    name: string,
    url: string | null,
    hours: number,
}

export interface InvoiceResource {
    id: number,
    number: number,
    year: number,
    month: number,
    issue_date: string,
    content: Array<InvoiceContentResource>,
    due_date: string,
    price_per_unit: number,
    total_amount: number,
    currency: string,
    currency_symbol: string,
    created_at: string,
    contract: ContractResource,
}

export interface ReportResource {
    date: string,
    time: number,
    note: string | null,

    task: TaskResource,
}
