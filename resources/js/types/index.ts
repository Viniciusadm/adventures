export type Adventure = {
    id: number;
    title: string;
    description: string;
    slug: string;
}

export type Option = {
    id: number;
    label: string;
    next_content_id: number;
}

export type Content = {
    id: number;
    adventure_id: number;
    next_content_id: number;
    body: string;
    type: 'self' | 'character' | 'narrator';
    options: Option[];
}
