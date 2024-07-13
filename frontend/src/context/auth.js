import {useState, createContext, useContext} from "react";

const AuthContext = createContext();

const AuthProvider = ({children}) => {
    const [auth, setAuth] = useState({
        userId: null,
        role: '',
    });

    return (
        <AuthContext.Provider value={[auth, setAuth]}>
            {children}
        </AuthContext.Provider>
    );
};

const useAuth = () => useContext(AuthContext);

export {useAuth, AuthProvider};