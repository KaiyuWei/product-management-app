import React, {useState, useEffect, createContext, useContext} from "react";

import Modal from "../../components/Modal";
import AddProductForm from "./components/AddProductForm";
import DataTable from "../../components/DataTable";
import axios from "../../config/axios";

const DashboardContext = createContext();

export function useDashboard() {
    return useContext(DashboardContext);
}

export default function SupplierDashboard () {
    const [showModal, setShowModal] = useState(false);
    const [productData, setProductData] = useState([]);
    const columns = ['id', 'name', 'price', 'in stock', 'description']

    const openModal = () => setShowModal(true);
    const closeModal = () => setShowModal(false);

    const normalizeProductDataForDisplaying = (products) => {
        const normalized = [];

        products.map(function(row) {
            const {id, name, price, description} = row;
            const entry = {id, name, price, description};
            entry['in stock'] = row.pivot.stock_quantity;

            normalized.push(entry);
        })

        return normalized;
    }

    const fetchProducts = async () => {
        try {
            const response = await axios.get('/products');
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
        <DashboardContext.Provider value={{closeModal, fetchAndUpdateProductData}}>
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
                    data={normalizeProductDataForDisplaying(productData)}
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