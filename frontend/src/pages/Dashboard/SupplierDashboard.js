import React, {useState, createContext, useContext} from "react";

import Modal from "../../components/Modal";
import AddProductForm from "./components/AddProductForm";

const DashboardContext = createContext();

export function useDashboard() {
    return useContext(DashboardContext);
}

export default function Dashboard () {
    const [showModal, setShowModal] = useState(false);

    const openModal = () => setShowModal(true);

    const closeModal = () => setShowModal(false);

    return <>
        <DashboardContext.Provider value={{closeModal}}>
            <button type = "button" className = "btn btn-primary" onClick = {openModal} >
                Add product...
            </button >
            <Modal
                show = {showModal}
                title = "Add a product"
                onClose = {closeModal}
            >
                <div className = "p-2" >
                    <AddProductForm />
                </div >
            </Modal >
        </DashboardContext.Provider >

    </>;
}