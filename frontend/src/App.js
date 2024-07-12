import {BrowserRouter, Routes, Route} from "react-router-dom";
import {AuthProvider} from "./context/auth";
import Main from "./components/Main";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import Home from "./pages/Home";
import Register from "./pages/Register";
import Login from "./pages/Login";
import './App.css';

function App() {
  return (
    <BrowserRouter>
        <Main/>
        <ToastContainer/>
        <AuthProvider>
            <Routes>
                <Route path='/' element={<Home />}/>
                <Route path='/login' element={<Login />}/>
                <Route path='/register' element={<Register />}/>
            </Routes>
        </AuthProvider>
    </BrowserRouter>
  );
}

export default App;
