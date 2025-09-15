import axios from 'axios';
import { LoginResponse, LoginCredentials } from '../../modelo/LoginModel'; 

export const API_BASE_URL = 'http://10.0.13.99:3000';

export const apiService = {
  async login(credentials: LoginCredentials): Promise<LoginResponse> {
    try {
      const response = await axios.post<LoginResponse>(
        `${API_BASE_URL}/login`,
        credentials
      );
      return response.data;
    } catch (error) {
      console.error('Error en la petición de login:', error);
      throw new Error('No se pudo conectar con el servidor');
    }
  },
};