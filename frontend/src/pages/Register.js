import {useState} from "react";
import axios from "../config/axios";
import { toast } from 'react-toastify';
import {useNavigate} from "react-router-dom";

export default function Register() {
     const [name, setName] = useState("");
     const [role, setRole] = useState("");
     const [email, setEmail] = useState("");
     const [password, setPassword] = useState("");
     const [loading, setLoading] = useState(false);
     const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        // const requestUrl = process.env.REACT_APP_API + '/register';

        try {
            const res= await axios.post('/register', {name, role, email, password});
            toast.success(`A ${role} is successfully registered`);
            navigate("/login");
        } catch (err) {
            setLoading(false);
            toast.error(err.response.data.error);
        }
    }

    return (
        <div>
            <h1 className="display-1 bg-primary text-light p-5">Register</h1>

            <div className="container mt-6">
                <div className="row">
                    <div className="col-lg-4 offset-lg-4">
                        <form onSubmit = {handleSubmit} >
                            <input type = "text" placeholder = "Enter your name" className = "form-control mb-2"
                                   required
                                   autoFocus value = {name}
                                   onChange = {(e) => setName(e.target.value)} />
                            <select className = "form-select form-control mb-2 required" value = {role}
                                    onChange = {(e) => setRole(e.target.value)} >
                                <option value = "default" hidden >Select a role</option >
                                <option value = "customer" >Customer</option >
                                <option value = "supplier" >Supplier</option >
                            </select >
                            <input type = "text" placeholder = "Enter your email" className = "form-control mb-2"
                                   required
                                   value = {email}
                                   onChange = {(e) => setEmail(e.target.value)} />
                            <input type = "password" placeholder = "Enter your password" className = "form-control mb-2"
                                   required
                                   value = {password}
                                   onChange = {(e) => setPassword(e.target.value)} />
                            <button className = "btn btn-primary col-12 mt-4" disabled={loading} >Register</button >
                        </form >
                    </div >
                </div >
            </div >
        </div >
    );
 }