<script setup lang="ts">
defineProps<{
    isFeatureVisible: boolean;
    title: string;
    description: string;
}>();
</script>

<template>
    <div
        class="bg-card border-border rounded-lg border p-6 shadow-sm transition-all duration-200 hover:shadow-md"
        :class="{ 'animate-fadeUp': isFeatureVisible }"
    >
        <div class="bg-primary/10 text-primary mb-4 flex h-12 w-12 items-center justify-center rounded-lg">
            <slot name="icon" />
        </div>
        <h3 class="mb-2 text-xl font-semibold">{{ title }}</h3>
        <p class="text-muted-foreground">{{ description }}.</p>
    </div>
</template>
