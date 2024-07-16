import React from 'react';

const DataTable = ({ columns, data }) => {
    return (
        <table className="table">
            <thead className="thead-dark">
            <tr>
                {columns.map((column, index) => (
                    <th key={index} scope="col">{column}</th>
                ))}
            </tr>
            </thead>
            <tbody>
            {data.map((row, rowIndex) => (
                <tr key={rowIndex}>
                    {columns.map((column, colIndex) => (
                        <td key={colIndex}>{row[column.toLowerCase()]}</td>
                    ))}
                </tr>
            ))}
            </tbody>
        </table>
    );
};

export default DataTable;