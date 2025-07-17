import { checkToken } from '@/utils/auth';
import React, { useEffect, useState } from 'react';
import axios from 'axios';
import AppLayout from '@/layouts/app-layout';
import { Card } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import Loading from '@/components/loading';


type User = {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    role: string;
    posts_count: number;
    comments_count: number;
};

const Index = () => {
    const [users, setUsers] = useState<User[]>([]);
    const [loading, setLoading] = useState(true);
    const [currentUser, setCurrentUser] = useState<User | null>(null)
    const token = checkToken();
    if (!token) return;
    useEffect(() => {


        axios.get('/api/users', {
            headers: { Authorization: `Bearer ${token}` }
        })
            .then(res => setUsers(res.data.data))
            .finally(() => setLoading(false));

    }, []);

    const handleDelete = async (id: number) => {
        if (!window.confirm("Are you sure???")) return;
        const token = checkToken();

        if (!token) return;
        axios.delete(`/api/users/${id}`, {
            headers: { Authorization: `Bearer ${token}` }
        })
        const res = await axios.get('/api/users', {
            headers: { Authorization: `Bearer ${token}` }
        });
        setUsers(res.data.data);
    }

    const handleBanUnBan = async (id: number, currentRole: string) => {
        const token = checkToken();
        const newRole = currentRole === "banned" ? "reader" : "banned";
        if (!token) return;
        await axios.put(`/api/users/${id}`, {
            role: newRole
        }, {
            headers: { Authorization: `Bearer ${token}` }
        });
        setUsers(users.map(user => user.id === id ? { ...user, role: newRole } : user));
    }

    return (
        <>

            <AppLayout>
                <Card className="min-h-2/3">

                    <div className="max-w-7xl mx-auto">
                        {loading && <Loading />}
                        {!loading && users.length === 0 && <div>You are not admin</div>}
                        <table className="w-full ">
                            {(!loading && users.length > 0) && (
                                <thead>
                                    <tr>
                                        <th className='border px-4 py-2'>STT</th>
                                        {/* <th className="border px-4 py-2">ID</th> */}
                                        <th className="border px-4 py-2">Name</th>
                                        <th className="border px-4 py-2">Email</th>
                                        <th className="border px-4 py-2">Email Verified At</th>
                                        <th className="border px-4 py-2">Role</th>
                                        <th className="border px-4 py-2">Number Of Posts</th>
                                        <th className="border px-4 py-2">Number Of Comments</th>
                                        <th className="border px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                            )}
                            <tbody>
                                {users.map((user) => (
                                    <tr key={user.id} className="hover:bg-gray-50">
                                        <td className="border px-4 py-2">{users.indexOf(user) + 1}</td>
                                        {/* <td className="border px-4 py-2">{user.id}</td> */}
                                        <td className="border px-4 py-2">{user.name}</td>
                                        <td className="border px-4 py-2">{user.email}</td>
                                        <td className="border px-4 py-2">
                                            {user.email_verified_at && user.email_verified_at !== 'Not Verify'
                                                ? new Date(user.email_verified_at).toLocaleDateString()
                                                : user.email_verified_at}
                                        </td>
                                        <td className="border px-4 py-2">{user.role}</td>
                                        <td className="border px-4 py-2">{user.posts_count}</td>
                                        <td className="border px-4 py-2">{user.comments_count}</td>
                                        <td className="border px-4 py-2 ">
                                            <div className='flex gap-2'>
                                                <Button size="sm" variant="destructive" onClick={() => handleDelete(user.id)} >
                                                    Delete
                                                </Button>
                                                {/* <Button size="sm" className='bg-blue-700'>
                                            Edit
                                        </Button> */}
                                                <Button size="sm" onClick={() => handleBanUnBan(user.id, user.role)}>
                                                    {user.role === "banned" ? "Unban" : "Ban"}
                                                </Button>
                                            </div>

                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </Card>
            </AppLayout>
        </>);
};

export default Index;