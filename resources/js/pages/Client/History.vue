<script setup lang="ts">
import AuditPageLayout from '@/layouts/AuditPageLayout.vue';
import { BreadcrumbItem } from '@/types';

defineProps<{
    auditTrail: any;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
    {
        title: 'Client History',
        href: '/clients/history',
    },
];
</script>

<template>
    <AuditPageLayout :breadcrumbs="breadcrumbs" title="Projects" :audit-trail="auditTrail" />
</template>
