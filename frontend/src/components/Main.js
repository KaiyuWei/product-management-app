import {NavLink, useNavigate} from "react-router-dom";
import {useAuth} from "../context/auth";
import axios from "../config/axios";
import {toast} from "react-toastify";

export default function Main() {

    const [auth, setAuth] = useAuth();
    const navigate = useNavigate();

    const logout = async function() {
        try{
            const response = await axios.post('/logout');

            setAuth({
                userId: null,
                role: '',
            });
            navigate('/login');
        } catch(e) {
            toast.error(e.message);
        }

    }

    return (
        <nav className="nav flex-1 justify-end leading-6">
            <NavLink className="nav-link" aria-current="page" to="/">Home</NavLink>
            <NavLink className="nav-link" to="/login">Login</NavLink>
            <NavLink className="nav-link" to="/register">Register</NavLink>

            <div className="dropdown">
                <a className="nav-link dropdown-toggle cursor-pointer" data-toggle="dropdown">User</a>
                <ul className="dropdown-menu">
                    <li>
                        <NavLink className="nav-link" to="/dashboard">Dashboard</NavLink>
                        <a className="nav-link cursor-pointer" onClick={logout}>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    );
}