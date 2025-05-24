import { useFilterHandler } from '@/composables/useFilterProject';
import { Client, Pagination, SortOrder } from '@/types';
import { FiltersClient } from '@/types/client';
import { defineStore } from 'pinia';

const doFilter = useFilterHandler('clients');

export const useClientStore = defineStore('clients', {
    state: () => ({
        clients: null as Pagination<Client[]> | null,
        search: '',
        sortBy: '' as string,
        sortOrder: 'asc' as SortOrder,
        showTrashed: false,
        showFilters: false,
        datePreset: '' as string,
    }),
    actions: {
        setClient(clientPagination: Pagination<Client[]>) {
            this.clients = clientPagination;
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
                datePreset: this.datePreset || undefined,
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
            this.datePreset = '';
            this.updateFilters();
        },
    },
});
