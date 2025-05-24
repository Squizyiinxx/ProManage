<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { useProjectStore } from '@/stores/projectStore';
import { ProjectForm } from '@/types/project';
import { DialogDescription, DialogTitle } from 'reka-ui';
import InputError from '../InputError.vue';
import Select from '../Select.vue';
const props = defineProps<{
    form: ProjectForm;
    title?: string;
    desc?: string;
    submit: () => void;
}>();
const emit = defineEmits(['update:form']);
const updateField = (field: string, value: any) => {
    emit('update:form', { ...props.form, [field]: value });
};

const { client, manager } = useProjectStore();
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
        <fieldset class="mb-4 grid gap-2">
            <Label for="project_name" class="text-sm capitalize"> Project Name </Label>
            <Input
                id="project_name"
                :model-value="props.form.name"
                @update:model-value="updateField('name', $event)"
                class="mt-1 block w-full"
                :placeholder="`Enter project name`"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.name" />
        </fieldset>
        <fieldset class="mb-4 grid gap-2">
            <Label for="project_description" class="text-sm capitalize"> Project Description </Label>
            <Input
                id="project_description"
                :model-value="props.form.description"
                @update:model-value="updateField('description', $event)"
                class="mt-1 block w-full"
                :placeholder="`Enter project description`"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.description" />
        </fieldset>
        <div class="mb-4 flex w-full items-center gap-4">
            <InputError v-if="!client || client.length === 0" class="mt-2 w-full" message="Must have a Client" />
            <Select
                v-if="client && client.length > 0"
                :model-value="props.form.client_id"
                @update:model-value="updateField('client_id', $event)"
                title="Client"
                :options="client"
            />
            <InputError v-if="!manager || manager.length === 0" class="mt-2 w-full" message="Must have a Manager" />
            <Select
                v-if="manager && manager.length > 0"
                :model-value="props.form.manager_id"
                @update:model-value="updateField('manager_id', $event)"
                title="Manager"
                :options="manager"
            />
        </div>
        <div class="flex w-full items-center gap-4">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="Started at" class="text-sm capitalize"> Started at </Label>
                <Input
                    id="Started at"
                    type="datetime-local"
                    :model-value="props.form.started_at"
                    @update:model-value="updateField('started_at', $event)"
                    class="mt-1 block w-full"
                    :placeholder="`Enter project Started at`"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.started_at" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="deadline" class="text-sm capitalize"> deadline </Label>
                <Input
                    id="deadline"
                    type="datetime-local"
                    :model-value="props.form.deadline"
                    @update:model-value="updateField('deadline', $event)"
                    class="mt-1 block w-full"
                    :placeholder="`Enter project deadline`"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.deadline" />
            </fieldset>
        </div>
        <div class="mt-[25px] flex justify-end">
            <button
                type="submit"
                class="bg-accent text-foreground hover:bg-primary focus:shadow-accent-foreground inline-flex h-[35px] cursor-pointer items-center justify-center rounded-lg px-[15px] text-sm font-semibold transition-colors duration-500 ease-in-out"
            >
                {{ props.title?.includes('Edit') ? 'Save changes' : 'Create Project' }}
            </button>
        </div>
    </form>
</template>
