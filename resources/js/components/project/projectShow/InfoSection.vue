<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';
import Card from '@/layouts/Card.vue';
import { formatDate } from '@/lib/utils';
import { Project } from '@/types';
import { Link } from '@inertiajs/vue3';
import { CheckCircle, Folder, User2, Workflow, XCircle } from 'lucide-vue-next';
import CardList from '../../CardList.vue';
import FileUploadPDF from '../../FileUploadPDF.vue';

defineProps<{
    project: Project;
    title?: string;
}>();
</script>

<template>
    <Card>
        <template #icon>
            <Folder class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <div class="mb-6 space-y-3">
                <CardList title="Project ID">
                    <span class="col-span-2 font-mono text-sm">{{ project.id }}</span>
                </CardList>
                <CardList title="Project Name"> <Workflow class="mr-2 h-5 w-5 text-blue-500" /> {{ project.name }} </CardList>
                <CardList title="Client">
                    <User2 class="mr-2 h-5 w-5 text-blue-500" />
                    <Link
                        :href="route('clients.show', project.client?.id)"
                        class="hover:text-primary col-span-2 font-mono text-sm capitalize hover:underline"
                        >{{ project.client?.name }}</Link
                    >
                </CardList>
                <CardList title="Assigned To Manager">
                    <User2 class="mr-2 h-5 w-5 text-blue-500" />
                    <Link
                        :href="route('users.show', project.manager?.id)"
                        class="hover:text-primary col-span-2 font-mono text-sm capitalize hover:underline"
                        >{{ project.manager?.name || '-' }}</Link
                    >
                </CardList>
                <CardList title="Started At">
                    <span class="col-span-2">📅 {{ formatDate(project?.started_at) }}</span>
                </CardList>
                <CardList title="Deadline">
                    <span class="col-span-2">📅 {{ formatDate(project.deadline) }}</span>
                </CardList>
                <CardList title="Status">
                    <span class="col-span-2">
                        <StatusBadge :status="project.status" />
                    </span>
                </CardList>
                <CardList title="Deadline">
                    <component
                        :is="project.is_active ? CheckCircle : XCircle"
                        :class="['mr-2 h-5 w-5', project.is_active ? 'text-green-500' : 'text-red-400']"
                    />
                    {{ project.is_active ? 'Active' : 'Inactive' }}
                </CardList>
            </div>
            <FileUploadPDF :route-name="'projects.upload-attachment'" :data-id="project.id" :attachment="project.attachments" />
        </template>
    </Card>
</template>
