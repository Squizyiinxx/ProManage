<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { is_activeOptions } from '@/constants';
import { useUserStore } from '@/stores/UserStore';
import { UserForm } from '@/types/user';
import { DialogDescription, DialogTitle } from 'reka-ui';
import InputError from '../InputError.vue';
import Select from '../Select.vue';

const props = defineProps<{
    form: UserForm;
    title?: string;
    desc?: string;
    submit: () => void;
    buttonText?: string;
}>();

const emit = defineEmits<{
    'update:form': [form: UserForm];
}>();
const updateField = (field: string, value: any) => {
    emit('update:form', { ...props.form, [field]: value });
};

const { role } = useUserStore();
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
        <div :class="`flex ${title?.includes('Edit') ? 'flex-col' : 'flex-row gap-4'} w-full items-center`">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="username" class="text-sm capitalize"> Username </Label>
                <Input
                    id="username"
                    :tabindex="1"
                    autocomplete="username"
                    :model-value="props.form.name"
                    @update:model-value="updateField('name', $event)"
                    class="mt-1 block w-full"
                    :placeholder="`Enter username`"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.name" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="email_user" class="text-sm capitalize"> Email User </Label>
                <Input
                    id="email_user"
                    type="email"
                    :tabindex="2"
                    autocomplete="email"
                    :model-value="props.form.email"
                    @update:model-value="updateField('email', $event)"
                    class="mt-1 block w-full"
                    :placeholder="`apa@example.com`"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.email" />
            </fieldset>
        </div>
        <fieldset class="mb-4 grid w-full gap-2" v-if="!title?.includes('Edit')">
            <Label for="password">password</Label>
            <Input
                id="password"
                type="password"
                required
                :tabindex="3"
                autocomplete="new-password"
                :model-value="props.form.password"
                @update:model-value="updateField('password', $event)"
                placeholder="password"
            />
            <InputError :message="form.errors.password" />
        </fieldset>
        <fieldset class="mb-4 grid w-full gap-2" v-if="!title?.includes('Edit')">
            <Label for="password_confirmation">Confirm password</Label>
            <Input
                id="password_confirmation"
                type="password"
                required
                :tabindex="4"
                autocomplete="new-password"
                :model-value="props.form.password_confirmation"
                @update:model-value="updateField('password_confirmation', $event)"
                placeholder="Confirm password"
            />
            <InputError :message="form.errors.password_confirmation" />
        </fieldset>
        <div class="flex w-full items-center gap-4">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="deadline" class="text-sm capitalize"> Role </Label>
                <Select :model-value="props.form.role" @update:model-value="updateField('role', $event)" title="Role" :options="role" />
                <InputError class="mt-2" :message="props.form.errors?.role" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="active" class="text-sm capitalize"> Active </Label>
                <Select
                    id="active"
                    :model-value="props.form.is_active"
                    @update:model-value="updateField('is_active', $event)"
                    :options="is_activeOptions"
                    class="mt-1 block w-full"
                    title="Active"
                />
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
