// odontologo/modelo/PacienteModel.ts
export interface Paciente {
  id_paciente: number;
  id_persona: number;
  fecha_registro?: string;
  tipo?: 'adulto' | 'menor' | 'geriatrico' | null;
  alergias?: string | null;
  observaciones_generales?: string | null;
  foto?: string | null;
  activo?: number;
  nombre: string;
  apellido: string;
  DNI: string;
}

export interface Familiar {
  id_familiar: number;
  id_grupo?: number;
  id_paciente: number;
  parentesco?: string;
  responsable?: number;
}

export interface CitaAnterior {
  id_cita: number;
  fecha: string;
  tipo: 'consulta' | 'tratamiento' | 'control';
  descripcion?: string | null; // Corresponde a observaciones en la tabla citas
  estado: 'pendiente' | 'confirmada' | 'completada' | 'cancelada' | 'no_asistio';
}