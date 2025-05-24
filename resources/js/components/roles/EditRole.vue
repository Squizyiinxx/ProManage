<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { RoleProps } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Pen } from 'lucide-vue-next';
import { onMounted } from 'vue';
import FormRole from './FormRole.vue';

const props = defineProps<{
    role: RoleProps;
    title?: string;
}>();

const form = useForm({
    name: '',
});
onMounted(() => {
    form.name = props.role.name ?? '';
});
</script>

<template>
    <DialogLayout :title="title || 'Edit Role'" route-name="role.update" method="put" :route-params="props.role.uuid" :form="form">
        <template #trigger>
            <button
                class="absolute -top-3 -right-4 cursor-pointer rounded-full bg-yellow-400 p-2 shadow-lg transition-colors duration-300 ease-in-out hover:bg-yellow-500"
            >
                <Pen class="h-6 w-6 text-slate-100" />
            </button>
        </template>
        <template #contentMain="{ form, title, submit }">
            <FormRole
                desc="Edit role details and manage its permissions efficiently."
                :form="form"
                @update:form="handleFormUpdate(form, $event)"
                :title="title"
                :submit="submit"
            />
        </template>
    </DialogLayout>
</template>
