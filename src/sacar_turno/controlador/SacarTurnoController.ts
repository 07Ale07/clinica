import { API_BASE_URL } from '../../services/api';
import { Paciente, Odontologo, Turno } from '../modelo/Paciente';

export async function verificarPaciente(dni: string): Promise<Paciente | null> {
    try {
        console.log('Enviando solicitud a:', `${API_BASE_URL}/api/sacar_turno/verificar_paciente`, 'con DNI:', dni);
        const response = await fetch(`${API_BASE_URL}/api/sacar_turno/verificar_paciente`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ dni }),
        });
        console.log('Respuesta del servidor:', response.status, response.statusText);
        if (!response.ok) {
            const errorData = await response.json();
            console.error('Error del servidor:', errorData);
            throw new Error(errorData.message || 'Error al verificar paciente');
        }
        const data = await response.json();
        console.log('Datos recibidos de la API:', data);
        return data.paciente || null;
    } catch (err) {
        console.error('Error en verificarPaciente:', err);
        throw err;
    }
}

export async function registrarPaciente(paciente: Paciente): Promise<Paciente> {
    const response = await fetch(`${API_BASE_URL}/api/sacar_turno/registrar_paciente`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(paciente),
    });
    if (!response.ok) {
        throw new Error('Error al registrar paciente');
    }
    return response.json();
}

export async function obtenerOdontologos(): Promise<Odontologo[]> {
    const response = await fetch(`${API_BASE_URL}/api/sacar_turno/obtener_odontologos`);
    if (!response.ok) {
        throw new Error('Error al obtener odontólogos');
    }
    return response.json();
}

export async function obtenerHorariosDisponibles(id_odontologo: number, fecha: string): Promise<string[]> {
    const response = await fetch(`${API_BASE_URL}/api/sacar_turno/horarios_disponibles`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_odontologo, fecha }),
    });
    if (!response.ok) {
        throw new Error('Error al obtener horarios disponibles');
    }
    return response.json();
}

export async function confirmarTurno(id_persona: number, turno: Turno): Promise<Turno> {
    const response = await fetch(`${API_BASE_URL}/api/sacar_turno/confirmar_turno`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_persona, ...turno }),
    });
    if (!response.ok) {
        const error = await response.json();
        throw new Error(error.message || 'Error al confirmar turno');
    }
    return response.json();
}