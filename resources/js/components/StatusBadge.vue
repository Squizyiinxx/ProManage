<script setup lang="ts">
import { useProjectStore } from '@/stores/projectStore';
import { StatusKey } from '@/types/project';

const props = defineProps<{
    status: StatusKey;
}>();

const store = useProjectStore();
</script>

<template>
    <span :class="['rounded-full border px-2 py-1 text-xs font-medium', store.getStatusClass(props.status)]">
        {{ store.getStatusLabel(props.status) }}
    </span>
</template>
