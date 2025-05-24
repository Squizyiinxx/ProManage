<script setup lang="ts">
import { useFilterSync } from '@/composables/useFilterProject';
import { columnTask } from '@/constants';
import { useTaskStore } from '@/stores/TasksStore';
import { storeToRefs } from 'pinia';
import TableFilter from '../table/TableFilter.vue';

const store = useTaskStore();
const { search, showTrashed, showFilters, status, priority, assigned_to, project_id } = storeToRefs(store);
useFilterSync([search, status, priority, assigned_to, project_id, showTrashed], store.updateFilters);
</script>

<template>
    <TableFilter
        v-model:search="search"
        v-model:showTrashed="showTrashed"
        :showFilters="showFilters"
        :toggleFilters="store.toggleFilters"
        :resetFilters="store.resetFilters"
        routeNameImport="tasks.import"
        routeNameExport="tasks.export"
        :columnLabels="columnTask"
    >
    </TableFilter>
</template>
