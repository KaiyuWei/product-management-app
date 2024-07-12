import axios from "axios";

const axiosForApi = axios.create({
    baseURL: process.env.REACT_APP_API,
    headers: {
        'Content-Type': 'application/json',
    },
});

export default axiosForApi;