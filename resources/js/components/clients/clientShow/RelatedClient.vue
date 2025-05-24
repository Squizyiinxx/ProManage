<script setup lang="ts">
import CardList from '@/components/CardList.vue';
import StatusBadge from '@/components/StatusBadge.vue';
import RelatedLayout from '@/layouts/RelatedLayout.vue';
import { Project } from '@/types';
import { Link } from '@inertiajs/vue3';
import { PencilLine } from 'lucide-vue-next';

defineProps<{
    projects?: Project[];
    taskName: string;
    title: string;
}>();
</script>

<template>
    <RelatedLayout :title="title" :data="projects" :view-all-route="`/projects?search=${taskName}&sortBy=created_at&sortOrder=desc&trashed=false`">
        <template #icon>
            <PencilLine class="text-primary mr-2 h-5 w-5" />
        </template>
        <template #main>
            <div v-if="projects?.length === 0" class="text-center text-gray-500">
                <p>No related projects available.</p>
            </div>
            <CardList v-else v-for="project in projects" :key="project.id" class="flex items-center font-mono text-sm">
                <span class="bg-foreground h-2 w-2 rounded-full" />
                <Link :href="route('projects.show', project?.id)" class="hover:text-primary col-span-2 font-mono text-sm capitalize hover:underline"
                    >{{ project?.name }}
                </Link>
                <span class="col-span-2 rounded-lg font-mono text-sm shadow-sm">
                    <StatusBadge :status="project.status" />
                </span>
            </CardList>
        </template>
    </RelatedLayout>
</template>
