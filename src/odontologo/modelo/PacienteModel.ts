// odontologo/modelo/PacienteModel.ts
export interface Persona {
    id_persona: number;
    nombre: string;
    apellido: string;
    DNI: string;
  }
  
  export interface Paciente {
    id_paciente: number;
    id_persona: number;
    fecha_registro: string;
    tipo: string;
    alergias: string;
    observaciones_generales: string;
    foto?: string;
    activo: boolean;
    persona?: Persona; // Relación opcional
  }
  
  export interface Familiar {
    id_familiar?: number;
    id_paciente: number;
    // Asumimos estructura básica; ajusta según tu DB
    nombre: string;
    apellido: string;
    relacion: string;
    telefono?: string;
  }
  
  export interface CitaAnterior {
    id_cita: number;
    fecha: string;
    tipo: string;
    descripcion?: string;
    estado: string;
  }
  
  export interface DetallePaciente {
    paciente: Paciente;
    familiares: Familiar[];
    citas_anteriores: CitaAnterior[];
  }