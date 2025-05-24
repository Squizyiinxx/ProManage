<script setup lang="ts">
import AuditPageLayout from '@/layouts/AuditPageLayout.vue';
import { BreadcrumbItem } from '@/types';

defineProps<{
    auditTrail: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: '/roles',
    },
    {
        title: 'Role History',
        href: '/roles/history',
    },
];
</script>

<template>
    <AuditPageLayout :breadcrumbs="breadcrumbs" title="Roles" :audit-trail="auditTrail" />
</template>
