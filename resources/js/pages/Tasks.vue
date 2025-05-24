<script setup lang="ts">
import PaginationTable from '@/components/table/PaginationTable.vue';
import CreateTask from '@/components/tasks/CreateTask.vue';
import TaskFilters from '@/components/tasks/TaskFilters.vue';
import TaskTable from '@/components/tasks/TaskTable.vue';
import usePermission from '@/composables/usePermission';
import AppLayout from '@/layouts/AppLayout.vue';
import { useTaskStore } from '@/stores/TasksStore';
import { Filters, Pagination, Project, RoleProps, Task, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, DownloadCloud } from 'lucide-vue-next';
import { onMounted, watch } from 'vue';
interface Props {
    tasks: Pagination<Task[]>;
    file: any;
    tim: User<RoleProps>[];
    projects: Project[];
    filters: Filters;
}
const props = defineProps<Props>();
const store = useTaskStore();
const { has } = usePermission();

onMounted(() => {
    store.setTask(props.tasks);
    store.setTim(props.tim);
    store.setProject(props.projects);
    store.setFilters(props.filters);
});
watch(
    () => props.tasks,
    (newProjects) => {
        store.setTask(newProjects);
    },
    { immediate: true },
);
</script>

<template>
    <Head title="Tasks" />
    <AppLayout>
        <div class="container mx-auto p-4 md:p-8">
            <div class="mb-8 flex flex-col items-center justify-between gap-5 md:flex-row">
                <div class="text-center md:text-left">
                    <h1 class="text-primary text-2xl font-bold">Tasks Management</h1>
                    <p class="text-foreground mt-1 text-sm">Manage and track tasks</p>
                </div>
                <CreateTask v-if="has('task.create')" title="Create Task" />
            </div>
            <div class="my-3 flex items-center justify-end">
                <Link
                    :href="route('tasks.history')"
                    class="text-primary group flex items-center gap-x-2 hover:underline"
                    aria-label="Back to dashboard"
                >
                    View History <ArrowRight class="h-4 w-4 duration-500 ease-in-out group-hover:translate-x-1.5" />
                </Link>
            </div>
            <TaskFilters />
            <TaskTable />
            <div class="my-6 flex items-center justify-between">
                <div class="min-w-0">
                    <PaginationTable :pagination="store.tasks" />
                </div>
                <div class="ml-auto">
                    <a
                        v-if="file"
                        target="_blank"
                        rel="noopener"
                        :href="route('download.export', file.id)"
                        class="bg-primary-foreground text-primary hover:bg-accent flex cursor-pointer items-center rounded-lg px-4 py-2 shadow-lg transition-colors duration-300 ease-in-out"
                    >
                        <DownloadCloud class="mr-2 h-4 w-4" /> Download Export
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
