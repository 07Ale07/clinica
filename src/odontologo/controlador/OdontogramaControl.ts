// odontologo/controlador/OdontogramaControl.ts
import axios from 'axios';
import { API_BASE_URL } from '../../services/api';
import { Odontograma, OdontogramaData } from '../modelo/OdontogramaModel';

class OdontogramaControl {
  static async obtenerOdontograma(id_paciente: number): Promise<Odontograma | null> {
    try {
      const response = await axios.get<Odontograma>(`${API_BASE_URL}/odontograma/${id_paciente}`);
      return response.data;
    } catch (error: any) {
      if (error.response?.status === 404) {
        // Return an empty odontogram instead of throwing an error
        return { id_paciente, odontograma: {} };
      }
      console.error('Error en obtenerOdontograma:', error);
      throw new Error(`Error al obtener el odontograma: ${error.response?.data?.error || error.message}`);
    }
  }

  static async guardarOdontograma(id_paciente: number, datos: OdontogramaData): Promise<boolean> {
    try {
      const response = await axios.post<{ success: boolean }>(
        `${API_BASE_URL}/odontograma/guardar`,
        {
          id_paciente,
          odontograma: datos,
        }
      );
      return response.data.success;
    } catch (error: any) {
      console.error('Error en guardarOdontograma:', error);
      throw new Error(`Error al guardar el odontograma: ${error.response?.data?.error || error.message}`);
    }
  }
}

export default OdontogramaControl;