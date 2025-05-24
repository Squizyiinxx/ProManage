<script setup lang="ts">
import usePermission from '@/composables/usePermission';
import { useUserStore } from '@/stores/UserStore';
import { Link } from '@inertiajs/vue3';
import { CheckCircle, EyeIcon, XCircle } from 'lucide-vue-next';
import TableComponent from '../table/TableComponent.vue';
import TdComponent from '../table/TdComponent.vue';
import ThComponent from '../table/ThComponent.vue';
import DestroyUser from './DestroyUser.vue';
import EditUser from './EditUser.vue';
const store = useUserStore();

const { has } = usePermission();
</script>

<template>
    <TableComponent :datas="store.users?.data || []">
        <template #header>
            <ThComponent field="id" title="ID" />
            <ThComponent
                field="name"
                title="Username"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('name')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="email" title="Email" />
            <ThComponent field="roles" title="Roles" />
            <ThComponent
                field="is_active"
                title="Active"
                :sortBy="store.sortBy"
                :sortDirection="store.sortOrder"
                @click="store.toggleSort('is_active')"
                classProps="cursor-pointer hover:text-primary hover:bg-gray-100"
            />
            <ThComponent field="actions" title="Actions" classProps="text-right" />
        </template>

        <template #row="{ row }">
            <TdComponent :label="row.id" />
            <TdComponent :label="row.name" />
            <TdComponent :label="row.email" />
            <TdComponent :label="row.role?.name" />
            <TdComponent>
                <template #label>
                    <span :class="row.is_active ? 'text-green-500' : 'text-red-500'">
                        <CheckCircle class="h-4 w-4" v-if="row.is_active" />
                        <XCircle class="h-4 w-4" v-else />
                    </span>
                </template>
            </TdComponent>
            <TdComponent>
                <template #label>
                    <div class="flex h-full gap-2 text-right text-sm whitespace-nowrap">
                        <Link :href="route('users.show', row.id)" class="flex cursor-pointer items-center">
                            <EyeIcon class="mr-2 h-5 w-5 text-slate-600" />
                        </Link>
                        <EditUser v-if="has('user.update')" title="Edit User" :user="row" />
                        <DestroyUser v-if="has('user.delete')" title="User" :user="row" />
                    </div>
                </template>
            </TdComponent>
        </template>
    </TableComponent>
</template>

<style lang="css" scoped>
.line-clamp-2 {
    display: -webkit-box;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
