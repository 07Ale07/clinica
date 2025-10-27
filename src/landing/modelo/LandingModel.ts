// Modelo de datos para la Landing Page
export interface Procedure {
  id: number
  descripcion: string
  costo: string
  img: string
}

export interface Employee {
  id: number
  nombre: string
  apellido: string
  foto: string
  especialidad?: string
}

export interface SocialWork {
  id: number
  nombre: string
  telefono: string
  direccion: string
}

export interface PerformedProcedure {
  id: number
  procedimiento: string
  paciente: string
  fecha: string
  empleado?: string
  img_antes?: string
  img_despues?: string
  observaciones?: string
}

export interface LandingData {
  procedures: Procedure[]
  employees: Employee[]
  socialWorks: SocialWork[]
  performedProcedures: PerformedProcedure[]
}

export class LandingModel {
  // Datos de ejemplo para la landing
  static getMockData(): LandingData {
    return {
      procedures: [
        {
          id: 1,
          descripcion: "Blanqueamiento Dental",
          costo: "15000",
          img: "blanqueamiento.jpg",
        },
        {
          id: 2,
          descripcion: "Ortodoncia Invisible",
          costo: "85000",
          img: "ortodoncia.jpg",
        },
        {
          id: 3,
          descripcion: "Implantes Dentales",
          costo: "45000",
          img: "implantes.jpg",
        },
      ],
      employees: [
        {
          id: 1,
          nombre: "María",
          apellido: "González",
          foto: "doctor1.jpg",
          especialidad: "Ortodoncia",
        },
        {
          id: 2,
          nombre: "Carlos",
          apellido: "Rodríguez",
          foto: "doctor2.jpg",
          especialidad: "Implantología",
        },
      ],
      socialWorks: [
        {
          id: 1,
          nombre: "OSDE",
          telefono: "0800-555-6733",
          direccion: "Av. Corrientes 1234",
        },
        {
          id: 2,
          nombre: "Swiss Medical",
          telefono: "0810-333-8477",
          direccion: "Av. Santa Fe 2345",
        },
      ],
      performedProcedures: [
        {
          id: 1,
          procedimiento: "Blanqueamiento Dental",
          paciente: "Juan Pérez",
          fecha: "2025-01-15",
          empleado: "Dra. María González",
          img_antes: "antes1.jpg",
          img_despues: "despues1.jpg",
          observaciones: "Excelente resultado en 3 sesiones",
        },
      ],
    }
  }
}
