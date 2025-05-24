<script setup lang="ts">
import ModalDialog from '@/components/ModalDialog.vue';
import { ref } from 'vue';

interface DialogLayoutProps {
    title: string;
    form: any;
    routeName: string;
    routeParams?: string | number;
    method?: 'post' | 'put' | 'patch' | 'delete';
}

const props = defineProps<DialogLayoutProps>();
const isOpen = ref(false);
const submit = () => {
    props.form.transform((data: any) => ({
        ...data,
        is_active: data.is_active === 1,
    }));

    const method = props.method ?? 'post';

    const inertiaOptions = {
        preserveScroll: true,
        onSuccess: () => {
            isOpen.value = false;
        },
    };

    if (method === 'put') {
        props.form.put(route(props.routeName, props.routeParams), inertiaOptions);
    } else if (method === 'patch') {
        props.form.patch(route(props.routeName, props.routeParams), inertiaOptions);
    } else if (method === 'delete') {
        props.form.delete(route(props.routeName, props.routeParams), inertiaOptions);
    } else {
        props.form.post(route(props.routeName), inertiaOptions);
    }
};
</script>

<template>
    <ModalDialog v-model:open="isOpen">
        <template #trigger>
            <slot name="trigger" />
        </template>
        <template #contentMain>
            <slot name="contentMain" :form="form" :title="title" :submit="submit" />
        </template>
    </ModalDialog>
</template>
