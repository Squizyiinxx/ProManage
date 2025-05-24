<script setup lang="ts">
import { SlidersHorizontal } from 'lucide-vue-next';

defineProps<{
    datas: any[];
}>();
</script>

<template>
    <div class="bg-sidebar overflow-hidden rounded-lg border border-gray-200 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <slot name="header" />
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">
                    <tr v-if="!datas || !datas.length">
                        <td colspan="100%" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <SlidersHorizontal class="mb-4 h-12 w-12 text-gray-300" />
                                <p class="text-lg font-medium">No projects found</p>
                                <p class="mt-1 text-sm text-gray-500">Create a new project or adjust your filters</p>
                            </div>
                        </td>
                    </tr>

                    <tr v-else v-for="(data, index) in datas" :key="data.id || index" class="transition-colors hover:bg-gray-50">
                        <slot name="row" :row="data" />
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
