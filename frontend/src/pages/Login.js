import {useState} from "react";
import axios from "../config/axios";
import {useNavigate} from "react-router-dom";
import { toast } from 'react-toastify';
import {useAuth} from "../context/auth";

export default function Login() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [loading, setLoading] = useState(false);
    const [auth, setAuth] = useAuth();

    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        try {
            await axios.get('http://localhost:8000/sanctum/csrf-cookie');
            const response = await axios.post('/login', {email, password});

            const newAuth = {
                userId: response.data.id,
                role: response.data.role,
            };
            setAuth(newAuth);
            localStorage.setItem('auth', JSON.stringify(newAuth));
            toast.success('User logged in');

            navigate('/');
        } catch(e) {
            toast.error(e.response.data.error);
        }
    }

    return (
        <div >
            <h1 className = "display-1 bg-primary text-light p-5" >Login</h1 >

            <div className = "container mt-6" >
                <div className = "row" >
                    <div className = "col-lg-4 offset-lg-4" >
                        <form onSubmit = {handleSubmit} >
                            <input type = "text" placeholder = "Enter your email" className = "form-control mb-2"
                                   required
                                   autoFocus value = {email}
                                   onChange = {(e) => setEmail(e.target.value)} />
                            <input type = "password" placeholder = "Enter your password" className = "form-control mb-2"
                                   required
                                   value = {password}
                                   onChange = {(e) => setPassword(e.target.value)} />
                            <button className = "btn btn-primary col-12 mt-4" disabled={loading} >Log in</button >
                        </form >
                    </div >
                </div >
            </div >
        </div >
    );
}