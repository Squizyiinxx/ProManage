import { useFilterHandler } from '@/composables/useFilterProject';
import { Pagination, Project, RoleProps, Tasks, User } from '@/types';
import { TaskFilters } from '@/types/task';
import { defineStore } from 'pinia';

const doFilter = useFilterHandler('tasks');

export const useTaskStore = defineStore('tasks', {
    state: () => ({
        tasks: null as Pagination<Tasks[]> | null,
        tim: null as User<RoleProps>[] | null,
        projects: null as Project[] | null,

        search: '',
        sortBy: 'created_at' as string,
        sortOrder: 'desc' as any,
        showTrashed: false,

        status: '' as string,
        priority: '' as string,
        assigned_to: '' as string,
        project_id: '' as string,

        showFilters: false,
    }),

    actions: {
        setTask(TaskPagination: Pagination<Tasks[]>) {
            this.tasks = TaskPagination;
        },
        setTim(tim: User<RoleProps>[]) {
            this.tim = tim;
        },
        setProject(project: Project[]) {
            this.projects = project;
        },

        setFilters(filters: TaskFilters) {
            this.search = filters.search || '';
            this.sortBy = ['title', 'created_at', 'due_date'].includes(filters.sortBy ?? '') ? filters.sortBy : 'created_at';
            this.sortOrder = ['asc', 'desc'].includes(filters.sortOrder ?? '') ? filters.sortOrder : 'desc';
            this.showTrashed = String(filters.trashed) === '1' || filters.trashed === true;

            this.status = filters.status || '';
            this.priority = filters.priority || '';
            this.assigned_to = filters.assigned_to || '';
            this.project_id = filters.project_id || '';
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
                status: this.status,
                priority: this.priority,
                assigned_to: this.assigned_to,
                project_id: this.project_id,
            });
        },

        toggleFilters() {
            this.showFilters = !this.showFilters;
        },

        resetFilters() {
            this.search = '';
            this.sortBy = 'created_at';
            this.sortOrder = 'desc';
            this.showTrashed = false;

            this.status = '';
            this.priority = '';
            this.assigned_to = '';
            this.project_id = '';

            this.updateFilters();
        },
    },
});
