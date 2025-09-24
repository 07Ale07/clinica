// File: controlador/turno_control.ts

import { API_BASE_URL, apiService } from '../../services/api';
import { Turno } from '../modelo/turnoModel';
import { Horario } from '../modelo/horarioModel';

// Define the raw API response type for citas
interface RawCita {
  id_cita: number;
  fecha_inicio: string;
  nombre_paciente: string;
  tipo: 'consulta' | 'tratamiento' | 'control';
  estado: 'pendiente' | 'confirmada' | 'completada' | 'cancelada' | 'no_asistio';
}

// Define the raw API response type for horarios
interface RawHorario {
  id_horario: number;
  id_empleado: number;
  dia_semana: 'Lunes' | 'Martes' | 'Miércoles' | 'Jueves' | 'Viernes' | 'Sábado' | 'Domingo';
  hora_inicio: string; // Formato HH:MM:SS
  hora_fin: string; // Formato HH:MM:SS
  activo: number; // 0 o 1
  fecha_desde?: string; // Formato YYYY-MM-DD
  fecha_hasta?: string; // Formato YYYY-MM-DD
}

// Utility function to format date to YYYY-MM-DD
const formatDateToYYYYMMDD = (date: Date): string => {
  return date.toISOString().split('T')[0];
};

// Utility function to format time to HH:MM
const formatTimeToHHMM = (time: string): string => {
  return time.substring(0, 5); // Extrae HH:MM de HH:MM:SS
};

// Utility function to check if a horario is valid for a given date
const isHorarioValidForDate = (horario: RawHorario, date: string): boolean => {
  const currentDate = new Date(date);
  const fechaDesde = horario.fecha_desde ? new Date(horario.fecha_desde) : null;
  const fechaHasta = horario.fecha_hasta ? new Date(horario.fecha_hasta) : null;

  // Si ambas fechas son NULL, el horario es válido indefinidamente
  if (!fechaDesde && !fechaHasta) {
    return true;
  }

  // Si hay fecha_desde, la fecha actual debe ser mayor o igual
  if (fechaDesde && currentDate < fechaDesde) {
    return false;
  }

  // Si hay fecha_hasta, la fecha actual debe ser menor o igual
  if (fechaHasta && currentDate > fechaHasta) {
    return false;
  }

  return true;
};

export class TurnoControl {
  static async getTurnosOdontologo(id_usuario: string): Promise<Turno[]> {
    try {
      const today = formatDateToYYYYMMDD(new Date());
      const response = await apiService.get<RawCita[]>(`/citas/odontologo/${id_usuario}?fecha=${today}`);
      const citas: RawCita[] = response.data;
      const turnos: Turno[] = citas.map((cita) => ({
        id_cita: cita.id_cita,
        hora_inicio: formatTimeToHHMM(cita.fecha_inicio),
        nombre_paciente: cita.nombre_paciente,
        tipo: cita.tipo,
        estado: cita.estado,
      }));
      return turnos;
    } catch (error) {
      console.error('Error fetching turnos:', error);
      throw new Error('No se pudieron cargar los turnos. Intente de nuevo más tarde.');
    }
  }

  static async getHorariosOdontologo(id_empleado: string, dia_semana: string, fecha: string = formatDateToYYYYMMDD(new Date())): Promise<Horario[]> {
    try {
      const response = await apiService.get<RawHorario[]>(`/horarios/odontologo/${id_empleado}?dia=${dia_semana}&fecha=${fecha}`);
      const horarios: RawHorario[] = response.data;
      return horarios
        .filter((horario) => isHorarioValidForDate(horario, fecha) && horario.activo === 1)
        .map((horario) => ({
          id_horario: horario.id_horario,
          id_empleado: horario.id_empleado,
          dia_semana: horario.dia_semana,
          hora_inicio: formatTimeToHHMM(horario.hora_inicio),
          hora_fin: formatTimeToHHMM(horario.hora_fin),
          activo: horario.activo === 1,
          fecha_desde: horario.fecha_desde,
          fecha_hasta: horario.fecha_hasta,
        }));
    } catch (error) {
      console.error(`Error fetching horarios para ${dia_semana}:`, error);
      throw new Error('No se pudieron cargar los horarios. Intente de nuevo más tarde.');
    }
  }

  static async getProximoDiaLaboral(id_empleado: string, fecha_actual: Date): Promise<{ dia_semana: string; fecha: string }> {
    try {
      const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
      let diaActual = fecha_actual.getDay(); // 0 = Domingo, 1 = Lunes, etc.
      let fecha = new Date(fecha_actual);

      // Probar los próximos 7 días
      for (let i = 0; i < 7; i++) {
        diaActual = (diaActual + 1) % 7; // Avanzar al siguiente día
        fecha.setDate(fecha.getDate() + 1);
        const diaSemanaStr = diasSemana[diaActual];
        const fechaStr = formatDateToYYYYMMDD(fecha);
        const horarios = await this.getHorariosOdontologo(id_empleado, diaSemanaStr, fechaStr);
        if (horarios.length > 0) {
          return { dia_semana: diaSemanaStr, fecha: fechaStr };
        }
      }
      throw new Error('No se encontraron horarios laborales en los próximos 7 días.');
    } catch (error) {
      console.error('Error buscando próximo día laboral:', error);
      throw new Error('No se pudo determinar el próximo día laboral.');
    }
  }
}