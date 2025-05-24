<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { Project } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Pen } from 'lucide-vue-next';
import { onMounted } from 'vue';
import FormProject from './FormProject.vue';

const props = defineProps<{
    project: Project;
    title: string;
}>();

const form = useForm({
    name: '',
    description: '',
    client_id: '',
    manager_id: '',
    started_at: '',
    deadline: '',
});
onMounted(() => {
    form.name = props.project.name;
    form.description = props?.project?.description ?? '';
    form.client_id = props?.project?.client?.id ?? '';
    form.manager_id = props?.project?.manager?.id ?? '';
    form.started_at = props.project.started_at ? props.project.started_at.replace(' ', 'T').slice(0, 16) : '';
    form.deadline = props.project.deadline ? props.project.deadline.replace(' ', 'T').slice(0, 16) : '';
});
</script>

<template>
    <DialogLayout :title="title" route-name="projects.update" method="put" :route-params="props.project.id" :form="form">
        <template #trigger>
            <Pen class="mr-2 h-5 w-5 text-yellow-400" />
        </template>
        <template #contentMain="{ form, title, submit }">
            <FormProject
                :form="form"
                @update:form="handleFormUpdate(form, $event)"
                desc="Edit project profile and manage your tasks efficiently."
                :title="title"
                :submit="submit"
            />
        </template>
    </DialogLayout>
</template>
