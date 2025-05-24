<script setup lang="ts">
import { cn } from '@/lib/utils';
import { ArrowDown, ArrowUp } from 'lucide-vue-next';

defineProps<{
    field: string;
    title: string;
    sortBy?: string;
    sortDirection?: string;
    onClick?: () => void;
    classProps?: string;
}>();
</script>

<template>
    <th
        @click="onClick"
        :class="cn(['px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase transition-all select-none', classProps])"
    >
        <div class="flex items-center gap-1">
            <span>{{ title }}</span>

            <template v-if="sortBy === field">
                <ArrowUp v-if="sortDirection === 'asc'" class="text-primary h-4 w-4" />
                <ArrowDown v-else class="text-primary h-4 w-4" />
            </template>
        </div>
    </th>
</template>
