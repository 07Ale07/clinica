import { API_BASE_URL } from "../../services/api"

export interface Horario {
  id_horario: number
  id_empleado: number
  dia_semana: string
  hora_inicio: string
  hora_fin: string
  fecha_desde: string | null
  fecha_hasta: string | null
  activo: number
  nombre: string
  apellido: string
}

export interface Cita {
  id_cita: number
  id_paciente: number
  fecha_inicio: string
  fecha_fin: string
  tipo: string
  estado: string
  observaciones: string | null
  nombre_paciente: string
  apellido_paciente: string
  nombre_odontologo: string
  apellido_odontologo: string
}

export interface HorariosResponse {
  success: boolean
  data: Horario[]
  message?: string
}

export interface CitasResponse {
  success: boolean
  data: Cita[]
  message?: string
}

export class RecepcionistaHorariosModel {
  private baseUrl: string

  constructor() {
    this.baseUrl = API_BASE_URL
  }

  // Obtener horarios del recepcionista (mis horarios)
  async obtenerMisHorarios(idEmpleado: number, fecha?: string): Promise<HorariosResponse> {
    try {
      const url = fecha
        ? `${this.baseUrl}/horarios/recepcionista/${idEmpleado}?fecha=${fecha}`
        : `${this.baseUrl}/horarios/recepcionista/${idEmpleado}`

      const response = await fetch(url)
      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || "Error al obtener horarios")
      }

      return data
    } catch (error) {
      console.error("Error en obtenerMisHorarios:", error)
      throw error
    }
  }

  // Obtener horarios de todos los odontólogos
  async obtenerHorariosOdontologos(fecha?: string, diaSemana?: string): Promise<HorariosResponse> {
    try {
      let url = `${this.baseUrl}/horarios/odontologos`
      const params = new URLSearchParams()

      if (fecha) params.append("fecha", fecha)
      if (diaSemana) params.append("dia_semana", diaSemana)

      if (params.toString()) {
        url += `?${params.toString()}`
      }

      const response = await fetch(url)
      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || "Error al obtener horarios de odontólogos")
      }

      return data
    } catch (error) {
      console.error("Error en obtenerHorariosOdontologos:", error)
      throw error
    }
  }

  // Obtener citas del día
  async obtenerCitasDelDia(idEmpleado: number, fecha?: string): Promise<CitasResponse> {
    try {
      const url = fecha
        ? `${this.baseUrl}/citas/recepcionista/${idEmpleado}?fecha=${fecha}`
        : `${this.baseUrl}/citas/recepcionista/${idEmpleado}`

      const response = await fetch(url)
      const data = await response.json()

      if (!response.ok) {
        throw new Error(data.message || "Error al obtener citas")
      }

      return data
    } catch (error) {
      console.error("Error en obtenerCitasDelDia:", error)
      throw error
    }
  }

  // Agrupar horarios por día de la semana
  agruparHorariosPorDia(horarios: Horario[]): Map<string, Horario[]> {
    const diasOrden = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"]
    const agrupados = new Map<string, Horario[]>()

    diasOrden.forEach((dia) => agrupados.set(dia, []))

    horarios.forEach((horario) => {
      const dia = horario.dia_semana
      if (agrupados.has(dia)) {
        agrupados.get(dia)!.push(horario)
      }
    })

    return agrupados
  }

  // Agrupar horarios por odontólogo
  agruparHorariosPorOdontologo(horarios: Horario[]): Map<string, Horario[]> {
    const agrupados = new Map<string, Horario[]>()

    horarios.forEach((horario) => {
      const nombreCompleto = `${horario.apellido}, ${horario.nombre}`
      if (!agrupados.has(nombreCompleto)) {
        agrupados.set(nombreCompleto, [])
      }
      agrupados.get(nombreCompleto)!.push(horario)
    })

    return agrupados
  }

  // Formatear hora para mostrar
  formatearHora(hora: string): string {
    return hora.substring(0, 5) // Retorna HH:MM
  }
}
