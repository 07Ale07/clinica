import { RecepcionistaHorariosModel, type Horario, type Cita } from "../modelo/RecepcionistaHorariosModel"

export class RecepcionistaHorariosController {
  private model: RecepcionistaHorariosModel

  constructor() {
    this.model = new RecepcionistaHorariosModel()
  }

  // Cargar mis horarios
  async cargarMisHorarios(idEmpleado: number, fecha?: string): Promise<Horario[]> {
    try {
      const response = await this.model.obtenerMisHorarios(idEmpleado, fecha)
      return response.data
    } catch (error) {
      console.error("Error al cargar mis horarios:", error)
      throw new Error("No se pudieron cargar los horarios")
    }
  }

  // Cargar horarios de odontólogos
  async cargarHorariosOdontologos(fecha?: string, diaSemana?: string): Promise<Horario[]> {
    try {
      const response = await this.model.obtenerHorariosOdontologos(fecha, diaSemana)
      return response.data
    } catch (error) {
      console.error("Error al cargar horarios de odontólogos:", error)
      throw new Error("No se pudieron cargar los horarios de los odontólogos")
    }
  }

  // Cargar citas del día
  async cargarCitasDelDia(idEmpleado: number, fecha?: string): Promise<Cita[]> {
    try {
      const response = await this.model.obtenerCitasDelDia(idEmpleado, fecha)
      return response.data
    } catch (error) {
      console.error("Error al cargar citas del día:", error)
      throw new Error("No se pudieron cargar las citas")
    }
  }

  // Obtener horarios agrupados por día
  obtenerHorariosAgrupadosPorDia(horarios: Horario[]): Map<string, Horario[]> {
    return this.model.agruparHorariosPorDia(horarios)
  }

  // Obtener horarios agrupados por odontólogo
  obtenerHorariosAgrupadosPorOdontologo(horarios: Horario[]): Map<string, Horario[]> {
    return this.model.agruparHorariosPorOdontologo(horarios)
  }

  // Formatear hora
  formatearHora(hora: string): string {
    return this.model.formatearHora(hora)
  }

  // Obtener fecha actual en formato YYYY-MM-DD
  obtenerFechaActual(): string {
    return new Date().toISOString().split("T")[0]
  }

  // Obtener día de la semana en español
  obtenerDiaSemana(fecha: string): string {
    const dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
    const fechaObj = new Date(fecha + "T00:00:00")
    return dias[fechaObj.getDay()]
  }

  // Validar si una fecha es válida
  validarFecha(fecha: string): boolean {
    const fechaObj = new Date(fecha)
    return !isNaN(fechaObj.getTime())
  }
}
