import axios from "axios";

const axiosForApi = axios.create({
    baseURL: process.env.REACT_APP_API,
    headers: {
        'Content-Type': 'application/json',
    },
    withCredentials: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
    withXSRFToken: true,
});

export default axiosForApi;