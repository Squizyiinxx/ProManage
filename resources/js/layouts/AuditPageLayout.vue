<script setup lang="ts">
import TableAudit from '@/components/TableAudit.vue';
import PaginationTable from '@/components/table/PaginationTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps<{
    breadcrumbs: BreadcrumbItem[];
    title: string;
    auditTrail: any;
}>();
</script>

<template>
    <Head :title="`${title} Histroy`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-6 px-4 py-6 md:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-primary text-2xl font-bold">{{ title }} History</h1>
            </div>
            <TableAudit title="History & Note" :audit-trail="auditTrail.data" />
            <PaginationTable :pagination="auditTrail" />
        </div>
    </AppLayout>
</template>
