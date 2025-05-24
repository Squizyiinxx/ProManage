<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import FormClient from './FormUser.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    is_active: 1,
});

defineProps<{
    title: string;
}>();
</script>

<template>
    <DialogLayout :title="title" route-name="register" :form="form">
        <template #trigger>
            <span
                class="inline-flex w-full items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:outline-none md:max-w-[180px]"
            >
                <Plus class="mr-2" />
                {{ title }}
            </span>
        </template>

        <template #contentMain="{ form, title, submit }">
            <FormClient
                :form="form"
                @update:form="handleFormUpdate(form, $event)"
                :title="title"
                desc="Create an Account"
                button-text="Create account"
                :submit="submit"
            />
        </template>
    </DialogLayout>
</template>
