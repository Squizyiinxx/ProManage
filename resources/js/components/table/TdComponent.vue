<script setup lang="ts">
import { cn } from '@/lib/utils';

defineProps<{
    label?: string;
    classProps?: string;
}>();
</script>

<template>
    <td :class="cn(['h-full items-center justify-center px-6 py-4 font-medium text-gray-900', classProps])">{{ label }} <slot name="label" /></td>
</template>
