export interface InvoiceShowTranslation {
    panels: {
        supplier: string,
        customer: string,
        payment: string,
        dates: string,
        description: string,
    },

    invoice_title: string,
    mobile: string,
    supplier_is_registered: string,
    registration_number: string,
    vat_number: string,
    vat_reverse_charge_1: string,
    vat_reverse_charge_2: string,

    bank_name: string,
    account_number: string,
    iban: string,
    swift: string,
    reference_id: string,

    issue_date: string,
    due_date: string,

    unit_price: string,
    quantity: string,
    amount: string,
    invoice_based_on_contract_1: string,
    invoice_based_on_contract_2: string,
    subtotal: string,
    total: string,
}

export function getEnglishTranslation(): InvoiceShowTranslation {
    return {
        panels: {
            supplier: 'Supplier',
            customer: 'Customer',
            payment: 'Payment',
            dates: 'Dates',
            description: 'Description',
        },

        invoice_title: 'Invoice #',
        mobile: 'mobile',
        supplier_is_registered: 'The supplier is registered in the Trade Register.',
        registration_number: 'Registration number',
        vat_number: 'VAT number',
        vat_reverse_charge_1: 'VAT is handled in reverse charge mode.',
        vat_reverse_charge_2: 'The amount of VAT is obligated to be added and declared by the customer.',

        bank_name: 'Bank name',
        account_number: 'Account number',
        iban: 'IBAN',
        swift: 'SWIFT',
        reference_id: 'Reference ID',

        issue_date: 'Issue date',
        due_date: 'Due date',

        unit_price: 'Unit price',
        quantity: 'QTY',
        amount: 'Amount',
        invoice_based_on_contract_1: 'On the basis of the contract of work dated',
        invoice_based_on_contract_2: 'I invoice you for the work done on the following tasks. This invoice includes an attachment with a monthly overview of the hours worked',
        subtotal: 'Subtotal',
        total: 'Total',
    }
}

export function getCzechTranslation(): InvoiceShowTranslation {
    return {
        panels: {
            supplier: 'Odběratel',
            customer: 'Dodavatel',
            payment: 'Platba',
            dates: 'Datumy',
            description: 'Popis',
        },

        invoice_title: 'Faktura č.',
        mobile: 'mobil',
        supplier_is_registered: 'Dodavatel je registrován v živnostenském obchodním rejstříku.',
        registration_number: 'IČO',
        vat_number: 'DIČ',
        vat_reverse_charge_1: '',
        vat_reverse_charge_2: '',

        bank_name: 'Banka',
        account_number: 'Číslo účtu',
        iban: 'IBAN',
        swift: 'SWIFT',
        reference_id: 'Variabilní symbol',

        issue_date: 'Datum vystavení',
        due_date: 'Datum plnění',

        unit_price: 'Sazba',
        quantity: 'Hodin',
        amount: 'Částka',
        invoice_based_on_contract_1: 'Na základě rámcové smlouvy o dílo ze dne',
        invoice_based_on_contract_2: 'Vám fakturuji za odvedenou práci na níže uvedených úkolech. Součástí této faktury je příloha s měsíčním přehledem odpracovaných hodin',
        subtotal: 'Mezisoučet',
        total: 'Celkem',
    }
}
