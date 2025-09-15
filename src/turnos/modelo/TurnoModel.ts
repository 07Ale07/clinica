import { Paciente } from './PacienteModel';

export interface Turno {
  id_cita?: number;
  id_paciente: number;
  id_empleado?: number;
  id_sillon?: number;
  fecha_inicio: string;
  fecha_fin: string;
  estado: 'pendiente' | 'confirmada' | 'completada' | 'cancelada' | 'no_asistio';
  tipo: 'consulta' | 'tratamiento' | 'control';
  id_procedimiento?: number;
  observaciones?: string;
  paciente?: Paciente;
}

export interface Empleado {
  id_empleado: number;
  numero_legajo: string;
  id_persona: number;
  tipo_contrato: 'permanente' | 'temporal' | 'honorarios' | 'pasantia';
  telefono_interno?: string;
  foto?: string;
}

export interface Sillon {
  id_sillon: number;
  nombre: string;
  descripcion?: string;
  activo: boolean;
}