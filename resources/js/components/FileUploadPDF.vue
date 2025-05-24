<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { File, UploadCloud, XIcon } from 'lucide-vue-next';
import { ref } from 'vue';

const inputRef = ref<HTMLInputElement | null>(null);
const props = defineProps<{
    dataId: string;
    attachment?: {
        original_name: string;
        uploaded_at: string;
        url: string;
    }[];
    routeName: string;
}>();

const form = useForm({
    attachment: null as File | null,
});

function handleFileChange(event: Event) {
    const file = (event.target as HTMLInputElement)?.files?.[0];
    if (!file) return;

    form.clearErrors();

    if (file.type !== 'application/pdf') {
        form.setError('attachment', 'Format tidak valid. Harus file PDF.');
        return;
    }

    const sizeKB = file.size / 1024;
    if (sizeKB < 100 || sizeKB > 500) {
        form.setError('attachment', 'Ukuran file harus 100 – 500 KB.');
        return;
    }

    form.attachment = file;
}

function resetFile() {
    form.attachment = null;
    form.clearErrors();
    if (inputRef.value) inputRef.value.value = '';
}

function submitAttachment() {
    form.post(route(props.routeName, props.dataId), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            resetFile();
        },
    });
}
</script>

<template>
    <div class="w-full space-y-3">
        <h3 class="text-foreground text-base font-semibold">Upload PDF File</h3>
        <label
            class="relative flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed px-6 py-10 transition-all duration-200"
            :class="form.errors.attachment ? 'border-red-400' : 'hover:border-primary border-gray-300'"
        >
            <input
                ref="inputRef"
                type="file"
                accept=".pdf"
                class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                @change="handleFileChange"
            />
            <UploadCloud class="text-primary h-8 w-8" />
            <span class="text-primary text-sm font-medium">Klik untuk pilih file PDF</span>
            <span class="mt-1 text-xs text-gray-500">Ukuran 100–500 KB</span>
        </label>

        <div v-if="props.attachment && !form.attachment" class="flex items-center justify-between px-2 text-sm">
            <span class="text-card-foreground flex items-center gap-1">
                <File class="mr-2 h-4 w-4" />
                <a :href="props.attachment[0].url" target="_blank" class="hover:text-primary underline">
                    {{ props.attachment[0].original_name }}
                </a>
                {{ props.attachment[0].uploaded_at }}
            </span>
        </div>

        <div v-if="form.attachment" class="flex items-center justify-between px-2 text-sm">
            <span class="text-card-foreground flex items-center gap-1"> <File class="mr-2 h-4 w-4" /> {{ form.attachment.name }} </span>
            <div class="flex items-center gap-2">
                <button @click="submitAttachment" class="bg-primary text-accent cursor-pointer rounded-lg px-4 py-2 text-xs shadow-sm">
                    Save File
                </button>
                <button @click="resetFile" class="cursor-pointer rounded-lg bg-red-500 px-4 py-2 text-xs text-slate-100 shadow-sm">Reset</button>
            </div>
        </div>

        <span v-if="form.errors.attachment" class="flex items-center px-2 text-sm text-red-600">
            <XIcon class="mr-2 h-5 w-5" /> {{ form.errors.attachment }}
        </span>
    </div>
</template>

<style scoped></style>
