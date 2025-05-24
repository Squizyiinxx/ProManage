<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Task } from '@/types';
import { Head } from '@inertiajs/vue3';
import { FolderOpen, Timer } from 'lucide-vue-next';
import { computed } from 'vue';
import TableAudit from '../../components/TableAudit.vue';
import Attachment from '../../components/tasks/TaskDetails/Attachment.vue';
import InfoTask from '../../components/tasks/TaskDetails/InfoTask.vue';

const props = defineProps<{
    task: Task;
    auditTrail: any[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: '/tasks',
    },
    {
        title: 'Task Details',
        href: '/tasks/show',
    },
];

const statusColor = computed(() => {
    switch (props.task.status) {
        case 'active':
            return 'bg-green-100 text-green-800';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'completed':
            return 'bg-blue-100 text-blue-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
});
</script>

<template>
    <Head :title="`${task.title}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto max-w-6xl px-4 py-6">
            <header class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div class="flex items-center space-x-3">
                    <FolderOpen class="mr-2 h-5 w-5 text-yellow-500" />
                    <h1 class="text-primary text-2xl font-bold capitalize">
                        {{ task.title }}
                    </h1>
                    <span :class="[statusColor, 'flex items-center gap-1 rounded-md px-2 py-1 text-sm font-medium capitalize']">
                        <Timer class="mr-2 h-5 w-5" /> {{ task.status }}
                    </span>
                </div>
            </header>

            <div class="mb-4 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <InfoTask title="Task Info" :task="task" />
                <Attachment title="Attachment" :task-id="task.id" :attachment="task?.attachments" />
            </div>
            <TableAudit title="Audit Trail" :audit-trail="auditTrail" />
        </div>
    </AppLayout>
</template>
