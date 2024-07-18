import {useState, useEffect} from "react";
import DataTable from "../../../components/DataTable";

export default function CustomerOrderHistory () {
    const columns = ['orderId']


    useEffect(() => {

    }, []);

    return <>
        <div className = "p-3" >
            <div className = "text-2xl" >Order History</div >
            <div >
                Order table here...In the backend, just make an query using Order model, along with its "items()" relation ship to fetch current user's orders.
            </div >
        </div >
    </>
}