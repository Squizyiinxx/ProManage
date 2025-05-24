<script setup lang="ts">
import FileUploadPDF from '@/components/FileUploadPDF.vue';
import Card from '@/layouts/Card.vue';

defineProps<{
    attachment?: any;
    taskId: any;
}>();
</script>

<template>
    <Card title="Attachment">
        <template #main>
            <FileUploadPDF route-name="task.upload-attachment" :attachment="attachment" :data-id="taskId" />
        </template>
    </Card>
</template>
