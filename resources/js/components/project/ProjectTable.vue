<script setup lang="ts">
import { useProjectStore } from '@/stores/projectStore';
import { Link } from '@inertiajs/vue3';
import { EyeIcon } from 'lucide-vue-next';
import StatusBadge from '../StatusBadge.vue';
import TableComponent from '../table/TableComponent.vue';
import TdComponent from '../table/TdComponent.vue';
import ThComponent from '../table/ThComponent.vue';
import DestroyProject from './DestroyProject.vue';
import EditProject from './EditProject.vue';

const store = useProjectStore();
defineProps<{
    access?: any;
}>();
</script>

<template>
    <TableComponent :datas="store.projects?.data || []">
        <template #header>
            <ThComponent
                field="name"
                title="Project Name"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('name')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="description" title="Description" />
            <ThComponent field="client" title="Client" />
            <ThComponent field="manager" title="Manager" />
            <ThComponent
                field="status"
                title="Status"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('status')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="actions" title="Actions" classProps="text-right" />
        </template>

        <template #row="{ row }">
            <TdComponent :label="row.name" />
            <TdComponent :label="row.description" class-props="line-clamp-2" />
            <TdComponent :label="row.client?.name || '-'" />
            <TdComponent :label="row.manager?.name || '-'" />
            <TdComponent>
                <template #label>
                    <StatusBadge :status="row.status" />
                </template>
            </TdComponent>
            <TdComponent>
                <template #label>
                    <div class="flex h-full gap-2 text-right text-sm whitespace-nowrap">
                        <Link :href="route('projects.show', row.id)" class="flex cursor-pointer items-center">
                            <EyeIcon class="text-primary-foreground mr-2 h-5 w-5" />
                        </Link>
                        <EditProject v-if="access('project.update')" title="Edit Project" :project="row" />
                        <DestroyProject v-if="access('project.delete')" title="Project" :project="row" />
                    </div>
                </template>
            </TdComponent>
        </template>
    </TableComponent>
</template>

<style lang="css" scoped>
.line-clamp-2 {
    display: -webkit-box;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
