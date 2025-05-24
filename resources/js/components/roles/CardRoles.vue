<script setup lang="ts">
import { useRoleStore } from '@/stores/RoleStore';
import { RoleProps } from '@/types';
import { LockKeyhole } from 'lucide-vue-next';
import ScrollArea from '../ScrollArea.vue';
import DestroyRole from './DestroyRole.vue';
import EditRole from './EditRole.vue';
import ManagePermission from './ManagePermission.vue';

const props = defineProps<{
    role: RoleProps;
    title?: string;
    access: any;
}>();
const { permissions } = useRoleStore();

const toggleAccess = props.role.name === 'admin' || props.role.name === 'manager' || props.role.name === 'tim';
</script>

<template>
    <div
        class="bg-sidebar-foreground dark:bg-sidebar border-border relative flex w-full max-w-md flex-col justify-between rounded-2xl border p-6 shadow-md transition hover:shadow-lg"
    >
        <EditRole v-if="!toggleAccess && access('role.update')" :role="role" :title="title" />

        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-foreground text-xl font-semibold capitalize">{{ role.name }}</h2>
            <div class="flex w-32 items-center justify-end gap-2">
                <span class="bg-accent rounded-full p-2 text-slate-600" v-if="toggleAccess">
                    <LockKeyhole class="h-4 w-4" />
                </span>
                <span class="text-muted-foreground text-xs"> {{ role.permissions?.length }} Permissions </span>
            </div>
        </div>

        <div class="mb-4 h-full">
            <h3 class="text-muted-foreground mb-2 text-sm font-medium">Assigned Permissions</h3>
            <ScrollArea class="w-full gap-2">
                <div class="grid w-full grid-cols-3 gap-4">
                    <span v-for="permission in role.permissions" :key="permission.uuid" class="text-foreground w-full items-center">
                        <p class="border-foreground w-full truncate rounded-md border px-2 py-2 text-center text-xs">{{ permission.name }}</p>
                    </span>
                    <p v-if="!role.permissions?.length" class="text-muted-foreground col-span-3 w-full text-xs">No permissions assigned.</p>
                </div>
            </ScrollArea>
        </div>
        <div class="mt-6 flex items-center justify-between">
            <ManagePermission :role="role" :permissions="permissions ?? []" title="Manage Permissions" />
            <DestroyRole v-if="!toggleAccess && access('role.delete')" :title="`Role`" :role="role" />
        </div>
    </div>
</template>

<style scoped>
.text-muted-foreground {
    color: #6b7280;
}
</style>
