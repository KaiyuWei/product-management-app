import {NavLink} from "react-router-dom";

export default function Main() {
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
                        <a className="nav-link cursor-pointer">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    );
}