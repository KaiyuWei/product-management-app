import React, {useEffect} from 'react';

const DataTable = ({ columns, data }) => {
    const getValueForColumn = (columnName, rowData) => {

        console.log(columnName);
        if (columnName === 'in stock') {
            return rowData.pivot.stock_quantity;
        }
        else return rowData[columnName.toLowerCase()];
    }

    useEffect(() => {
        console.log(columns);
        console.log(data);
    }, []);

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
                        <td key={colIndex}>{getValueForColumn(column, row)}</td>
                    ))}
                </tr>
            ))}
            </tbody>
        </table>
    );
};

export default DataTable;