<script setup lang="ts">
import ClientFilters from '@/components/clients/ClientFilters.vue';
import ClientTable from '@/components/clients/ClientTable.vue';
import CreateClient from '@/components/clients/CreateClient.vue';
import PaginationTable from '@/components/table/PaginationTable.vue';
import usePermission from '@/composables/usePermission';
import AppLayout from '@/layouts/AppLayout.vue';
import { useClientStore } from '@/stores/ClientStore';
import { Client, Pagination } from '@/types';
import { FiltersClient } from '@/types/client';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, DownloadCloud } from 'lucide-vue-next';
import { onMounted, watch } from 'vue';
interface Props {
    clients: Pagination<Client[]>;
    filters: FiltersClient;
    file: any;
}
const props = defineProps<Props>();
const store = useClientStore();
const { has } = usePermission();

onMounted(() => {
    store.setClient(props.clients);
    store.setFilters(props.filters);
});
watch(
    () => props.clients,
    (newProjects) => {
        store.setClient(newProjects);
    },
    { immediate: true },
);
</script>

<template>
    <Head title="Clients" />
    <AppLayout>
        <div class="container mx-auto p-4 md:p-8">
            <div class="mb-8 flex flex-col items-center justify-between gap-5 md:flex-row">
                <div class="text-center md:text-left">
                    <h1 class="text-primary text-2xl font-bold">Clients</h1>
                    <p class="text-foreground mt-1 text-sm">Manage and track your clients</p>
                </div>
                <CreateClient v-if="has('client.create')" title="Add Client" />
            </div>
            <div class="my-3 flex items-center justify-end">
                <Link
                    :href="route('clients.history')"
                    class="text-primary group flex items-center gap-x-2 hover:underline"
                    aria-label="Back to dashboard"
                >
                    View History <ArrowRight class="h-4 w-4 duration-500 ease-in-out group-hover:translate-x-1.5" />
                </Link>
            </div>
            <ClientFilters />
            <ClientTable />
            <PaginationTable :pagination="store.clients" />
            <div class="my-6 flex items-center justify-between">
                <div class="min-w-0">
                    <PaginationTable :pagination="store.clients" />
                </div>
                <div class="ml-auto">
                    <a
                        v-if="file"
                        target="_blank"
                        rel="noopener"
                        :href="route('download.export', file.id)"
                        class="bg-primary-foreground text-primary hover:bg-accent flex cursor-pointer items-center rounded-lg px-4 py-2 shadow-lg transition-colors duration-300 ease-in-out"
                    >
                        <DownloadCloud class="mr-2 h-4 w-4" /> Download Export
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
