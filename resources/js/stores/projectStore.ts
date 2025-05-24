import { useFilterHandler } from '@/composables/useFilterProject';
import { Client, RoleProps, SortOrder, User } from '@/types';
import { FiltersClient } from '@/types/client';
import { Pagination, SortFieldProject, StatusKey } from '@/types/project';
import { defineStore } from 'pinia';

const doFilter = useFilterHandler('projects');

export const useProjectStore = defineStore('projects', {
    state: () => ({
        projects: null as Pagination | null,
        manager: null as User<RoleProps>[] | null,
        client: null as Client[] | null,
        search: '',
        status: '' as StatusKey | '',
        sortBy: 'name' as SortFieldProject,
        sortOrder: 'asc' as SortOrder,
        showTrashed: false,
        showFilters: false,
        statusClasses: {
            planned: 'bg-yellow-100 text-yellow-800 border-yellow-200',
            pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
            in_progress: 'bg-blue-100 text-blue-800 border-blue-200',
            completed: 'bg-green-100 text-green-800 border-green-200',
        },
        statusLabels: {
            planned: 'Planned',
            pending: 'Pending',
            in_progress: 'In Progress',
            completed: 'Completed',
        },
    }),

    getters: {
        getStatusClass:
            (state) =>
            (status: StatusKey): string =>
                state.statusClasses[status] || 'bg-gray-100 text-gray-800 border-gray-200',

        getStatusLabel:
            (state) =>
            (status: StatusKey): string =>
                state.statusLabels[status] || status,
    },

    actions: {
        setProjects(projectsPagination: Pagination) {
            this.projects = projectsPagination;
        },
        setManager(manager: User<RoleProps>[]) {
            this.manager = manager;
        },
        setClient(client: Client[]) {
            this.client = client;
        },
        setFilters(filters: FiltersClient) {
            this.search = filters.search || '';
            this.sortBy = filters.sortBy || 'name';
            this.sortOrder = filters.sortOrder || 'asc';
            this.showTrashed = String(filters.trashed) === '1' || filters.trashed === true;
            if (this.sortBy && !['name', 'created_at', 'status'].includes(this.sortBy)) {
                this.sortBy = 'name';
            }

            if (this.sortOrder && !['asc', 'desc'].includes(this.sortOrder)) {
                this.sortOrder = 'asc';
            }

            if (this.status && !['pending', 'planned', 'in_progress', 'completed'].includes(this.status)) {
                this.status = '';
            }
        },

        toggleSort(column: SortFieldProject) {
            if (this.sortBy === column) {
                this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = column;
                this.sortOrder = 'asc';
            }
            this.updateFilters();
        },

        setStatusFilter(key: StatusKey | '') {
            if (this.status === key) {
                this.status = '';
            } else {
                this.status = key;
            }
            this.updateFilters();
        },

        updateFilters() {
            doFilter({
                search: this.search,
                sortBy: this.sortBy,
                sortOrder: this.sortOrder,
                status: this.status || undefined,
                trashed: this.showTrashed,
            });
        },

        toggleFilters() {
            this.showFilters = !this.showFilters;
        },

        resetFilters() {
            this.search = '';
            this.status = '';
            this.sortBy = 'name';
            this.sortOrder = 'asc';
            this.showTrashed = false;
            this.updateFilters();
        },
    },
});
