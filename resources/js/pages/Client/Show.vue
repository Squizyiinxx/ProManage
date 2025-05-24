<script setup lang="ts">
import ClientInfo from '@/components/clients/clientShow/ClientInfo.vue';
import RelatedProjects from '@/components/clients/clientShow/RelatedClient.vue';
import TableAudit from '@/components/TableAudit.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Client } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Clients',
        href: '/clients',
    },
    {
        title: 'Client Details',
        href: '/clients/show',
    },
];

defineProps<{
    client: Client;
    auditTrail: any;
}>();
</script>

<template>
    <Head :title="client.name" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-6 px-4 py-6 md:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-primary text-2xl font-bold">Client Details</h1>
            </div>
            <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-3">
                <ClientInfo :client="client" title="Client Info" class="lg:col-span-2" />
                <RelatedProjects :projects="client.projects" :taskName="client.name" title="Related Projects" />
                <TableAudit title="Audit Trail" :audit-trail="auditTrail" class="lg:col-span-3" />
            </div>
        </div>
    </AppLayout>
</template>
