import React, {useState, useEffect, createContext, useContext} from "react";

import Modal from "../../components/Modal";
import AddProductForm from "./components/AddProductForm";
import DataTable from "../../components/DataTable";
import axios from "../../config/axios";

const DashboardContext = createContext();

export function useDashboard() {
    return useContext(DashboardContext);
}

export default function Dashboard () {
    const [showModal, setShowModal] = useState(false);
    const [data, setData] = useState([]);
    const columns = ['id', 'name', 'price', 'in stock', 'description']

    const openModal = () => setShowModal(true);
    const closeModal = () => setShowModal(false);

    const fetchProducts = async () => {
        try {
            const response = await axios.get('/product/index');
            setData(response.data);
        } catch (e) {
            console.error(e);
        }
    };

    useEffect(() => {
        fetchProducts();
    }, []);

    return <>
        <DashboardContext.Provider value={{closeModal, fetchProducts}}>
            <div className="py-4 bg-blue-300">
                <button type = "button" className = "btn btn-primary mx-3" onClick = {openModal} >
                    Add product...
                </button >
            </div >
            <div className="p-5">
                <div className="text-2xl py-3">
                    All products published
                </div>
                <DataTable
                    columns={columns}
                    data={data}
                />
            </div>


            <Modal
                show = {showModal}
                title = "Add a product"
                onClose = {closeModal}
            >
                <div className = "p-2" >
                    <AddProductForm/>
                </div >
            </Modal >
        </DashboardContext.Provider >
    </>;
}