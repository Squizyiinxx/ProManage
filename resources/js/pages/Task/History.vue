<script setup lang="ts">
import AuditPageLayout from '@/layouts/AuditPageLayout.vue';
import { BreadcrumbItem } from '@/types';

defineProps<{
    auditTrail: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: '/tasks',
    },
    {
        title: 'Task History',
        href: '/tasks/history',
    },
];
</script>

<template>
    <AuditPageLayout :breadcrumbs="breadcrumbs" title="Projects" :audit-trail="auditTrail" />
</template>
