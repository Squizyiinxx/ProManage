<script setup lang="ts">
import { useFilterSync } from '@/composables/useFilterProject';
import { columnClient, presets } from '@/constants';
import { useClientStore } from '@/stores/ClientStore';
import { storeToRefs } from 'pinia';
import TableFilter from '../table/TableFilter.vue';

const store = useClientStore();
const { search, showTrashed, showFilters, datePreset } = storeToRefs(store);
useFilterSync([search, showTrashed], store.updateFilters);
</script>

<template>
    <TableFilter
        v-model:search="search"
        v-model:showTrashed="showTrashed"
        :showFilters="showFilters"
        :toggleFilters="store.toggleFilters"
        :resetFilters="store.resetFilters"
        routeNameImport="clients.import"
        routeNameExport="clients.export"
        :columnLabels="columnClient"
    >
        <template #filters>
            <div class="flex flex-wrap gap-2">
                <button
                    v-for="preset in presets"
                    :key="preset.key"
                    @click="
                        () => {
                            store.datePreset = preset.key;
                            store.updateFilters();
                        }
                    "
                    :class="[
                        'cursor-pointer rounded-md px-3 py-1 text-sm transition-colors duration-300',
                        datePreset === preset.key ? 'bg-primary text-white' : 'bg-slate-200 text-gray-700 hover:bg-slate-300',
                    ]"
                >
                    {{ preset.label }}
                </button>
            </div>
        </template>
    </TableFilter>
</template>
