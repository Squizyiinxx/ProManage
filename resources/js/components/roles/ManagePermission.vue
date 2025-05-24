<script setup lang="ts">
import { RoleProps, permissionProps } from '@/types';
import { router } from '@inertiajs/vue3';
import { DialogTrigger } from 'reka-ui';
import { ref, watch } from 'vue';
import ModalDialog from '../ModalDialog.vue';
import ScrollArea from '../ScrollArea.vue';
import Input from '../ui/input/Input.vue';
import { Label } from '../ui/label';

const props = defineProps<{
    role: RoleProps;
    permissions: permissionProps[];
    title: string;
}>();

const isOpen = ref(false);
const assigned = ref<number[]>([]);

watch(
    () => props.role.permissions,
    (val) => {
        assigned.value = val ? val.map((p) => p.uuid) : [];
    },
    { immediate: true },
);

const isAssigned = (perm: permissionProps) => assigned.value.includes(perm.uuid);

const togglePermission = (perm: permissionProps) => {
    if (isAssigned(perm)) {
        assigned.value = assigned.value.filter((uuid) => uuid !== perm.uuid);
    } else {
        assigned.value.push(perm.uuid);
    }
};

const saveChanges = () => {
    router.post(
        route('roles.sync-permissions', props.role.uuid),
        {
            permissions: assigned.value,
        },
        {
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
                    @click="isOpen = true"
                    type="button"
                    aria-label="Manage Permissions"
                    class="text-primary hover:text-sidebar border-primary hover:bg-primary cursor-pointer rounded-lg border px-4 py-2 text-sm font-medium transition duration-200"
                >
                    Manage Permissions
                </button>
            </DialogTrigger>
        </template>
        <template #contentMain>
            <h2 id="content" class="mb-4 text-xl font-semibold">Manage Permissions for "{{ role.name }}"</h2>
            <div class="space-y-2 overflow-y-auto">
                <ScrollArea title="Permissions">
                    <Label
                        :for="`permissions-${perm.uuid}`"
                        v-for="perm in permissions"
                        :key="perm.uuid"
                        class="flex w-full cursor-pointer items-center justify-between border-b py-2"
                    >
                        <span class="text-foreground text-sm">{{ perm.name }}</span>
                        <Input
                            :id="`permissions-${perm.uuid}`"
                            type="checkbox"
                            :checked="isAssigned(perm)"
                            @change="() => togglePermission(perm)"
                            class="accent-primary max-w-max"
                        />
                    </Label>
                </ScrollArea>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    @click="isOpen = false"
                    class="text-muted-foreground hover:bg-muted cursor-pointer rounded-md border px-4 py-2 text-sm transition"
                >
                    Cancel
                </button>
                <button @click="saveChanges" class="bg-primary hover:bg-primary/80 cursor-pointer rounded-md px-4 py-2 text-sm text-white transition">
                    Save Changes
                </button>
            </div>
        </template>
    </ModalDialog>
</template>
