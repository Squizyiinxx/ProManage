import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface PageProps {
    auth: {
        can: Record<string, boolean>;
        user: {
            id: number;
            name: string;
            email: string;
            roles: string[];
        };
    };
}

export default function usePermission() {
    const can = computed(() => (usePage().props as unknown as PageProps).auth?.can || {});

    const has = (permission: string): boolean => {
        return !!can.value[permission];
    };

    const any = (...permissions: string[]): boolean => {
        return permissions.some((permission) => has(permission));
    };

    const all = (...permissions: string[]): boolean => {
        return permissions.every((permission) => has(permission));
    };

    return { can, has, any, all };
}
