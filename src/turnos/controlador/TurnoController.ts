// File: TurnoController.ts
import axios from 'axios';
import { TurnoInfo } from '../modelo/TurnoModel';
import { apiService, API_BASE_URL } from '../../services/api';

export class TurnoController {
  static async fetchTurno(dni: string): Promise<TurnoInfo[]> {
    try {
      const response = await apiService.get<TurnoInfo[]>(`/citas?dni=${dni}`);
      return response.data;
    } catch (error) {
      throw new Error('Error al consultar el turno');
    }
  }

  static async cancelTurno(id_cita: number): Promise<void> {
    try {
      await axios.patch(`${API_BASE_URL}/citas/${id_cita}/cancel`, { estado: 'cancelada' });
    } catch (error: any) {
      throw new Error(error.response?.data?.message || 'Error al cancelar el turno');
    }
  }
}