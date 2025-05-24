<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { DialogTrigger } from 'reka-ui';
import { ref } from 'vue';

import ModalDialog from '../ModalDialog.vue';
import ScrollArea from '../ScrollArea.vue';
import Input from '../ui/input/Input.vue';
import Label from '../ui/label/Label.vue';

const props = defineProps<{
    title: string;
    routeName: string;
    columnLabels: any;
}>();

const availableColumns = ref(props.columnLabels);
const selectedFields = ref<string[]>([]);

const isOpen = ref(false);

const toggleSelect = (field: string) => {
    const index = selectedFields.value.indexOf(field);
    if (index > -1) {
        selectedFields.value.splice(index, 1);
    } else {
        selectedFields.value.push(field);
    }
};

const saveChanges = () => {
    if (selectedFields.value.length === 0) {
        alert('Pilih setidaknya satu kolom untuk diekspor.');
        return;
    }

    router.post(
        route(props.routeName),
        { fields: selectedFields.value },
        {
            preserveScroll: true,
            onSuccess: () => {
                isOpen.value = false;
            },
        },
    );
};
</script>

<template>
    <ModalDialog v-model:open="isOpen">
        <template #trigger>
            <DialogTrigger as-child>
                <button
                    type="button"
                    aria-label="Export Projects"
                    @click="isOpen = true"
                    class="text-primary border-primary hover:bg-primary cursor-pointer rounded-lg border px-4 py-2 text-sm font-medium transition hover:text-white"
                >
                    Export
                </button>
            </DialogTrigger>
        </template>

        <template #contentMain>
            <h2 class="mb-4 text-xl font-semibold">{{ title }}</h2>
            <ScrollArea class="max-h-64 pr-2">
                <div class="space-y-2">
                    <Label
                        v-for="[key, label] in availableColumns"
                        :key="label"
                        :for="`field-${key}`"
                        class="flex w-full cursor-pointer items-center justify-between border-b py-2"
                    >
                        <span class="text-foreground text-sm">{{ label }}</span>
                        <Input
                            :id="`field-${key}`"
                            type="checkbox"
                            class="accent-primary max-w-max"
                            :checked="selectedFields.includes(key)"
                            @change="() => toggleSelect(key)"
                        />
                    </Label>
                </div>
            </ScrollArea>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    type="button"
                    @click="isOpen = false"
                    class="text-muted-foreground hover:bg-muted rounded-md border px-4 py-2 text-sm transition"
                >
                    Cancel
                </button>
                <button type="button" @click="saveChanges" class="bg-primary hover:bg-primary/80 rounded-md px-4 py-2 text-sm text-white transition">
                    Export
                </button>
            </div>
        </template>
    </ModalDialog>
</template>
