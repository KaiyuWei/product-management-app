import {useAuth} from "../context/auth";
import UserHome from "./Home/UserHome";
import SupplierHome from "./Home/SupplierHome";
import { Navigate } from "react-router-dom";

export default function Home() {
    const [auth, setAuth] = useAuth();

    if (auth.role === '' && auth.userId === null) {
        return <Navigate to="/login" />;
    }

    return (
        <div>
            <h1 className="display-1 bg-primary text-light p-5">Home</h1>
            <div className="mt-2">
            {
                auth.role === 'supplier' ?
                    <SupplierHome/> :
                    <UserHome/>
            }
        </div>
        </div>
    );
}