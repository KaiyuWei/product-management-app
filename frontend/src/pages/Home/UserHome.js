import {useEffect, useState} from "react";
import axios from "../../config/axios";
import DataTable from "../../components/DataTable";
import ProductCard from "../../components/ProductCard";

export default function UserHome() {
    const [productData, setProductData] = useState([]);
    const columnsProductTable = ['supplier name', 'description', 'product name', 'price', 'publish date', 'in stock'];

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

    const generateProductCardSet = (data) => {
        return data.map((supplier) => {
             return supplier.products.map((product) => {
                return (<ProductCard
                        name = {product.name}
                        productId = {product.id}
                        price = {product.price}
                        inStock = {product.quantity}
                        description = {product.description}
                        supplierName = {supplier.supplierName}
                        supplierId = {supplier.supplierId}
                        publishDate = {product.publishDate}
                    />);
            });
        });
    }

    useEffect(() => {
        fetchAndUpdateProductData();
    }, []);

    return <>
        <div className="px-4">
            <div className="text-2xl mt-4 mb-2">
                Available products:
            </div>
            <div className="flex flex-row gap-4 flex-wrap">
                {generateProductCardSet(productData)}
            </div >
        </div >
    </>
}