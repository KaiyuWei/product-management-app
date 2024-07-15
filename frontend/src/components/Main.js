import {NavLink, useNavigate} from "react-router-dom";
import {useAuth} from "../context/auth";
import axios from "../config/axios";
import {toast} from "react-toastify";

export default function Main() {

    const [auth, setAuth] = useAuth();
    const navigate = useNavigate();
    const loggedIn = auth.userId && auth.role;

    const logout = async function() {
        try{
            await axios.post('/logout');

            setAuth({
                userId: null,
                role: '',
            });
            localStorage.removeItem('auth');

            toast.info('User logged out');
            navigate('/login');
        } catch(e) {
            console.log(e.message);
            toast.error('something went wrong');
        }

    }

    return (
        <nav className="nav flex-1 justify-end leading-6 bg-slate-500">
            {!loggedIn && <>
                <NavLink className="nav-link" to="/login">Login</NavLink>
                <NavLink className="nav-link" to="/register">Register</NavLink>
            </>}

            {loggedIn && <>
                <NavLink className="nav-link" aria-current="page" to="/">Home</NavLink>
                <div className="dropdown">
                    <a className="nav-link dropdown-toggle cursor-pointer" data-toggle="dropdown">User</a>
                    <ul className="dropdown-menu">
                        <li>
                            <NavLink className="nav-link" to="/dashboard">Dashboard</NavLink>
                            <a className="nav-link cursor-pointer" onClick={logout}>Logout</a>
                        </li>
                    </ul>
                </div>
            </>}
        </nav>
    );
}