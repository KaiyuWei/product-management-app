import React, {useEffect} from 'react';

const DataTable = ({ columns, data}) => {
    function getValueFromRowByColumnName(rowData, columnName) {
        return rowData[columnName.toLowerCase()];
    }

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
                        <td key={colIndex}>{getValueFromRowByColumnName(row, column)}</td>
                    ))}
                </tr>
            ))}
            </tbody>
        </table>
    );
};

export default DataTable;