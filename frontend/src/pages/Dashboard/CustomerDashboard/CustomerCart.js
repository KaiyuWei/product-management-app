import {useState, useEffect} from "react";
import axios from "../../../config/axios";
import DataTable from "../../../components/DataTable";

export default function CustomerCart() {
    const [cartData, setCartData] = useState([]);
    const columns = ['product name', 'quantity', 'total price'];

    const normalizeProductDataForDisplaying = (products) => {
        const normalized = [];

        products.map(function(row) {
            const entry = {};
            entry['product name'] = row.name;
            entry['quantity'] = row.quantity;
            entry['total price'] = row.totalPrice;

            normalized.push(entry);
        })

        return normalized;
    }

    const fetchProductsInCart = async () => {
        try {
            const response = await axios.get('/cart/products');
            setCartData(response.data);
            console.log(response.data);
        } catch(e) {
            console.log(e.message);
        }
    }

    useEffect(() => {
        fetchProductsInCart();
    }, []);

    return <>
        <div className = "p-3" >
            <div className = "text-2xl " >Products In Your Cart:</div >
            <div >
                <DataTable
                    columns = {columns}
                    data = {normalizeProductDataForDisplaying(cartData)}
                />
            </div >
            <button type = "button" className = "btn btn-primary" >Buy</button >
        </div >
    </>
}