import React, {useState, createContext, useContext} from "react";

import Modal from "../../components/Modal";
import AddProductForm from "./components/AddProductForm";
import DataTable from "../../components/DataTable";

const DashboardContext = createContext();

export function useDashboard() {
    return useContext(DashboardContext);
}

export default function Dashboard () {
    const [showModal, setShowModal] = useState(false);

    const openModal = () => setShowModal(true);
    const closeModal = () => setShowModal(false);

    const columns = ['name', 'age'];
    const data = [{name:'Tom', age:23}, {name:'jerry', age:22}];

    return <>
        <DashboardContext.Provider value={{closeModal}}>
            <div >
                <button type = "button" className = "btn btn-primary" onClick = {openModal} >
                    Add product...
                </button >
            </div >
            <div>
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