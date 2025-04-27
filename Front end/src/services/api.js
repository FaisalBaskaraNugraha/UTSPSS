import axios from 'axios';

const API_BASE_URL = 'http://localhost:8080/api'; // Contoh jika backend di port 8080

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
});

export default apiClient;