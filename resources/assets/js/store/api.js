import axios from 'axios'

export function apiGet(url) {
    return axios.get(url);
}

export function apiPost(url, body) {
    return axios.post(url, body);
}

export function apiDelete(url) {
    return axios.delete(url);
}
