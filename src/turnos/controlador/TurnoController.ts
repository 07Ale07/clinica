import type { TurnoInfo } from "../modelo/TurnoModel"
import { apiService } from "../../services/api"

export class TurnoController {
  static async fetchTurno(dni: string): Promise<TurnoInfo[]> {
    try {
      const response = await apiService.get<TurnoInfo[]>(`/citas?dni=${dni}`)
      return response.data
    } catch (error) {
      throw new Error("Error al consultar el turno")
    }
  }

  static async cancelTurno(id_cita: number): Promise<void> {
    try {
      await apiService.patch(`/citas/${id_cita}/cancel`, { estado: "cancelada" })
    } catch (error: any) {
      throw new Error(error.response?.data?.message || "Error al cancelar el turno")
    }
  }
}
