import React, {useState, useEffect, createContext, useContext} from "react";
import axios from "../../config/axios";

import Modal from "../../components/Modal";
import DataTable from "../../components/DataTable";
import Tabs from "../../components/DashboardTabs";
import {findAllByDisplayValue} from "@testing-library/react";
import UserCart from "./components/UserCart";
import UserOrderHistory from "./components/UserOrderHistory";




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
        Cart: UserCart(),
        Orders: UserOrderHistory(),
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