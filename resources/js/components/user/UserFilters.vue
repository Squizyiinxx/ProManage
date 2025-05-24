<script setup lang="ts">
import { useFilterSync } from '@/composables/useFilterProject';
import { columnUser } from '@/constants';
import { useUserStore } from '@/stores/UserStore';
import { storeToRefs } from 'pinia';
import TableFilter from '../table/TableFilter.vue';

const store = useUserStore();
const { search, showTrashed, showFilters } = storeToRefs(store);
useFilterSync([search, showTrashed], store.updateFilters);
</script>

<template>
    <TableFilter
        v-model:search="search"
        v-model:showTrashed="showTrashed"
        :showFilters="showFilters"
        :toggleFilters="store.toggleFilters"
        :resetFilters="store.resetFilters"
        routeNameImport="users.import"
        routeNameExport="users.export"
        :columnLabels="columnUser"
    >
    </TableFilter>
</template>
