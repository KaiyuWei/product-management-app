import {useState, useEffect} from "react";
import axios from "../../../config/axios";
import DataTable from "../../../components/DataTable";
import {toast} from "react-toastify";

export default function CustomerCart() {
    const [cartData, setCartData] = useState([]);
    const [totalPrice, setTotalPrice] = useState(0);
    const columns = ['product name', 'quantity', 'total price'];

    const normalizeProductDataForDisplaying = (products) => {
        return products.map((row) => ({
            'product name': row.productName,
            'quantity': row.quantity,
            'total price': row.totalPrice,
        }));
    }

    const fetchProductsInCart = async () => {
        try {
            const response = await axios.get('/cart/products');
            return response.data;
        } catch(e) {
            console.log(e.message);
        }
    }

    const fetchAndSetCartData = async () => {
        const data = await fetchProductsInCart();
        setCartData(data);
    }

    const buyProductsInCart = async () => {
        try {
            const response = await axios.post('/order/buy', cartData);
            toast.success("Congradulations!");
            fetchAndSetCartData();
        }catch(e) {
            toast.error(e.response);
        }
    }

    useEffect(() => {
        fetchAndSetCartData();
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
            <button type = "button" className = "btn btn-primary" onClick={buyProductsInCart} >Buy</button >
        </div >
    </>
}