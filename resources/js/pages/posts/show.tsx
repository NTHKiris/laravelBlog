import AppLayout from "@/layouts/app-layout";
import { Head } from "@inertiajs/react";
import { Card, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { useEffect, useState } from "react";
import axios from 'axios';
import { send } from "process";
import Loading from "@/components/loading";
export default function ShowPost({ id }: { id: number }) {
    const [post, setPost] = useState<any>(null)
    const [comments, setComments] = useState<any[]>([]);
    const [loading, setLoading] = useState(true);
    const [commentContent, setCommentContent] = useState('');
    const [sending, setSending] = useState(false);
    const [currentUser, setCurrentUser] = useState<any>(null);

    useEffect(() => {
        const token = localStorage.getItem('token');
        setLoading(true);
        axios.get(`/api/posts/${id}`, {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => setPost(res.data.data));
        axios.get(`/api/posts/${id}/comments`, {
            headers: { Authorization: `Bearer ${token}` }
        }).then(res => setComments(res.data.data))
            .finally(() => setLoading(false));
        if (token) {
            axios.get('/api/auth/me', {
                headers: { Authorization: `Bearer ${token}` }
            }).then(res => setCurrentUser(res.data.data))
                .catch(() => setCurrentUser(null));
        } else {
            setCurrentUser(null);
        }


    }, [id]);

    const handleComment = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!commentContent.trim()) return;
        setSending(true);
        const token = localStorage.getItem('token');
        await axios.post('/api/comments', {
            content: commentContent,
            post_id: id,
        }, { headers: { Authorization: `Bearer ${token}` } }
        );
        setCommentContent('');
        const res = await axios.get(`/api/posts/${id}/comments`, {
            headers: { Authorization: `Bearer ${token}` }
        });
        setComments(res.data.data);
        setSending(false);
    }
    const handleDeleteComment = async (commentId: number) => {
        if (!window.confirm("Are you sure???")) return;
        const token = localStorage.getItem('token');
        await axios.delete(`/api/comments/${commentId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        const res = await axios.get(`/api/posts/${id}/comments`, {
            headers: { Authorization: `Bearer ${token}` }
        });
        setComments(res.data.data);
    };
    if (loading) return <AppLayout><Loading /></AppLayout>;
    if (!post) return <AppLayout><div>Không tìm thấy bài viết.</div></AppLayout>;
    return (
        <AppLayout>
            {/* <Head title={post.title} /> */}
            <div className="py-8">
                <Card className="max-w-5xl mx-auto shadow-none border-none">
                    <img
                        src={`https://picsum.photos/seed/${post.id}/600/300`}
                        alt={post.title}
                        className="rounded-lg"
                    />
                    <CardHeader>
                        <CardTitle>{post.title}</CardTitle>
                        <div>
                            <span>{post.author}</span>
                            <span> | </span>
                            <span>{post.created_at}</span>
                            <span> | </span>
                            <span> {post.category}</span>
                        </div>
                    </CardHeader>
                    <CardHeader>
                        <div className="">{post.content}</div>
                    </CardHeader>
                </Card>

                <div className="max-w-2xl mx-auto p-4" >
                    <h2 className=" mb-2">Bình luận</h2>
                    <form onSubmit={handleComment} className="flex gap-2 mb-4">
                        <input
                            className="flex-1 border rounded px-2 py-1"
                            placeholder="Viết bình luận..."
                            value={commentContent}
                            onChange={e => setCommentContent(e.target.value)}
                            disabled={sending}
                        />
                        <Button type="submit" disabled={sending || !commentContent.trim()}>Gửi</Button>
                    </form>
                    <div className="flex flex-col ">
                        {comments.length === 0 && <div>Chưa có bình luận nào.</div>}
                        {comments.map((cmt) => (
                            <div key={cmt.id} className="border-b pb-2 flex justify-between items-center">
                                <div>
                                    <div className="font-semibold">{cmt.user?.name || cmt.user}</div>
                                    <div className="text-sm">{cmt.content}</div>
                                    <div className="text-xs text-neutral-400">{new Date(cmt.comment_at || cmt.created_at).toLocaleString()}</div>
                                </div>
                                {currentUser?.role === "admin" && (
                                    <Button
                                        variant="destructive"
                                        size="sm"
                                        onClick={() => handleDeleteComment(cmt.id)}
                                    >
                                        Xóa
                                    </Button >
                                )}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}