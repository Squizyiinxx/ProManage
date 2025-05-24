<script setup lang="ts">
defineProps<{
    title?: string;
}>();
</script>

<template>
    <div class="flex items-center gap-2">
        <span v-if="title" class="text-foreground/80 min-w-32 font-medium">{{ title }}:</span>
        <span class="flex items-center gap-2 font-semibold">
            <slot />
        </span>
    </div>
</template>

<style lang="css" scoped></style>
