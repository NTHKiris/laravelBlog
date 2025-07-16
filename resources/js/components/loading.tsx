import React from 'react';

export default function Loading() {
    return (
        <div className="flex flex-col items-center justify-center py-12">
            <div className="h-12 w-12 animate-spin rounded-full border-4 border-blue-500 border-t-transparent" />
            <span className="mt-4 text-lg">Đang tải dữ liệu...</span>
        </div>
    );
}