<script setup lang="ts">
import DialogLayout from '@/layouts/DialogLayout.vue';
import { handleFormUpdate } from '@/lib/utils';
import { RoleProps, User } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { Pen } from 'lucide-vue-next';
import { onMounted } from 'vue';
import FormUser from './FormUser.vue';

const props = defineProps<{
    user: User<RoleProps>;
    title: string;
}>();

const form = useForm({
    name: '',
    email: '',
    role: '',
    is_active: 1,
});
onMounted(() => {
    form.name = props.user.name;
    form.email = props.user.email ?? '';
    form.role = props.user.role?.uuid ?? '';
    form.is_active = props.user.is_active ? 1 : 0;
});
</script>

<template>
    <DialogLayout :title="title" route-name="user.update" method="put" :route-params="props.user.id" :form="form">
        <template #trigger>
            <Pen class="mr-2 h-5 w-5 text-yellow-400" />
        </template>
        <template #contentMain="{ form, title, submit }">
            <FormUser desc="Edit user profile" :form="form" @update:form="handleFormUpdate(form, $event)" :title="title" :submit="submit" />
        </template>
    </DialogLayout>
</template>
