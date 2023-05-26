import axios from 'axios';
import {ElMessage} from "element-plus";
import router from "../router";

export const HTTP = axios.create({
    baseURL: `http://localhost:8000/api/`,
    headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
    }
})

HTTP.interceptors.response.use((response) => {
    if (response.data.hasOwnProperty('user')) {
        localStorage.setItem('user', JSON.stringify(response.data.user));
    }
    if (response.data.hasOwnProperty('token')) {
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('authenticated', true);
    }

    if (response.data.hasOwnProperty('message')) {
        ElMessage.success(response.data.message)
    }

    return Promise.resolve(response)
}, (error) => {

    ElMessage.closeAll();

    if (error.response.status === 401) {
        ElMessage.error("Unathorised access, try to login again");
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.setItem('authenticated', false);
        router.push({name: 'login'});
    }

    if (error.response.status >= 422) {
        ElMessage.error("Captured data is invalid");
    }

    if (error.response.status >= 500) {
        ElMessage.error("Server error, please contact admin...");
    }

    return Promise.reject(error)
})
