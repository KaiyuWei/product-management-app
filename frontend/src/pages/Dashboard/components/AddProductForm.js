import {useState} from "react";

export default function AddProductForm() {
    const [name, setName] = useState('');
    const [price, setPrice] = useState(null);
    const [description, setDescription] = useState('');

    const handleSubmit = () => {

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
        </div >
        <div className = "flex justify-end mt-4" >
            <button type = "button" className = "btn btn-primary" onSubmit={handleSubmit} >Save Changes</button >
        </div >

    </>;
}