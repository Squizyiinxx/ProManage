import { Tasks } from '@/types';
import { Filters } from '.';

export interface TaskForm extends Tasks {
    length: number;
    id: string;
    title: string;
    description?: string;
    created_by: string;
    project_id: string;
    assigned_to: string;
    status: string;
    priority: string;
    due_date: string;
    attachments?: any;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
    errors: Tasks;
    post: (url: string) => void;
}

export interface TaskFilters extends Filters {
    status?: string;
    priority?: string;
    assigned_to?: string;
    project_id?: string;
}
