import qs from 'qs';
import axios from 'axios';
import router from './routes/router';

const Axios = axios.create({
    baseURL: '/',
    paramsSerializer: function (params) {
        return qs.stringify(params, {arrayFormat: 'brackets'})
    }
});

Axios.interceptors.request.use(config => {
    const token = localStorage.getItem('access_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`
    }
    return config;
}, error => Promise.reject(error));

Axios.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        localStorage.removeItem('access_token');
        localStorage.removeItem('refresh_token');
        router.replace({name: 'login'});
    }

    return Promise.reject(error.response);
});

export default Axios;