import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
    role: RoleProps;
    can: any;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}
export interface RoleProps {
    uuid?: string;
    name?: string;
    guard_name?: string;
    permissions?: permissionProps[];
}

export interface permissionProps {
    uuid: number;
    name: string;
}
export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    flash: {
        success?: string;
        error?: string;
        info?: string;
        warning?: string;
    };
}

export interface Task {
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
}
export interface User<T> {
    id: string;
    name: string;
    email: string;
    avatar?: string;
    role: T;
    is_active?: number;
    password?: string;
    password_confirmation?: string;
    preferences?: string | null;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Client {
    id: string;
    name: string;
    email: string;
    phone?: string;
    company?: string;
    projects?: Project[];
    address?: string;
    is_active: boolean;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
}

export type ProjectStatus = 'planned' | 'in_progress' | 'completed';

export interface Project {
    id: string;
    name: string;
    description?: string;
    client: Client;
    tasks?: Tasks[];
    manager: User;
    status: ProjectStatus;
    started_at: string | null;
    deadline: string | null;
    is_active?: boolean;
    attachments?: any;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
}

export type BreadcrumbItemType = BreadcrumbItem;
export type SortOrder = 'asc' | 'desc';

export interface Pagination<T> {
    data: T[];
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

export interface Filters {
    search?: string;
    sortBy?: SortField;
    sortOrder?: SortOrder;
    trashed?: boolean;
}
