<script setup lang="ts">
import CreateProject from '@/components/project/CreateProject.vue';
import ProjectFilters from '@/components/project/ProjectFilters.vue';
import ProjectTable from '@/components/project/ProjectTable.vue';
import PaginationTable from '@/components/table/PaginationTable.vue';
import usePermission from '@/composables/usePermission';
import AppLayout from '@/layouts/AppLayout.vue';
import { useProjectStore } from '@/stores/projectStore';
import { Client, RoleProps, User } from '@/types';
import { FiltersProject, Pagination } from '@/types/project';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, DownloadCloud } from 'lucide-vue-next';
import { onMounted, watch } from 'vue';

interface Props {
    projects: Pagination;
    filters: FiltersProject;
    clients: Client[];
    managers: User<RoleProps>[];
    file: {
        id: string;
    };
}

const props = defineProps<Props>();
const store = useProjectStore();
const { has } = usePermission();

onMounted(() => {
    store.setProjects(props.projects);
    store.setFilters(props.filters);
    store.setClient(props.clients);
    store.setManager(props.managers);
});

watch(
    () => props.projects,
    (newProjects) => {
        store.setProjects(newProjects);
    },
    { immediate: true },
);
</script>

<template>
    <Head title="Projects" />
    <AppLayout>
        <div class="container mx-auto p-4 md:p-8">
            <div class="mb-8 flex flex-col items-center justify-between gap-5 md:flex-row">
                <div class="text-center md:text-left">
                    <h1 class="text-primary text-2xl font-bold">Projects</h1>
                    <p class="text-foreground mt-1 text-sm">Manage and track your ongoing projects</p>
                </div>
                <CreateProject v-if="has('project.create')" title="New Project" />
            </div>
            <div class="my-3 flex items-center justify-end">
                <Link
                    :href="route('projects.history')"
                    class="text-primary group flex items-center gap-x-2 hover:underline"
                    aria-label="Back to dashboard"
                >
                    View History
                    <ArrowRight class="h-4 w-4 duration-500 ease-in-out group-hover:translate-x-1.5" />
                </Link>
            </div>
            <ProjectFilters />
            <ProjectTable :access="has" />
            <div class="my-6 flex items-center justify-between">
                <div class="min-w-0">
                    <PaginationTable :pagination="store.projects" />
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
