import {useAuth} from "../context/auth";
import UserHome from "./Home/UserHome";

export default function Home() {
    const [auth, setAuth] = useAuth();

    return (
        <div>
            <h1 className="display-1 bg-primary text-light p-5">Home</h1>
            <div className="mt-2">
            {
                auth.role === 'supplier' ?
                    <div>supplier</div> :
                    <UserHome/>
            }
        </div>
        </div>
    );
}