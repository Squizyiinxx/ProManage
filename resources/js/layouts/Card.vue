<script setup lang="ts">
import { cn } from '@/lib/utils';

defineProps<{
    title?: string;
    classProps?: string;
}>();
</script>

<template>
    <section :id="title" :class="cn(['bg-primary-foreground rounded-lg shadow-md', classProps])">
        <div class="flex w-full items-center justify-between border-b border-slate-200 p-3">
            <h2 class="flex items-center px-4 py-2 text-lg font-semibold">
                <slot name="icon" />
                {{ title || 'Project Info' }}
            </h2>
        </div>
        <div class="space-y-4 px-5 pt-5 pb-2">
            <slot name="main" />
        </div>
    </section>
</template>
