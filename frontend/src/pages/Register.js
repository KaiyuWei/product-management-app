import {useState} from "react";
import axios from "axios";

 export default function Register() {
     const [name, setName] = useState("");
     const [role, setRole] = useState("");
     const [email, setEmail] = useState("");
     const [password, setPassword] = useState("");

    const handleSubmit = async (e) => {
        e.preventDefault();
        const registerUrl = `${process.env.REACT_APP_API}/register`;

        try {
            const res = await axios.get(process.env.REACT_APP_API, {headers: {
                    'Content-Type': 'application/json',
                }});
            console.log(res);
        } catch (err) {
            console.log(err);
        }
    }

    return (
        <div>
            <h1 className="display-1 bg-primary text-light p-5">Register</h1>

            <div className="container">
                <div className="row">
                    <div className="col-lg-4 offset-lg-4">
                        <form onSubmit = {handleSubmit} >
                            <input type = "text" placeholder = "Enter your name" className = "form-control mb-2"
                                   required
                                   autoFocus value = {name}
                                   onChange = {(e) => setName(e.target.value)} />
                            <select className = "form-select form-control mb-2 required" defaultValue="default" >
                                <option value="default" hidden >Select a role</option >
                                <option value = "customer" >Customer</option >
                                <option value = "supplier" >Supplier</option >
                            </select >
                            <input type = "text" placeholder = "Enter your email" className = "form-control mb-2"
                                   required
                                   autoFocus value = {email}
                                   onChange = {(e) => setEmail(e.target.value)} />
                            <input type = "password" placeholder = "Enter your password" className = "form-control mb-2"
                                   required
                                   autoFocus value = {password}
                                   onChange = {(e) => setPassword(e.target.value)} />
                            <button className = "btn btn-primary col-12" >Register</button >
                        </form >
                    </div >
                </div >
            </div >
        </div >
    );
 }