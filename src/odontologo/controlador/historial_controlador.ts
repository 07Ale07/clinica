import { apiService } from '../../services/api';
import { PatientHistory } from '../modelo/historial_modelo';

export class HistorialControl {
  static async getPatientHistory(id_usuario: string): Promise<PatientHistory[]> {
    try {
      // Obtener id_empleado desde id_usuario (asumiendo endpoint /usuario/:id)
      const userResponse = await apiService.get<{ id_empleado: number }>('/usuario/' + id_usuario);
      const id_empleado = userResponse.data.id_empleado.toString();

      const response = await apiService.get<PatientHistory[]>('/historial/' + id_empleado);
      return response.data;
    } catch (error) {
      console.error('Error fetching patient history:', error);
      throw error;
    }
  }
}