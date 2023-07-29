export type Adventure = {
    id: number;
    title: string;
    description: string;
    slug: string;
}

export type Option = {
    id: number;
    label: string;
}

export type Content = {
    id: number;
    adventure_id: number;
    next_content_id: number;
    body: string;
    options: Option[];
}
