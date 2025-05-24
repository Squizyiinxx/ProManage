<script setup lang="ts">
import CardRoles from '@/components/roles/CardRoles.vue';
import CreateRole from '@/components/roles/CreateRole.vue';
import usePermission from '@/composables/usePermission';
import AppLayout from '@/layouts/AppLayout.vue';
import { useRoleStore } from '@/stores/RoleStore';
import { Pagination, permissionProps, RoleProps } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';

interface Props {
    roles: Pagination<RoleProps[]>;
    permissions: permissionProps[];
}
const { has } = usePermission();

const props = defineProps<Props>();
const store = useRoleStore();

onMounted(() => {
    store.setRole(props.roles);
    store.setPermission(props.permissions);
});

watch(
    () => props.roles,
    (updated) => {
        store.setRole(updated);
    },
);
</script>

<template>
    <Head title="Roles" />

    <AppLayout>
        <section class="container mx-auto space-y-6 px-4 py-6 md:px-8">
            <div class="flex flex-col items-start justify-between gap-5 md:flex-row md:items-center">
                <div>
                    <h1 class="text-primary text-2xl font-bold">Role Management</h1>
                    <p class="text-muted-foreground mt-1 text-sm">Manage access by assigning permissions to roles.</p>
                </div>
                <CreateRole v-if="has('role.create')" title="New Role" />
            </div>
            <div class="my-3 flex items-center justify-end">
                <Link
                    :href="route('roles.history')"
                    class="text-primary group flex items-center gap-x-2 hover:underline"
                    aria-label="Back to dashboard"
                >
                    View History
                    <ArrowRight class="h-4 w-4 duration-500 ease-in-out group-hover:translate-x-1.5" />
                </Link>
            </div>
            <div class="grid w-full grid-cols-1 items-center justify-center gap-6 md:grid-cols-2 xl:grid-cols-3">
                <CardRoles
                    v-for="role in (store.roles?.data as RoleProps[]) || []"
                    :key="role.uuid"
                    :role="role"
                    :title="`Role: ${role.name}`"
                    :access="has"
                />
            </div>
        </section>
    </AppLayout>
</template>
