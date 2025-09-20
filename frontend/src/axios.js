import axios from 'axios';

const instance = axios.create({
    // baseURL: 'http://127.0.0.1:5000/api'
    baseURL: 'https://arsil-backend-anzxy.sevalla.app/api'
});

export default instance;

