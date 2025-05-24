<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { Client } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Pen } from 'lucide-vue-next';
import { onMounted } from 'vue';
import FormClient from './FormClient.vue';

const props = defineProps<{
    client: Client;
    title: string;
}>();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    company: '',
    address: '',
});
onMounted(() => {
    form.name = props.client.name;
    form.email = props.client.email ?? '';
    form.phone = props.client.phone ?? '';
    form.company = props.client.company ?? '';
    form.address = props.client.address ?? '';
});
</script>

<template>
    <DialogLayout :title="title" route-name="clients.update" method="put" :route-params="props.client.id" :form="form">
        <template #trigger>
            <Pen class="mr-2 h-5 w-5 text-yellow-400" />
        </template>
        <template #contentMain="{ form, title, submit }">
            <FormClient
                desc="Edit client profile and manage your tasks efficiently."
                :form="form"
                @update:form="handleFormUpdate(form, $event)"
                :title="title"
                :submit="submit"
            />
        </template>
    </DialogLayout>
</template>
