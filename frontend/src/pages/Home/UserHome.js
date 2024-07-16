import {useEffect, useState} from "react";
import axios from "../../config/axios";
import DataTable from "../../components/DataTable";

export default function UserHome() {
    const [productData, setProductData] = useState([]);
    const columnsProductTable = ['supplier name', 'description', 'product name', 'price', 'publish date', 'in stock'];

    const normalizeProductDataForDisplay = (data) => {
        const normalized = [];

        data.map((supplier) => {
            supplier.products.map((product) => {
                const entry = [];
                entry['supplier name'] = supplier.supplierName;
                entry['description'] = product.description;
                entry['product name'] = product.name;
                entry['price'] = product.price;
                entry['publish date'] = product.publishDate;
                entry['in stock'] = product.quantity;

                normalized.push(entry);
            });
        });

        return normalized;
    }

    const fetchProducts = async () => {
        try {
            const response = await axios.get('/product/index');
            return response.data;
        } catch (e) {
            console.error(e);
        }
    };

    const fetchAndUpdateProductData = async () => {
        const products = await fetchProducts();
        setProductData(products);
    };

    useEffect(() => {
        fetchAndUpdateProductData();
    }, []);

    return <>
        <div className="px-4">
            <div className="text-2xl mt-4 mb-2">
                Available products:
            </div>
            <div >
                <DataTable
                    columns = {columnsProductTable}
                    data = {normalizeProductDataForDisplay(productData)}
                />
            </div >
        </div >

    </>
}