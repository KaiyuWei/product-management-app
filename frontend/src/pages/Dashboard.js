import {useAuth} from "../context/auth";
import SupplierDashboard from "./Dashboard/SupplierDashboard";

export default function Dashboard () {
    const [auth, setAuth] = useAuth();

    return auth.role === 'supplier' ?
        <SupplierDashboard/> :
        <>
            <div>Customer</div>
        </>;
}