import { Filters } from '.';

export interface PaginationLink {
    url?: string;
    label: string;
    active: boolean;
}

export interface Pagination {
    data: Project[];
    links: PaginationLink[];
    current_page: number;
    from: number;
    last_page: number;
    links: PaginationLink[];
    path: string;
    per_page: number;
    to: number;
    total: number;
}
export interface FiltersProject extends Filters {
    status?: StatusKey;
}

export type SortFieldProject = 'name' | 'created_at' | 'started_at' | 'status';
export type StatusKey = 'pending' | 'planned' | 'in_progress' | 'completed';
export type FilterParams = {
    [key: string]: string | number | boolean | null | undefined;
} & Filters & {
        page?: number;
    };

export interface ProjectForm {
    name: string;
    description: string;
    client_id: string;
    manager_id: string;
    started_at: string;
    deadline: string;
    errors: {
        name?: string;
        description?: string;
        client_id?: string;
        manager_id?: string;
        started_at?: string;
        deadline?: string;
    };
    post: (url: string) => void;
}
