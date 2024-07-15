import {BrowserRouter, Routes, Route} from "react-router-dom";
import {AuthProvider} from "./context/auth";
import Main from "./components/Main";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import './App.css';
import {useAuth} from "./context/auth";

import Home from "./pages/Home";
import Register from "./pages/Register";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";

function App() {

  return (
    <BrowserRouter>
        <AuthProvider>
            <ToastContainer/>
            <Main/>
            <Routes>
                <Route path='/' element={<Home />}/>
                <Route path='/login' element={<Login />}/>
                <Route path='/register' element={<Register />}/>
                <Route path='/dashboard' element={<Dashboard/>}/>
            </Routes>
        </AuthProvider>
    </BrowserRouter>
  );
}

export default App;
