<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Filter, Search } from 'lucide-vue-next';
import ExportExcel from '../project/ExportExcel.vue';
import ImportExcel from '../project/ImportExcel.vue';
import { Input } from '../ui/input';

defineProps<{
    search?: string;
    showTrashed?: boolean;
    showFilters: boolean;
    searchActive?: boolean;
    toggleFilters: () => void;
    resetFilters: () => void;
    routeNameImport?: string;
    routeNameExport?: string;
    columnLabels?: [string, string][];
}>();
const page = usePage();

const emit = defineEmits<{
    (e: 'update:search', value: string): void;
    (e: 'update:showTrashed', value: boolean): void;
}>();
</script>

<template>
    <div class="bg-primary-foreground mb-6 rounded-lg shadow-sm">
        <div class="flex flex-col items-start justify-between gap-4 p-4 sm:flex-row sm:items-center">
            <div v-if="searchActive || true" class="bg-accent relative w-full flex-1 rounded-lg shadow-sm sm:max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <Search class="h-5 w-5 text-gray-400" />
                </div>
                <Input
                    :model-value="search"
                    @update:model-value="(val) => emit('update:search', String(val))"
                    type="text"
                    placeholder="Search.."
                    class="block w-full rounded-md py-2 pr-4 pl-10 text-sm"
                />
            </div>

            <div class="flex items-center space-x-2">
                <p class="text-sm text-green-400" v-if="page?.props?.flash?.success">{{ page.props.flash.success }}</p>
                <p class="text-sm text-red-400" v-if="page?.props?.flash?.error">{{ page.props.flash.error }}</p>
                <ImportExcel v-if="routeNameImport" :route-name="routeNameImport" title="Import File Excel" />
                <ExportExcel :column-labels="columnLabels" v-if="routeNameExport" :route-name="routeNameExport" title="Export" />
                <button
                    @click="toggleFilters"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    <Filter class="mr-2 h-4 w-4" />
                    Filters
                </button>
            </div>
        </div>

        <div v-if="showFilters" class="rounded-b-lg border-t border-gray-200 bg-gray-50 p-4">
            <div class="flex flex-wrap items-center gap-4">
                <div v-if="showTrashed !== undefined" class="flex items-center">
                    <input
                        id="showTrashed"
                        type="checkbox"
                        :checked="showTrashed"
                        @change="(e) => emit('update:showTrashed', (e.target as HTMLInputElement).checked)"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    <label for="showTrashed" class="ml-2 text-sm text-gray-700"> Show deleted projects </label>
                </div>
                <slot name="filters" />
                <button @click="resetFilters" class="ml-auto text-sm text-gray-600 hover:text-indigo-600">Reset filters</button>
            </div>
        </div>
    </div>
</template>
