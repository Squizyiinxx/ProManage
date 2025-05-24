<script setup lang="ts">
import usePermission from '@/composables/usePermission';
import { useTaskStore } from '@/stores/TasksStore';
import { Link } from '@inertiajs/vue3';
import { EyeIcon } from 'lucide-vue-next';
import StatusBadge from '../StatusBadge.vue';
import TableComponent from '../table/TableComponent.vue';
import TdComponent from '../table/TdComponent.vue';
import ThComponent from '../table/ThComponent.vue';
import DestroyTask from './DestroyTask.vue';
import EditTask from './EditTask.vue';

const store = useTaskStore();
const { has } = usePermission();
</script>

<template>
    <TableComponent :datas="store.tasks?.data || []">
        <template #header>
            <ThComponent
                field="title"
                title="Title"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('title')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="created_by" title="Created By" />
            <ThComponent field="project" title="Project" />
            <ThComponent field="status" title="Status" />
            <ThComponent
                field="assigned"
                title="Assigned To"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('assigned_to')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="actions" title="Actions" classProps="text-right" />
        </template>

        <template #row="{ row }">
            <TdComponent :label="row.title" />
            <TdComponent :label="row.creator?.name || '-'" />
            <TdComponent :label="row.project?.name || '-'" />
            <TdComponent>
                <template #label>
                    <StatusBadge :status="row.status" />
                </template>
            </TdComponent>
            <TdComponent :label="row.assigned?.name || '-'" />
            <TdComponent>
                <template #label>
                    <div class="flex h-full gap-2 text-right text-sm whitespace-nowrap">
                        <Link :href="route('tasks.show', row.id)" class="flex cursor-pointer items-center">
                            <EyeIcon class="text-primary-foreground mr-2 h-5 w-5" />
                        </Link>
                        <EditTask v-if="has('task.update')" title="Edit Task" :task="row" />
                        <DestroyTask v-if="has('task.delete')" title="Task" :task="row" />
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
