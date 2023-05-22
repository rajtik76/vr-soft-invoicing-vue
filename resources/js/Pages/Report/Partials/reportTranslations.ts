export interface ReportTranslations {
    title: string,
    customer: string,
    hours: string,
    date: string,
    task: string,
    note: string,
    total: string,
}

export function getEnglishTranslation(): ReportTranslations {
    return {
        title: 'Monthly overview of the hours worked',
        customer: 'Customer',
        hours: 'Hours',
        date: 'Date',
        task: 'Task',
        note: 'Note',
        total: 'Total',
    }
}

export function getCzechTranslation(): ReportTranslations {
    return {
        title: 'Měsíční přehled odpracovaných hodin',
        customer: 'Zákazník',
        hours: 'Hodiny',
        date: 'Datum',
        task: 'Úkol',
        note: 'Poznámka',
        total: 'Celkem',
    }
}
