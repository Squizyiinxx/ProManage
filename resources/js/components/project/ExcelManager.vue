<script setup lang="ts">
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const showExportModal = ref(false);
const availableFields = ref(['name', 'description']);
const selectedFields = ref([]);
const importInput = ref(null);

const openExportModal = () => {
    showExportModal.value = true;
};

const closeExportModal = () => {
    showExportModal.value = false;
    selectedFields.value = [];
};

const submitExport = () => {
    if (selectedFields.value.length === 0) {
        alert('Pilih setidaknya satu kolom untuk diekspor.');
        return;
    }

    router.post(
        route('excel.export'),
        { fields: selectedFields.value },
        {
            preserveScroll: true,
            onSuccess: () => {
                closeExportModal();
                alert('Proses export telah dimulai. Anda akan diberi tahu saat selesai.');
            },
        },
    );
};

const triggerImport = () => {
    importInput.value.click();
};

const handleImport = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('file', file);

    router.post(route('excel.import'), formData, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Proses import telah dimulai. Anda akan diberi tahu saat selesai.');
        },
    });
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Excel Export & Import</h2>
            <div class="flex space-x-2">
                <button @click="openExportModal" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Export</button>
                <button @click="triggerImport" class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Import</button>
            </div>
        </div>

        <!-- Export Modal -->
        <Modal v-if="showExportModal" @close="closeExportModal">
            <template #header>
                <h3 class="text-lg font-medium text-gray-900">Pilih Kolom untuk Export</h3>
            </template>
            <template #body>
                <div class="space-y-2">
                    <div v-for="field in availableFields" :key="field" class="flex items-center">
                        <input type="checkbox" :id="field" :value="field" v-model="selectedFields" class="mr-2" />
                        <label :for="field" class="text-gray-700">{{ field }}</label>
                    </div>
                </div>
            </template>
            <template #footer>
                <button @click="submitExport" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Export</button>
                <button @click="closeExportModal" class="ml-2 rounded bg-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-400">Batal</button>
            </template>
        </Modal>

        <!-- Import Input (Hidden) -->
        <input ref="importInput" type="file" accept=".xlsx, .xls, .csv" class="hidden" @change="handleImport" />
    </div>
</template>
