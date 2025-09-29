export interface Paciente {
    id_persona?: number;
    nombre: string;
    apellido: string;
    fecha_nac: string; // Formato YYYY-MM-DD
    dni: string;
    email?: string;
}

export interface Odontologo {
    id_persona: number;
    nombre: string;
    apellido: string;
    id_empleado: number;
}

export interface Turno {
    id_odontologo: number;
    fecha: string; // YYYY-MM-DD
    hora: string; // HH:MM
    email?: string;
}