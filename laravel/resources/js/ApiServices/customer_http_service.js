import axios from 'axios';

export function customerHttp() {

    const customerToken = localStorage.getItem('customer_token');

    return axios.create({
        baseURL: "http://api.new.orponbd.com/api",
        headers: {
            Authorization: 'Bearer '+ customerToken
        }
    });
}

export function customerHttpFile() {

    const customerToken = localStorage.getItem('customer_token');

    return axios.create({
        baseURL: "http://api.new.orponbd.com/api",
        headers: {
            'Content-Type' : 'multipart/form-data',
             Authorization: 'Bearer '+ customerToken
        }
    });
}
