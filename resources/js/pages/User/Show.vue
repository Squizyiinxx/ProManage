<script setup lang="ts">
import TableAudit from '@/components/TableAudit.vue';
import RelatedProjects from '@/components/clients/clientShow/RelatedClient.vue';
import RelatedTaskSection from '@/components/project/projectShow/RelatedTaskSection.vue';
import UserInfo from '@/components/user/UserShow/UserInfo.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Project, RoleProps, Task, User } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User',
        href: '/Users',
    },
    {
        title: 'User Details',
        href: '/User/show',
    },
];

const props = defineProps<{
    user: User<RoleProps>;
    projects: Project[];
    tasks: Task[];
    auditTrail: any;
}>();

onMounted(() => {
    console.log(props.tasks);
});
</script>

<template>
    <Head :title="user.name" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto space-y-6 px-4 py-6 md:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-primary text-2xl font-bold">User Details</h1>
            </div>
            <div class="grid w-full grid-cols-1 gap-6 lg:grid-cols-3">
                <UserInfo :user="user" title="User Info" :class="tasks.length > 0 || projects.length > 0 ? 'lg:col-span-2' : 'lg:col-span-3'" />
                <RelatedTaskSection v-if="tasks.length > 0" :tasks="tasks" :project-name="user?.name" title="Related Tasks" />
                <RelatedProjects v-if="projects.length > 0" :projects="projects" :taskName="user.name" title="Related Projects" />
                <TableAudit title="Audit Trail" :audit-trail="auditTrail" class="md:col-span-3" />
            </div>
        </div>
    </AppLayout>
</template>
