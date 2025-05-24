<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { Task } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Pen } from 'lucide-vue-next';
import { onMounted } from 'vue';
import FormTask from './FormTask.vue';

const props = defineProps<{
    task: Task;
    title: string;
}>();

const form = useForm({
    title: '',
    description: '',
    project_id: '',
    assigned_to: '',
    status: '',
    priority: '',
    due_date: '',
});
onMounted(() => {
    form.title = props.task.title;
    form.description = props.task.description ?? '';
    form.project_id = props.task?.project_id ?? '';
    form.assigned_to = props.task?.assigned_to ?? '';
    form.status = props.task.status;
    form.priority = props.task.priority;
    form.due_date = props.task.due_date;
});
</script>

<template>
    <DialogLayout :title="title" route-name="task.update" method="put" :route-params="props.task.id" :form="form">
        <template #trigger>
            <Pen class="mr-2 h-5 w-5 text-yellow-400" />
        </template>
        <template #contentMain="{ form, title, submit }">
            <FormTask desc="Edit task profile" :form="form" @update:form="handleFormUpdate(form, $event)" :title="title" :submit="submit" />
        </template>
    </DialogLayout>
</template>
