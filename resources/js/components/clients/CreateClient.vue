<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { useForm } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import FormClient from './FormClient.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    company: '',
    address: '',
});

defineProps<{
    title: string;
}>();
</script>

<template>
    <DialogLayout :title="title" route-name="clients.store" :form="form">
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
                desc="Add new client and manage your tasks efficiently."
                button-text="Add Client"
                :submit="submit"
            />
        </template>
    </DialogLayout>
</template>
c
