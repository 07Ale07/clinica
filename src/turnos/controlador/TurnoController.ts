import { TurnoInfo } from '../modelo/TurnoModel';
import { apiService } from '../../services/api';

export class TurnoController {
  static async fetchTurno(dni: string): Promise<TurnoInfo[]> {
    try {
      const response = await apiService.get<TurnoInfo[]>(`/citas?dni=${dni}`);
      return response.data;
    } catch (error) {
      throw new Error('Error al consultar el turno');
    }
  }
}