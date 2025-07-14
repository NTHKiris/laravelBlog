import { Tab } from "@headlessui/react";
import React from "react";

type TableProps = {
    columns: string[];
    data: any[]
};

function Table({ columns, data }: TableProps) {

    return (
        <table>
            <thead>
                <tr>
                    {columns.map((col, idx) => (
                        <th key={idx}>{col}</th>
                    ))}
                </tr>
            </thead>
            <tbody>
                {data.map((row, idx) => (
                    <tr key={idx}>
                        {columns.map((col, i) => (
                            <td key={i} className="border px-4 py-2">{row[col]}</td>
                        ))}
                    </tr>
                ))}
            </tbody>
        </table>
    )
}
export default Table;