<script setup lang="ts">
import TableComponent from '@/components/table/TableComponent.vue';
import TdComponent from '@/components/table/TdComponent.vue';
import ThComponent from '@/components/table/ThComponent.vue';
import Card from '@/layouts/Card.vue';
import { History } from 'lucide-vue-next';

defineProps<{
    auditTrail: any[];
    title?: string;
    statusColor?: string;
}>();
</script>

<template>
    <Card :title="title">
        <template #icon>
            <History class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <TableComponent :datas="auditTrail || []">
                <template #header>
                    <ThComponent field="action" title="Action" />
                    <ThComponent field="user" title="User" />
                    <ThComponent field="description" title="Description" />
                    <ThComponent field="date" title="Date" classProps="text-right" />
                </template>

                <template #row="{ row }">
                    <TdComponent :label="row.event" />
                    <TdComponent :label="row.user || '-'" />
                    <TdComponent :label="row.description" class-props="line-clamp-2" />
                    <TdComponent :label="row.date || '-'" />
                </template>
            </TableComponent>
        </template>
    </Card>
</template>

<style lang="css" scoped></style>
