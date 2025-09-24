import { apiService } from '../../services/api'; // Asume path relativo correcto a api.ts

export interface InventoryItem {
  id: number;
  nombre: string;
  descripcion: string;
  quantity: number;
  category: string;
  fecha_actualizacion: string; // Formato ISO o timestamp
}

export async function getInventario(): Promise<InventoryItem[]> {
  try {
    const response = await apiService.get<InventoryItem[]>('/inventario');
    return response.data;
  } catch (error) {
    console.error('Error al obtener inventario del API:', error);
    throw error;
  }
}