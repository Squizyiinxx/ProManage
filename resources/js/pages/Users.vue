<script setup lang="ts">
import PaginationTable from '@/components/table/PaginationTable.vue';
import CreateUser from '@/components/user/CreateUser.vue';
import UserFilters from '@/components/user/UserFilters.vue';
import UserTable from '@/components/user/UserTable.vue';
import usePermission from '@/composables/usePermission';
import AppLayout from '@/layouts/AppLayout.vue';
import { useUserStore } from '@/stores/UserStore';
import { Filters, Pagination, RoleProps, User } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, DownloadCloud } from 'lucide-vue-next';
import { onMounted, watch } from 'vue';
interface Props {
    users: Pagination<User<RoleProps>[]>;
    role: RoleProps[];
    filters: Filters;
    file: any;
}
const props = defineProps<Props>();
const store = useUserStore();
const { has } = usePermission();

onMounted(() => {
    store.setUser(props.users);
    store.setRole(props.role);
    store.setFilters(props.filters);
});
watch(
    () => props.users,
    (newProjects) => {
        store.setUser(newProjects);
    },
    { immediate: true },
);
</script>

<template>
    <Head title="User" />
    <AppLayout>
        <div class="container mx-auto p-4 md:p-8">
            <div class="mb-8 flex flex-col items-center justify-between gap-5 md:flex-row">
                <div class="text-center md:text-left">
                    <h1 class="text-primary text-2xl font-bold">User Management</h1>
                    <p class="text-foreground mt-1 text-sm">Manage and track users</p>
                </div>
                <CreateUser v-if="has('user.create')" title="Add User" />
            </div>
            <div class="my-3 flex items-center justify-end">
                <Link
                    :href="route('users.history')"
                    class="text-primary group flex items-center gap-x-2 hover:underline"
                    aria-label="Back to dashboard"
                >
                    View History <ArrowRight class="h-4 w-4 duration-500 ease-in-out group-hover:translate-x-1.5" />
                </Link>
            </div>
            <UserFilters />
            <UserTable />
            <PaginationTable :pagination="store.users" />
            <div class="my-6 flex items-center justify-between">
                <div class="min-w-0">
                    <PaginationTable :pagination="store.users" />
                </div>
                <div class="ml-auto">
                    <a
                        v-if="file"
                        target="_blank"
                        rel="noopener"
                        :href="route('download.export', file.id)"
                        class="bg-primary-foreground text-primary hover:bg-accent flex cursor-pointer items-center rounded-lg px-4 py-2 shadow-lg transition-colors duration-300 ease-in-out"
                    >
                        <DownloadCloud class="mr-2 h-4 w-4" /> Download Export
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
