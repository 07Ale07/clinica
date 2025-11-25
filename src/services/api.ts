// File: ../../services/api.ts

import axios, { type AxiosResponse } from "axios"
import type { LoginResponse, LoginCredentials } from "../../modelo/LoginModel"

export const API_BASE_URL = "http://10.0.13.99:3000"

export const apiService = {
  async login(credentials: LoginCredentials): Promise<LoginResponse> {
    try {
      const response = await axios.post<LoginResponse>(`${API_BASE_URL}/login`, credentials)
      return response.data
    } catch (error) {
      console.error("Error en la petición de login:", error)
      throw new Error("No se pudo conectar con el servidor")
    }
  },

  async get<T>(url: string): Promise<AxiosResponse<T>> {
    try {
      const response = await axios.get<T>(`${API_BASE_URL}${url}`)
      return response
    } catch (error) {
      console.error(`Error en la petición GET a ${url}:`, error)
      throw new Error("No se pudo conectar con el servidor")
    }
  },

  async patch<T>(url: string, data: any): Promise<AxiosResponse<T>> {
    try {
      const response = await axios.patch<T>(`${API_BASE_URL}${url}`, data)
      return response
    } catch (error) {
      console.error(`Error en la petición PATCH a ${url}:`, error)
      throw new Error("No se pudo conectar con el servidor")
    }
  },
}
