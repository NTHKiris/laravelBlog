import React from 'react';

export default function Loading() {
    return (
        <div className="flex flex-col items-center justify-center py-12">
            <div className="relative w-12 h-12 mb-4">
                <div className="absolute inset-0 rounded-full border-4 border-blue-400 border-t-transparent animate-spin"></div>
                <div className="abolute inset-2 rounded-full bg-blue-100"></div>
            </div>
            <span className="text-blue-500 font-semibold text-lg tracking-wide">Đang tải dữ liệu...</span>
        </div>
    );
}