import axios from 'axios';

export function http() {

    const token = localStorage.getItem('token');

    return axios.create({
        baseURL: "http://api.new.orponbd.com/api",
        headers: {
            Authorization: 'Bearer '+ token
        }
    });
}

export function httpFile() {

    const token = localStorage.getItem('token');

    return axios.create({
       baseURL: "http://api.new.orponbd.com/api",
       headers: {
            'Content-Type' : 'multipart/form-data',
             Authorization: 'Bearer '+ token
        }
    });
}