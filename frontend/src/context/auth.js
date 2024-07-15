import {useState, createContext, useContext, useEffect} from "react";

const AuthContext = createContext();

const AuthProvider = ({children}) => {
    const [auth, setAuth] = useState({
        userId: null,
        role: '',
    });

    useEffect(() => {
         const authDataInLocalStorage = localStorage.getItem('auth');
         if (authDataInLocalStorage) setAuth(JSON.parse(authDataInLocalStorage))
    }, []);

    return (
        <AuthContext.Provider value={[auth, setAuth]}>
            {children}
        </AuthContext.Provider>
    );
};

const useAuth = () => useContext(AuthContext);

export {useAuth, AuthProvider};