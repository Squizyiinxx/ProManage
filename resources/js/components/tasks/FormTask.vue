<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { priority, statusTask } from '@/constants';
import { useTaskStore } from '@/stores/TasksStore';
import { TaskForm } from '@/types/task';
import { DialogDescription, DialogTitle } from 'reka-ui';
import InputError from '../InputError.vue';
import Select from '../Select.vue';

const { projects, tim } = useTaskStore();

const props = defineProps<{
    form: TaskForm;
    title?: string;
    desc?: string;
    submit: () => void;
    buttonText?: string;
}>();

const emit = defineEmits<{
    'update:form': [form: TaskForm];
}>();
const updateField = (field: string, value: any) => {
    emit('update:form', { ...props.form, [field]: value });
};
</script>

<template>
    <form @submit.prevent="submit" class="w-full">
        <legend>
            <DialogTitle class="text-primary text-lg font-semibold">
                {{ props.title || 'New Project' }}
            </DialogTitle>
            <DialogDescription class="text-foreground mt-[10px] mb-5 text-sm leading-normal">
                {{ props.desc || 'Create a new project and manage your tasks efficiently.' }}
            </DialogDescription>
        </legend>
        <div class="flex w-full items-center gap-4">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="project_name" class="text-sm capitalize"> Title </Label>
                <Input
                    id="title"
                    :tabindex="1"
                    autocomplete="Title"
                    :model-value="props.form.title"
                    @update:model-value="updateField('title', $event)"
                    class="mt-1 block w-full"
                    :placeholder="`Enter task title`"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.title" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="assigned_to" class="text-sm capitalize"> Assigned To </Label>
                <InputError class="mt-1" message="must have a member" v-if="tim?.length === 0" />
                <Select
                    v-else
                    id="assigned_to"
                    :model-value="props.form.assigned_to"
                    @update:model-value="updateField('assigned_to', $event)"
                    title="assigned_to"
                    :options="tim"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.assigned_to" />
            </fieldset>
        </div>
        <fieldset class="mb-4 grid w-full gap-2">
            <Label for="description" class="text-sm capitalize"> Description </Label>
            <Input
                id="description"
                type="text"
                aria-label="description"
                autocomplete="description"
                :model-value="props.form.description"
                @update:model-value="updateField('description', $event)"
                class="mt-1 block w-full"
                :placeholder="`Enter description`"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.description" />
        </fieldset>
        <div class="flex w-full items-center gap-4">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="project">Project</Label>
                <InputError class="mt-1" message="must have a project" v-if="projects?.length === 0" />
                <Select
                    v-else
                    id="project"
                    :model-value="props.form.project_id"
                    @update:model-value="updateField('project_id', $event)"
                    title="Project"
                    :options="projects"
                    required
                />
                <InputError :message="form.errors.project_id" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="status">Status</Label>
                <Select
                    id="status"
                    :model-value="props.form.status"
                    @update:model-value="updateField('status', $event)"
                    title="Status"
                    :options="statusTask"
                />
                <InputError :message="form.errors.status" />
            </fieldset>
        </div>
        <div class="flex w-full items-center gap-4">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="priority" class="text-sm capitalize"> Priority </Label>
                <Select
                    id="priority"
                    :model-value="props.form.priority"
                    @update:model-value="updateField('priority', $event)"
                    title="Priority"
                    :options="priority"
                />
                <InputError class="mt-2" :message="props.form.errors?.priority" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="due_date" class="text-sm capitalize"> Due Date </Label>
                <Input
                    id="due_date"
                    type="datetime-local"
                    :model-value="props.form.due_date"
                    @update:model-value="updateField('due_date', $event)"
                    class="mt-1 block w-full"
                    :placeholder="`Enter project Started at`"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.due_date" />
            </fieldset>
        </div>

        <div class="mt-[25px] flex justify-end">
            <button
                type="submit"
                class="bg-accent text-foreground hover:bg-primary focus:shadow-accent-foreground inline-flex h-[35px] cursor-pointer items-center justify-center rounded-lg px-[15px] text-sm font-semibold transition-colors duration-500 ease-in-out"
            >
                {{ buttonText || 'Save changes' }}
            </button>
        </div>
    </form>
</template>
