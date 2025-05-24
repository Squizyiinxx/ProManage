<script setup lang="ts">
import AuditTrailSection from '@/components/project/projectShow/AuditTrailSection.vue';
import InfoSection from '@/components/project/projectShow/InfoSection.vue';
import RelatedTasks from '@/components/project/projectShow/RelatedTaskSection.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Project } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
    {
        title: 'Project Details',
        href: '/projects/show',
    },
];

defineProps<{
    project: Project;
    auditTrail: any;
}>();
</script>

<template>
    <Head :title="project.name" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-6 px-4 py-6 md:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-primary text-2xl font-bold">Project Details</h1>
            </div>
            <InfoSection :project="project" title="Project Info" />
            <RelatedTasks :tasks="project?.tasks" :project-name="project?.name" title="Related Tasks" />
            <AuditTrailSection :audit-trail="auditTrail" title="Audit Trail" />
        </div>
    </AppLayout>
</template>
