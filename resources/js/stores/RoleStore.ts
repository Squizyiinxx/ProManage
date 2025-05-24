import { useFilterHandler } from '@/composables/useFilterProject';
import { Filters, Pagination, permissionProps, RoleProps, SortOrder } from '@/types';
import { defineStore } from 'pinia';

const doFilter = useFilterHandler('roles');

export const useRoleStore = defineStore('roles', {
    state: () => ({
        roles: null as Pagination<RoleProps[]> | null,
        permissions: null as permissionProps[] | null,
        search: '',
        sortBy: '' as string,
        sortOrder: 'asc' as SortOrder,
        showTrashed: false,
        showFilters: false,
    }),

    actions: {
        setRole(rolePagination: Pagination<RoleProps[]>) {
            this.roles = rolePagination;
        },
        setPermission(permissions: permissionProps[]) {
            this.permissions = permissions;
        },

        setFilters(filters: Filters) {
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
        },

        toggleSort(column: string) {
            if (this.sortBy === column) {
                this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = column;
                this.sortOrder = 'asc';
            }
            this.updateFilters();
        },

        updateFilters() {
            doFilter({
                search: this.search,
                sortBy: this.sortBy,
                sortOrder: this.sortOrder,
                trashed: this.showTrashed,
            });
        },

        toggleFilters() {
            this.showFilters = !this.showFilters;
        },

        resetFilters() {
            this.search = '';
            this.sortBy = 'name';
            this.sortOrder = 'asc';
            this.showTrashed = false;
            this.updateFilters();
        },
    },
});
