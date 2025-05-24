<script setup lang="ts">
import CardList from '@/components/CardList.vue';
import Card from '@/layouts/Card.vue';
import { formatDate } from '@/lib/utils';
import { Link } from '@inertiajs/vue3';
import { Folder } from 'lucide-vue-next';

defineProps<{
    task: any;
    title?: string;
    statusColor?: string;
}>();
</script>

<template>
    <Card title="Info Task">
        <template #icon>
            <Folder class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <CardList title="Project ID">
                <span class="col-span-2 font-mono text-sm">{{ task.id }}</span>
            </CardList>
            <CardList title="Name">
                <span class="col-span-2 font-mono text-sm capitalize">{{ task.title }}</span>
            </CardList>
            <CardList title="Assigned To">
                <span class="col-span-2 font-mono text-sm capitalize">{{ task.assigned.name }}</span>
            </CardList>
            <CardList title="Project">
                <Link
                    :href="route('projects.show', task.project.id)"
                    class="hover:text-primary col-span-2 font-mono text-sm capitalize hover:underline"
                    >{{ task.project.name }}</Link
                >
            </CardList>
            <CardList title="Description">
                <span class="col-span-2 font-mono text-sm capitalize">{{ task.description }}</span>
            </CardList>
            <CardList title="Priority">
                <span class="info-value rounded-xl bg-slate-100 p-1 px-2 font-mono text-sm text-slate-600 capitalize">{{ task.priority }}</span>
            </CardList>
            <CardList title="Due Date">
                <span class="info-value font-mono text-sm">{{ formatDate(task.due_date) }}</span>
            </CardList>
        </template>
    </Card>
</template>

<style lang="css" scoped></style>
