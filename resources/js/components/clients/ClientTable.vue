<script setup lang="ts">
import usePermission from '@/composables/usePermission';
import { useClientStore } from '@/stores/ClientStore';
import { Link } from '@inertiajs/vue3';
import { EyeIcon } from 'lucide-vue-next';
import TableComponent from '../table/TableComponent.vue';
import TdComponent from '../table/TdComponent.vue';
import ThComponent from '../table/ThComponent.vue';
import DestroyClient from './DestroyClient.vue';
import EditClient from './EditClient.vue';
const store = useClientStore();

const { has } = usePermission();
</script>

<template>
    <TableComponent :datas="store.clients?.data || []">
        <template #header>
            <ThComponent
                field="name"
                title="Client Name"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('name')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="email" title="Email" />
            <ThComponent field="phone" title="Phone" />
            <ThComponent
                field="company"
                title="Company"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('status')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="address" title="Address" />
            <ThComponent field="actions" title="Actions" classProps="text-right" />
        </template>

        <template #row="{ row }">
            <TdComponent :label="row.name" />
            <TdComponent :label="row.email" />
            <TdComponent :label="row.phone" />
            <TdComponent :label="row.company" />
            <TdComponent :label="row.address" />
            <TdComponent>
                <template #label>
                    <div class="flex h-full gap-2 text-right text-sm whitespace-nowrap">
                        <Link :href="route('clients.show', row.id)" class="flex cursor-pointer items-center">
                            <EyeIcon class="text-primary-foreground mr-2 h-5 w-5" />
                        </Link>
                        <EditClient v-if="has('client.update')" title="Edit client" :client="row" />
                        <DestroyClient v-if="has('client.delete')" title="Client" :client="row" />
                    </div>
                </template>
            </TdComponent>
        </template>
    </TableComponent>
</template>

<style lang="css" scoped>
.line-clamp-2 {
    display: -webkit-box;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
