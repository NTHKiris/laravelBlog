import { use, useEffect, useState } from 'react';
import AppLayout from '@/layouts/app-layout';
import { Head, router } from '@inertiajs/react';
import axios from 'axios';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import Loading from '@/components/loading';
import { Button } from '@/components/ui/button';
import SearchBar from "@/components/SearchBar";
export default function Dashboard() {
    const [posts, setPosts] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState("");

    useEffect(() => {
        const token = localStorage.getItem('token');
        const expires = localStorage.getItem('token_expires');
        if (!token) {
            router.visit('/login');
            return;
        }
        const now = new Date();
        const expiresAt = new Date(expires as string);
        if (now > expiresAt) {
            localStorage.removeItem('token');
            localStorage.removeItem('token_expires');
            router.visit('/login');
            return;
        }
        axios.get('/api/posts', {
            headers: { Authorization: `Bearer ${token}` }
        })
            .then(res => setPosts(res.data.data || res.data))
            .finally(() => setLoading(false));
    }, []);

    const publishedPost = posts.filter(post => post.status === 'published');

    const filteredPosts = publishedPost.filter(post => post.title.toLowerCase().includes(search.toLowerCase()));

    const handleView = (id: number) => {
        router.visit(`/posts/${id}`);
    }
    return (
        <AppLayout>
            {/* <Head title="Dashboard" /> */}

            <div className="max-w-6xl mx-auto flex gap-8 py-8">
                <div className="flex-1 flex flex-col gap-6 w-6xl">
                    <SearchBar value={search} onChange={setSearch} />
                    {loading && <Loading />}
                    {!loading && filteredPosts.length === 0 && <div>No posts to display</div>}
                    {filteredPosts.map((post) => (
                        <Card key={post.id} className="">
                            <img
                                src={
                                    post.thumpnail && post.thumpnail.path
                                        ? `/storage/${post.thumpnail.path}`
                                        : `https://picsum.photos/seed/${post.id}/600/300`
                                }
                                alt={post.title}
                                className="w-full h-full "
                            />
                            <CardHeader>
                                <CardTitle>{post.title}</CardTitle>
                                <div className="text-xs text-neutral-500">
                                    <span className="font-semibold">{post.user?.name || post.author}</span>
                                    <span> | </span>
                                    <span>{new Date(post.created_at).toLocaleDateString()}</span>
                                    <span> | </span>
                                    <span className="italic">{post.category}</span>
                                </div>
                            </CardHeader>
                            <CardContent className='flex flex-col items-end'>
                                <p className=" text-neutral-700 w-full ">{post.content}</p>
                                <Button
                                    onClick={() => handleView(post.id)}
                                    className='mt-4'
                                >
                                    View Details
                                </Button>
                            </CardContent>
                        </Card>
                    ))}
                </div>

            </div>
        </AppLayout>
    );
}