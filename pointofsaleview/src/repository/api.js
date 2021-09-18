import axios from "axios";
import Vue from "vue";
import store from '../store'

const api = axios.create({
    baseURL: 'http://localhost:8000/api/',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    }
})

// Todo: add jwt token with request with interceptor

api.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response && error.response.status === 401) {
        Vue.prototype.$session.destroy()
        store.commit('setSessionError', true)
        return Promise.reject(error)
    }
});

export default api;