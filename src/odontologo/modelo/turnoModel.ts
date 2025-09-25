// File: ../modelo/turnoModel.ts

export interface Turno {
  id_cita: number;
  hora_inicio: string; // Formato como 'HH:MM' o completo si es necesario
  nombre_paciente: string;
  tipo: 'consulta' | 'tratamiento' | 'control';
  estado: 'pendiente' | 'confirmada' | 'completada' | 'cancelada' | 'no_asistio';
  id_paciente: number; // Agregar esto si no está
}