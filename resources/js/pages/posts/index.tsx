import React, { useEffect, useState, useTransition } from 'react'
import Table from '@/components/table'
import AppLayout from '@/layouts/app-layout';
import { checkToken } from '@/utils/auth';
import { Card } from '@/components/ui/card';
import axios from 'axios';
import { router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import Loading from '@/components/loading';
type Post = {
    id: number;
    title: string;
    author: string;
    status: string;
    category: string;
};

const index = () => {
    const [currentUser, setCurrentUser] = useState(null);
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);
    const token = checkToken();
    if (!token) return;
    useEffect(() => {

        axios.get('api/auth/me', {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => setCurrentUser(res.data.data))
        axios.get('/api/all/posts', {
            headers: { Authorization: `Bearer ${token}` }
        })
            .then(response => {
                setPosts(Array.isArray(response.data.data) ? response.data.data : []);
            })
            .catch(error => {
                console.error(error);
            })
            .finally(() => setLoading(false));
    }, []);

    const handleDelete = (id: number) => {
        if (!window.confirm("Are you sure??")) return;
        const token = checkToken();
        if (!token) return;

        axios.delete(`/api/posts/${id}`, {
            headers: { Authorization: `Bearer ${token}` }
        });
        axios.get('/api/posts', {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => {
            setPosts(res.data.data);
        });
    }
    const columns = ["STT", "Title", "Author", "Status", "Category", "Action"];
    const data = posts.map((post, idx) => ({
        STT: idx + 1,
        Title: post.title,
        Author: post.author,
        Status: post.status,
        Category: post.category,
        Action: (
            <div className='flex gap-2'>
                <Button className='px-2 py-1 text-white rounded bg-blue-500' onClick={() => { router.visit(`/posts/${post.id}`) }}>View</Button>
                <Button className='px-2 py-1 text-white rounded bg-yellow-500' onClick={() => { router.visit(`posts/${post.id}/edit`) }}>Update</Button>
                <Button className='px-2 py-1 text-white rounded bg-red-500' onClick={() => { handleDelete(post.id) }}>Delete</Button>
            </div>
        )
    }))

    return (
        <AppLayout>
            <Card className='min-h-2/3'>
                <div className='max-w-7xl mx-auto p-6'>


                    {loading && <Loading />}
                    {!loading && posts.length === 0 && <div>You are not writer</div>}
                    {!loading && posts.length > 0 && (
                        <>
                            <div className='flex justify-between items-center mb-6'>
                                <h1 className='text-2xl font-bold'>Post Management</h1>
                                <Button
                                    className='bg-gray-600 hover:bg-gray-700 text-white'
                                    onClick={() => router.visit('/posts/trash')}
                                >
                                    🗑️ Trash
                                </Button>
                            </div>
                            <Table columns={columns} data={data} />
                        </>
                    )}
                </div>
            </Card>
        </AppLayout>
    )
}

export default index