import {useState} from "react";
import axios from "../../../config/axios";
import {toast} from "react-toastify";
import {useDashboard} from "../SupplierDashboard";

export default function AddProductForm() {
    const [name, setName] = useState('');
    const [price, setPrice] = useState(null);
    const [description, setDescription] = useState('');
    const [quantity, setQuantity] = useState('');
    const [loading, setLoading] = useState(false);
    const {closeModal, fetchProducts} = useDashboard();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        try {
            const res= await axios.post('/product', {name, price, quantity, description});

            toast.success(`Product ${name} is created`);
            closeModal();
            fetchProducts();
        } catch (err) {
            setLoading(false);
            toast.error(err.response.data.error);
        }
    }

    return <>
        <div className = "grid grid-rows-3 place-content-center gap-4" >
            <div className = "grid-cols-2" >
                <input type = "text" name = "name"
                       onChange = {(e) => setName(e.target.value)}
                       placeholder = "Product Name" />
            </div >
            <div className = "grid-cols-2" >
                <input type = "text" name = "price"
                       onChange = {(e) => setPrice(e.target.value)}
                       placeholder = "Price" />
            </div >
            <div className = "grid-cols-2" >
                <input type = "text" name = "description"
                       onChange = {(e) => setDescription(e.target.value)}
                       placeholder = "Description" />
            </div >
            <div className = "grid-cols-2" >
                <input type = "text" name = "quantity"
                       onChange = {(e) => setQuantity(e.target.value)}
                       placeholder = "Quantity" />
            </div >
        </div >
        <div className = "flex justify-end mt-4" >
            <button type = "button" className = "btn btn-primary" onClick={handleSubmit} disabled={loading}>Publish Product</button >
        </div >

    </>;
}