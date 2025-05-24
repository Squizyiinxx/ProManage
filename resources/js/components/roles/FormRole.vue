<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { DialogDescription, DialogTitle } from 'reka-ui';
import InputError from '../InputError.vue';
interface FormRoleProps {
    name: string | number;
    errors?: {
        name: string;
    };
}

const props = defineProps<{
    form: FormRoleProps;
    title?: string;
    desc?: string;
    submit: () => void;
    buttonText?: string;
}>();

const emit = defineEmits<{
    'update:form': [form: FormRoleProps];
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
        <fieldset class="mb-4 grid w-full gap-2">
            <Label for="role-name" class="text-sm capitalize"> Role Name </Label>
            <Input
                id="role-name"
                :tabindex="1"
                autocomplete="role-name"
                :model-value="props.form.name"
                @update:model-value="updateField('name', $event)"
                class="mt-1 block w-full"
                :placeholder="`Enter Role Name`"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.name" />
        </fieldset>
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
