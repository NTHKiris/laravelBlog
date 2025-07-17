import React, { useEffect, useState } from 'react'
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

const Trash = () => {
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);

    // Check authentication immediately
    const token = checkToken();
    if (!token) return null;

    useEffect(() => {
        fetchTrashPosts();
    }, []);

    const fetchTrashPosts = () => {
        setLoading(true);
        axios.get('/api/posts/trash', {
            headers: { Authorization: `Bearer ${token}` }
        })
            .then(response => {
                setPosts(Array.isArray(response.data.data) ? response.data.data : []);
            })
            .catch(error => {
                console.error('Error fetching trash posts:', error);
                if (error.response?.status === 403) {
                    alert('You do not have permission to view trash');
                }
            })
            .finally(() => setLoading(false));
    };

    const handleRestore = (id: number) => {
        if (!window.confirm("Are you sure you want to restore this post?")) return;

        axios.post(`/api/posts/${id}/restore`, {}, {
            headers: { Authorization: `Bearer ${token}` }
        })
            .then(() => {
                alert('Post restored successfully!');
                fetchTrashPosts();
            })
            .catch(error => {
                console.error('Error restoring post:', error);
                alert('Failed to restore post');
            });
    };

    const handleForceDelete = (id: number) => {
        if (!window.confirm("Are you sure you want to permanently delete this post? This action cannot be undone!")) return;

        axios.delete(`/api/posts/${id}/force`, {
            headers: { Authorization: `Bearer ${token}` }
        })
            .then(() => {
                alert('Post permanently deleted!');
                fetchTrashPosts(); // Refresh the list
            })
            .catch(error => {
                console.error('Error force deleting post:', error);
                alert('Failed to delete post permanently');
            });
    };

    const columns = ["STT", "Title", "Author", "Status", "Category", "Action"];
    const data = posts.map((post, idx) => ({
        STT: idx + 1,
        Title: post.title,
        Author: post.author,
        Status: post.status,
        Category: post.category,
        Action: (
            <div className='flex gap-2'>
                <Button
                    className='px-2 py-1 text-white rounded bg-green-500 hover:bg-green-600'
                    onClick={() => handleRestore(post.id)}
                >
                    Restore
                </Button>
                <Button
                    className='px-2 py-1 text-white rounded bg-red-600 hover:bg-red-700'
                    onClick={() => handleForceDelete(post.id)}
                >
                    Delete Forever
                </Button>
            </div>
        )
    }));

    return (
        <AppLayout>
            <Card className='min-h-2/3'>
                <div className='max-w-7xl mx-auto p-6'>


                    {loading && <Loading />}

                    {!loading && posts.length === 0 && (
                        <div className='text-center py-8'>
                            <p className='text-gray-500 text-lg'>No deleted posts found</p>
                            <p className='text-gray-400 text-sm mt-2'>Deleted posts will appear here</p>
                        </div>
                    )}

                    {!loading && posts.length > 0 && (
                        <>

                            <div className='flex justify-between items-center mb-6'>
                                <h1 className='text-2xl font-bold'>🗑️ Trash - Deleted Posts</h1>
                                <Button
                                    className='bg-blue-600 hover:bg-blue-700 text-white'
                                    onClick={() => router.visit('/posts')}
                                >
                                    ← Back to Posts
                                </Button>
                            </div>
                            <Table columns={columns} data={data} />
                        </>
                    )}
                </div>
            </Card>
        </AppLayout>
    );
};

export default Trash;