<script setup lang="ts">
import { RoleProps } from '@/types';
import { router } from '@inertiajs/vue3';
import { DialogTrigger } from 'reka-ui';
import { ref } from 'vue';
import ModalDialog from '../ModalDialog.vue';
import { Button } from '../ui/button';

const props = defineProps<{
    role: RoleProps;
    title?: string;
}>();

const isOpen = ref(false);
const submit = () => {
    router.delete(route('role.destroy', props.role.uuid), {
        onSuccess: () => {
            isOpen.value = false;
        },
    });
};
</script>

<template>
    <ModalDialog v-model:open="isOpen" :aria-describedby="`${title}-${role.name}`">
        <template #trigger>
            <DialogTrigger as-child>
                <button
                    @click="isOpen = true"
                    type="button"
                    arial-label="Delete Role"
                    class="cursor-pointer rounded-lg border border-red-600 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-600 hover:text-white"
                >
                    Delete
                </button>
            </DialogTrigger>
        </template>
        <template #contentMain>
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4">
                    <h2 class="text-primary text-lg font-semibold">Delete {{ props.title }}</h2>
                    <p class="text-muted-foreground text-sm text-pretty">
                        Are you sure you want to delete the {{ props.title }} {{ props.role.name }}?
                    </p>
                    <div class="flex w-full justify-between">
                        <Button type="button" variant="secondary" @click="isOpen = false" class="">Cancel</Button>
                        <Button type="submit" variant="destructive">Delete</Button>
                    </div>
                </div>
            </form>
        </template>
    </ModalDialog>
</template>
