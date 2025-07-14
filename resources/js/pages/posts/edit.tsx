import React, { use, useEffect } from "react";
import { useState } from "react";
import axios from 'axios';
import { checkToken } from "@/utils/auth";
import AppLayout from "@/layouts/app-layout";
import { Card } from "@/components/ui/card";
import { Button } from '@/components/ui/button';
import Loading from '@/components/loading';
import { router } from "@inertiajs/react";
const EditPost = ({ id }: { id: number }) => {
    const [post, setPost] = useState(null);
    const [loading, setLoading] = useState(true);
    const [form, setForm] = useState({ title: '', content: '', category_name: '', status: '' });
    const [categories, setCategories] = useState<{ id: number, name: string }[]>([]);

    useEffect(() => {
        const token = checkToken();
        if (!token) return;
        axios.get('/api/categories', {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => setCategories(res.data.data));
        axios.get(`/api/posts/${id}`, {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => {
            setPost(res.data.data),
                setForm({
                    title: res.data.data.title,
                    content: res.data.data.content,
                    category_name: res.data.data.category,
                    status: res.data.data.status
                });
        }).finally(() => setLoading(false));
    }, [id]);
    const handleChange = (e: React.ChangeEvent<any>): void => {
        setForm({ ...form, [e.target.name]: e.target.value });
    }
    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        const token = localStorage.getItem('token');
        await axios.put(`/api/posts/${id}`, form, {
            headers: { Authorization: `Bearer ${token}` }
        });
        router.visit(`/posts/${id}`);
    };
    return (
        <AppLayout>
            <Card className="max-w-2xl min-w-1/2 min-h-2/3 mx-auto p-12">
                {loading && <Loading />}
                <h2 className="text-xl font-bold mb-4">Edit Post</h2>
                <form onSubmit={handleSubmit} className="flex flex-col gap-4">
                    <input
                        name="title"
                        value={form.title}
                        onChange={handleChange}
                        className="border rounded px-2 py-1"
                        placeholder="Title"
                        required
                    />
                    <textarea
                        name="content"
                        value={form.content}
                        onChange={handleChange}
                        className="border rounded px-2 py-1 h-50"
                        placeholder="Content"
                        required
                    />
                    <select
                        name="category_name"
                        value={form.category_name}
                        onChange={handleChange}
                        className="border rounded px-2 py-1"
                        required
                    >
                        <option value="">Choose category</option>
                        {categories.map(cat => (
                            <option key={cat.id} value={cat.name}>{cat.name}</option>
                        ))}
                    </select>
                    <select
                        name="status"
                        value={form.status}
                        onChange={handleChange}
                        className="border rounded px-2 py-1"
                        required
                    >
                        <option value="">Choose status</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="privated">Privated</option>
                    </select>
                    <Button type="submit">Save</Button>
                </form>
            </Card>
        </AppLayout>
    );
}

export default EditPost;