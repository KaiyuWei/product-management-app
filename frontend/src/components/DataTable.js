import React, {useEffect} from 'react';

const DataTable = ({ columns, data}) => {
    function getValueFromRowByColumnName(rowData, columnName) {
        return rowData[columnName.toLowerCase()];
    }

    function generateTableHeader(columnNames) {
        return columnNames.map((column, index) => (
            <th key={index} scope="col">{column}</th>
        ));
    }

    function generateTableBody(data) {
        return data.map((row, rowIndex) => (
            <tr key={rowIndex}>
                {columns.map((column, colIndex) => (
                    <td key={colIndex}>{getValueFromRowByColumnName(row, column)}</td>
                ))}
            </tr>
        ))
    }

    return (
        <table className="table">
            <thead className="thead-dark">
            <tr>
                {generateTableHeader(columns)}
            </tr>
            </thead>
            <tbody>
                {generateTableBody(data)}
            </tbody>
        </table>
    );
};

export default DataTable;