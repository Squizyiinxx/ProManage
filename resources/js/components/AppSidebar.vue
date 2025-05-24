<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import { defaultNavItems, navItemsByRole } from '@/constants/sideNav';
import { RoleProps, SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<SharedData>();
const role = page.props.auth.role as RoleProps;
const { state } = useSidebar();

const mainNavItems = computed(() => navItemsByRole[role.name ?? 'tim'] || defaultNavItems);
const logo = computed(() => (state.value === 'collapsed' ? '/assets/logoPro.png' : '/assets/logo.webp'));
</script>
<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child class="h-20">
                        <img :src="logo" class="w-full object-cover" alt="Promanage Logo" />
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser class="cursor-pointer" />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
