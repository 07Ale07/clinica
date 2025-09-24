// File: modelo/horarioModel.ts

export interface Horario {
    id_horario: number;
    id_empleado: number;
    dia_semana: 'Lunes' | 'Martes' | 'Miércoles' | 'Jueves' | 'Viernes' | 'Sábado' | 'Domingo';
    hora_inicio: string; // Formato HH:MM
    hora_fin: string; // Formato HH:MM
    activo: boolean;
    fecha_desde?: string; // Formato YYYY-MM-DD
    fecha_hasta?: string; // Formato YYYY-MM-DD
  }