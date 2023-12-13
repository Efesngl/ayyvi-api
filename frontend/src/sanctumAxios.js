import axios from "axios"

const sanctumAxios = axios.create({
baseURL: 'http://localhost:8000',
});
sanctumAxios.defaults.withCredentials=true
sanctumAxios.defaults.withXSRFToken=true

export default sanctumAxios;