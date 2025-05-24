<script setup lang="ts">
import { useFilterSync } from '@/composables/useFilterProject';
import { columnProject } from '@/constants';
import { useProjectStore } from '@/stores/projectStore';
import { StatusKey } from '@/types/project';
import { objectEntries } from '@vueuse/core';
import { storeToRefs } from 'pinia';
import TableFilter from '../table/TableFilter.vue';

const store = useProjectStore();
const { search, showTrashed, showFilters, statusLabels, status } = storeToRefs(store);
useFilterSync([search, status, showTrashed], store.updateFilters);
</script>

<template>
    <TableFilter
        v-model:search="search"
        v-model:showTrashed="showTrashed"
        :showFilters="showFilters"
        :toggleFilters="store.toggleFilters"
        :resetFilters="store.resetFilters"
        routeNameImport="projects.import"
        routeNameExport="projects.export"
        :columnLabels="columnProject"
    >
        <template #filters>
            <button
                v-for="[key, label] in objectEntries(statusLabels)"
                :key="key"
                @click="store.setStatusFilter(key as StatusKey)"
                :class="[
                    'cursor-pointer rounded-md px-3 py-1 text-sm transition-colors duration-300',
                    status === key
                        ? 'bg-primary text-sidebar'
                        : 'text-sidebar border-transparent bg-slate-200 hover:bg-indigo-50 hover:text-indigo-600',
                ]"
            >
                {{ label }}
            </button>
        </template>
    </TableFilter>
</template>
