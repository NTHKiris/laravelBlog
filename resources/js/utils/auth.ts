import { router } from "@inertiajs/react";

export function checkToken() {
    const token = localStorage.getItem('token');
    const expires = localStorage.getItem('token_expires');
    if (!token) {
        router.visit('/login');
        return null;
    }
    const now = new Date();
    const expiresAt = new Date(expires as string);
    if (now > expiresAt) {
        localStorage.removeItem('token');
        localStorage.removeItem('token_expires');
        router.visit('/login');
        return null;
    }
    return token;
}