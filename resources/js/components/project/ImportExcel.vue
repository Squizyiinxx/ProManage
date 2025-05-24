<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import ModalDialog from '../ModalDialog.vue';
import Button from '../ui/button/Button.vue';

const isOpen = ref(false);
const validation = ref(false);
const props = defineProps<{
    title: string;
    routeName: string;
}>();

const form = useForm({
    file: null as File | null,
});

watch(isOpen, (value) => {
    if (!value && !validation.value) {
        form.reset();
    }
});

const allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'];

const handleImport = (event: Event) => {
    const input = event.target as HTMLInputElement;
    const file = input.files?.[0];

    if (!file) return;

    if (!allowedTypes.includes(file.type)) {
        validation.value = true;
        isOpen.value = true;
        input.value = '';
        return;
    }
    isOpen.value = true;
    form.file = file;
};

const submit = () => {
    form.post(route(props.routeName), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            isOpen.value = false;
        },
        onError: () => {
            alert('Terjadi kesalahan saat mengimpor file.');
        },
    });
};
</script>

<template>
    <label
        for="import"
        class="bg-chart-3/80 hover:bg-chart-3 inline-flex cursor-pointer items-center gap-2 rounded-lg border px-4 py-2 shadow-md transition"
    >
        <input id="import" type="file" accept=".xlsx, .xls, .csv" class="hidden" @change="handleImport" :disabled="form.processing" />
        <span v-if="form.processing">Importing...</span>
        <span v-else>Import</span>
    </label>
    <ModalDialog v-model:open="isOpen">
        <template #contentMain>
            <div v-if="validation" class="flex flex-col items-center justify-center gap-4 text-center">
                <X class="text-red h-8 w-8" />
                <h2 class="text-red text-lg font-semibold">Please upload a valid Excel or CSV file</h2>
                <Button
                    type="button"
                    variant="secondary"
                    @click="
                        () => {
                            isOpen = false;
                            validation = false;
                        }
                    "
                >
                    Back
                </Button>
            </div>

            <form v-else @submit.prevent="submit">
                <h2 class="text-primary text-lg font-semibold">{{ title }}</h2>
                <div class="flex flex-col gap-4">
                    <p class="text-muted-foreground text-sm">Are you sure you want to import this file?</p>
                    <div class="flex justify-between">
                        <Button
                            type="button"
                            variant="destructive"
                            @click="
                                () => {
                                    isOpen = false;
                                    form.reset();
                                }
                            "
                        >
                            Cancel
                        </Button>
                        <Button type="submit" variant="default">Import</Button>
                    </div>
                </div>
            </form>
        </template>
    </ModalDialog>
</template>
