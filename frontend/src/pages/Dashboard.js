import {useAuth} from "../context/auth";
import SupplierDashboard from "./Dashboard/SupplierDashboard";
import CustomerDashboard from "./Dashboard/CustomerDashboard";

export default function Dashboard () {
    const [auth, setAuth] = useAuth();

    return (<div className="mt-2">
        {
            auth.role === 'supplier' ?
            <SupplierDashboard/> :
            <CustomerDashboard/>
        }
    </div>);

}