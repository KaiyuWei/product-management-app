import {useEffect, useState} from "react";
import axios from "../../config/axios";
import DataTable from "../../components/DataTable";

export default function UserHome() {
    const [productData, setProductData] = useState([]);
    const columnsProductTable = ['supplier ']

    const fetchProducts = async () => {
        try {
            const response = await axios.get('/product/index');
            //@todo
        } catch (e) {
            console.error(e);
        }
    };

    // useEffect(() => {
    //     fetchProducts();
    // }, []);

    return <>
        <div>
            <DataTable
                // columns={columns}
                // data={productData}
            />
        </div>
    </>
}