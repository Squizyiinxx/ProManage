<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { ClientForm } from '@/types/client';
import { DialogDescription, DialogTitle } from 'reka-ui';
import InputError from '../InputError.vue';

const props = defineProps<{
    form: ClientForm;
    title?: string;
    desc?: string;
    submit: () => void;
    buttonText?: string;
}>();

const emit = defineEmits<{
    'update:form': [form: ClientForm];
}>();
const updateField = (field: string, value: any) => {
    emit('update:form', { ...props.form, [field]: value });
};

const onlyNumbers = (event: KeyboardEvent) => {
    const keyCode = event.keyCode;
    if ((keyCode < 48 || keyCode > 57) && keyCode !== 8) {
        event.preventDefault();
    }
};

const formatPhoneNumber = (event: Event) => {
    const input = event.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');
    value = value.replace(/^0+/, '');
    value = value.replace(/^62/, '');

    if (value.length > 3 && value.length <= 7) {
        value = value.slice(0, 3) + '-' + value.slice(3);
    } else if (value.length > 7) {
        value = value.slice(0, 3) + '-' + value.slice(3, 7) + '-' + value.slice(7);
    }
    updateField('phone', value);
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
        <fieldset class="mb-4 grid gap-2">
            <Label for="client Name" class="text-sm capitalize"> Client Name </Label>
            <Input
                id="client Name"
                :model-value="props.form.name"
                @update:model-value="updateField('name', $event)"
                class="mt-1 block w-full"
                :placeholder="`Enter Client name`"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.name" />
        </fieldset>
        <fieldset class="mb-4 grid gap-2">
            <Label for="project_description" class="text-sm capitalize"> Email Client </Label>
            <Input
                id="project_description"
                type="email"
                :model-value="props.form.email"
                @update:model-value="updateField('email', $event)"
                class="mt-1 block w-full"
                :placeholder="`@example.com`"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.email" />
        </fieldset>
        <div class="flex w-full items-center gap-4">
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="phone" class="text-sm capitalize"> Phone number </Label>
                <div class="relative flex items-center">
                    <span class="absolute top-3 left-2 text-sm text-gray-500">+62</span>
                    <Input
                        id="phone"
                        type="tel"
                        :model-value="props.form.phone"
                        class="mt-1 block w-full pl-12"
                        placeholder="8123456789"
                        required
                        @input="formatPhoneNumber"
                        @keypress="onlyNumbers"
                        maxlength="13"
                    />
                </div>
                <InputError class="mt-2" :message="props.form.errors?.phone" />
            </fieldset>
            <fieldset class="mb-4 grid w-full gap-2">
                <Label for="company" class="text-sm capitalize"> Company </Label>
                <Input
                    id="company"
                    type="text"
                    :model-value="props.form.company"
                    @update:model-value="updateField('company', $event)"
                    class="mt-1 block w-full"
                    placeholder="Enter company"
                    required
                />
                <InputError class="mt-2" :message="props.form.errors?.company" />
            </fieldset>
        </div>
        <fieldset class="mb-4 grid w-full gap-2">
            <Label for="address" class="text-sm capitalize"> Address </Label>
            <Input
                id="address"
                type="text"
                :model-value="props.form.address"
                @update:model-value="updateField('address', $event)"
                class="mt-1 block w-full"
                placeholder="Enter Address"
                required
            />
            <InputError class="mt-2" :message="props.form.errors?.address" />
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
