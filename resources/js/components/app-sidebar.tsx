import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BookOpen, Folder, LayoutGrid, Users } from 'lucide-react';
import AppLogo from './app-logo';
import { useEffect, useState } from 'react';
import axios from 'axios';

const allNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Manage User',
        href: '/users',
        icon: Users,
        roles: ['admin'],
    },
    {
        title: 'Manage Posts',
        href: '/posts',
        icon: Folder,
        roles: ['admin', 'writer'],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    const [userRole, setUserRole] = useState<string>('');
    const [filteredNavItems, setFilteredNavItems] = useState<NavItem[]>([]);

    useEffect(() => {
        const fetchUserRole = async () => {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    setFilteredNavItems([allNavItems[0]]); // Only dashboard
                    return;
                }

                const response = await axios.get('/api/user', {
                    headers: { Authorization: `Bearer ${token}` }
                });


                let role = '';
                if (response.data.role?.slug) {
                    role = response.data.role.slug;
                } else if (response.data.role?.name) {
                    role = response.data.role.name.toLowerCase();
                } else if (response.data.role_id) {
                    const roleMap: { [key: number]: string } = {
                        1: 'admin',
                        2: 'writer',
                        3: 'reader',
                        4: 'banned'
                    };
                    role = roleMap[response.data.role_id] || '';
                }

                setUserRole(role);


                let filtered: NavItem[] = [];

                if (role.toLowerCase() === 'admin') {

                    filtered = allNavItems;
                } else if (role.toLowerCase() === 'writer') {
                    filtered = allNavItems.filter(item =>
                        !item.roles || item.roles.includes('writer')
                    );
                } else {
                    filtered = [allNavItems[0]];
                }

                setFilteredNavItems(filtered);

            } catch (error) {
                console.error('Error fetching user role:', error);
                setFilteredNavItems(allNavItems);
            }
        };

        fetchUserRole();
    }, []);

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={filteredNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
