import axios from 'axios';
import { API_BASE_URL } from '../../services/api';
import { Paciente, Persona, ObraPersona, Familiar } from '../modelo/PacienteModel';
import { Turno } from '../modelo/TurnoModel';

class TurnoController {
  // Pacientes
  static async obtenerPacientes(): Promise<Paciente[]> {
    try {
      const response = await axios.get(`${API_BASE_URL}/pacientes`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener pacientes:', error);
      throw error;
    }
  }

  static async buscarPacientes(termino: string): Promise<Paciente[]> {
    try {
      const response = await axios.get(`${API_BASE_URL}/pacientes/buscar?q=${termino}`);
      return response.data;
    } catch (error) {
      console.error('Error al buscar pacientes:', error);
      throw error;
    }
  }

  static async crearPersona(persona: Omit<Persona, 'id_persona'>): Promise<Persona> {
    try {
      const response = await axios.post(`${API_BASE_URL}/personas`, persona);
      return response.data;
    } catch (error) {
      console.error('Error al crear persona:', error);
      throw error;
    }
  }

  static async crearPaciente(paciente: Omit<Paciente, 'id_paciente'>): Promise<Paciente> {
    try {
      const response = await axios.post(`${API_BASE_URL}/pacientes`, paciente);
      return response.data;
    } catch (error) {
      console.error('Error al crear paciente:', error);
      throw error;
    }
  }

  static async agregarObraSocialPaciente(obraPersona: Omit<ObraPersona, 'id_obra_persona'>): Promise<ObraPersona> {
    try {
      const response = await axios.post(`${API_BASE_URL}/obra-personas`, obraPersona);
      return response.data;
    } catch (error) {
      console.error('Error al agregar obra social:', error);
      throw error;
    }
  }

  static async agregarFamiliar(familiar: Omit<Familiar, 'id_familiar'>): Promise<Familiar> {
    try {
      const response = await axios.post(`${API_BASE_URL}/familiares`, familiar);
      return response.data;
    } catch (error) {
      console.error('Error al agregar familiar:', error);
      throw error;
    }
  }

  // Obras sociales
  static async obtenerObrasSociales(): Promise<any[]> {
    try {
      const response = await axios.get(`${API_BASE_URL}/obra-sociales`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener obras sociales:', error);
      throw error;
    }
  }

  // Turnos
  static async crearTurno(turno: Omit<Turno, 'id_cita'>): Promise<Turno> {
    try {
      const response = await axios.post(`${API_BASE_URL}/citas`, turno);
      return response.data;
    } catch (error) {
      console.error('Error al crear turno:', error);
      throw error;
    }
  }

  static async obtenerTurnos(): Promise<Turno[]> {
    try {
      const response = await axios.get(`${API_BASE_URL}/citas`);
      return response.data;
    } catch (error) {
      console.error('Error al obtener turnos:', error);
      throw error;
    }
  }
}

export default TurnoController;