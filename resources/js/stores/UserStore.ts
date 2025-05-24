import { useFilterHandler } from '@/composables/useFilterProject';
import { Filters, Pagination, RoleProps, SortOrder, User } from '@/types';
import { defineStore } from 'pinia';

const doFilter = useFilterHandler('users');

export const useUserStore = defineStore('users', {
    state: () => ({
        users: null as Pagination<User<RoleProps>[]> | null,
        role: null as RoleProps[] | null,
        search: '',
        sortBy: '' as string,
        sortOrder: 'asc' as SortOrder,
        showTrashed: false,
        showFilters: false,
    }),

    actions: {
        setUser(userPagination: Pagination<User<RoleProps>[]>) {
            this.users = userPagination;
        },
        setRole(clientPagination: RoleProps[]) {
            this.role = clientPagination;
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
