import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/hooks/use-initials';
import { type User } from '@/types';
import { useEffect, useState } from 'react';
import axios from 'axios';
export function UserInfo({ showEmail = false }: { showEmail?: boolean }) {
    const [user, setUser] = useState<any>(null);
    const getInitials = useInitials();
    useEffect(() => {
        const token = localStorage.getItem('token');
        if (!token) return;
        axios.get('/api/auth/me', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        }).then(res => setUser(res.data.data))
            .catch(() => setUser(null))
    }, []);
    if (!user) return null;
    return (
        <>
            <Avatar className="h-8 w-8 overflow-hidden rounded-full">
                <AvatarImage src={user.avatar} alt={user.name} />
                <AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                    {getInitials(user.name)}
                </AvatarFallback>
            </Avatar>
            <div className="grid flex-1 text-left text-sm leading-tight">
                <span className="truncate font-medium">{user.name}</span>
                {showEmail && <span className="truncate text-xs text-muted-foreground">{user.email}</span>}
            </div>
        </>
    );
}
