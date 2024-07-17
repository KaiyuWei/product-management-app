import React, {useState, useEffect, createContext, useContext} from "react";
import axios from "../../config/axios";

import Tabs from "../../components/DashboardTabs";
import CustomerCart from "./CustomerDashboard/CustomerCart";
import CustomerOrderHistory from "./CustomerDashboard/CustomerOrderHistory";




const DashboardContext = createContext();

export function useDashboard() {
    return useContext(DashboardContext);
}

export default function CustomerDashboard () {
    const [showModal, setShowModal] = useState(false);
    const [data, setData] = useState([]);
    const columns = ['id', 'name', 'price', 'in stock', 'description']

    const openModal = () => setShowModal(true);
    const closeModal = () => setShowModal(false);

    const tabs = {
        Cart: CustomerCart(),
        Orders: CustomerOrderHistory(),
    };

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
        <DashboardContext.Provider value = {{closeModal, fetchProducts}} >
            <Tabs tabs={tabs}/>
        </DashboardContext.Provider >
    </>;
}