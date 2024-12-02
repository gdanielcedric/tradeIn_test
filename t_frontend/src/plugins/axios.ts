import axios, { type AxiosInstance } from 'axios';

const axiosInstance: AxiosInstance = axios.create({
  baseURL: 'http://localhost:8000/api',
  timeout: 5000,
});

export default axiosInstance;
