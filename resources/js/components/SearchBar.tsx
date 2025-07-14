import React from "react";

interface SearchBarProps {
    value: string;
    onChange: (value: string) => void;
}

export default function SearchBar({ value, onChange }: SearchBarProps) {
    return (
        <input type="text"
            className="border rounded px-3 py-2 w-full mb-4"
            placeholder="Search posts"
            value={value}
            onChange={e => onChange(e.target.value)} />
    );
}