<script setup lang="ts">
import { Task } from '@/types';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { DialogTrigger } from 'reka-ui';
import { ref } from 'vue';
import ModalDialog from '../ModalDialog.vue';
import { Button } from '../ui/button';

const props = defineProps<{
    task: Task;
    title: string;
}>();

const isOpen = ref(false);
const submit = () => {
    router.delete(route('task.destroy', props.task.id), {
        onSuccess: () => {
            isOpen.value = false;
        },
    });
};
</script>

<template>
    <ModalDialog v-model:open="isOpen">
        <template #trigger>
            <DialogTrigger as-child>
                <button
                    @click="isOpen = true"
                    varian
                    type="button"
                    arial-label="Delete client"
                    class="cursor-pointer rounded-full p-1 text-red-600 hover:bg-gray-100 hover:text-red-900"
                >
                    <Trash2 class="h-5 w-5" />
                </button>
            </DialogTrigger>
        </template>
        <template #contentMain>
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4">
                    <h2 class="text-primary text-lg font-semibold">Delete {{ props.title }}</h2>
                    <p class="text-muted-foreground text-sm text-pretty">
                        Are you sure you want to delete the {{ props.title }} {{ props.task.title }}?
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
