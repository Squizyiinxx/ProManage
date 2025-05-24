<script setup lang="ts">
import CardList from '@/components/CardList.vue';
import Card from '@/layouts/Card.vue';
import { ClockIcon, UserIcon } from 'lucide-vue-next';

defineProps<{
    auditTrail?: any;
    title?: string;
}>();
</script>

<template>
    <Card :title="title" class-props="w-full col-span-2">
        <template #icon>
            <ClockIcon class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <div class="mb-6 space-y-3">
                <CardList title="Created By">
                    <UserIcon class="mr-2 h-4 w-4 text-gray-500" />
                    {{ auditTrail.createdBy }}
                </CardList>
                <CardList title="Created At">
                    <ClockIcon class="mr-2 h-4 w-4 text-gray-500" />
                    {{ auditTrail.createdAt }}
                </CardList>
                <CardList title="Update By">
                    <UserIcon class="mr-2 h-4 w-4 text-gray-500" />
                    {{ auditTrail.updatedBy }}
                </CardList>
                <CardList title="Update At">
                    <ClockIcon class="mr-2 h-4 w-4 text-gray-500" />
                    {{ auditTrail.updatedAt }}
                </CardList>
            </div>
        </template>
    </Card>
</template>

<style lang="css" scoped></style>
