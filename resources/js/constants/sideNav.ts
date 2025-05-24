import { NavItem } from '@/types';
import { LayoutGrid, LucideCheckSquare, LucideFolderArchive, LucideKeyRound, LucideUsers, UserCircle2Icon } from 'lucide-vue-next';

const baseNav = [
    { title: 'Dashboard', href: '/dashboard', icon: LayoutGrid },
    { title: 'Projects', href: '/projects', icon: LucideFolderArchive },
    { title: 'Roles', href: '/roles', icon: LucideKeyRound },
    { title: 'Tasks', href: '/tasks', icon: LucideCheckSquare },
] satisfies NavItem[];

export const navItemsByRole: Record<string, NavItem[]> = {
    admin: [...baseNav, { title: 'Users', href: '/users', icon: LucideUsers }, { title: 'Clients', href: '/clients', icon: UserCircle2Icon }],

    manager: [...baseNav, { title: 'Clients', href: '/clients', icon: LucideUsers }],
};

export const defaultNavItems = baseNav;
