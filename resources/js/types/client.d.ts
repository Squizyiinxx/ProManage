import { SortField } from '@/types/project';
import { Client } from '.';
export interface FiltersClient {
    search?: string;
    sortBy?: SortField;
    sortOrder?: SortOrder;
    trashed?: boolean;
}

export interface ClientForm extends Client {
    errors: Client;
    post: (url: string) => void;
}
