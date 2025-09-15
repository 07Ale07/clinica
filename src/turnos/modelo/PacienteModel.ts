export interface Persona {
    id_persona?: number;
    nombre: string;
    apellido: string;
    DNI: string;
  }
  
  export interface Paciente {
    id_paciente?: number;
    id_persona: number;
    fecha_registro?: string;
    tipo?: 'adulto' | 'menor' | 'geriatrico';
    alergias?: string;
    observaciones_generales?: string;
    foto?: any;
    activo?: boolean;
    persona?: Persona;
  }
  
  export interface ObraSocial {
    id_obra_social?: number;
    nombre: string;
    codigo_nacional?: string;
    cuit?: string;
    telefono?: string;
    email?: string;
    direccion?: string;
    activo?: boolean;
  }
  
  export interface ObraPersona {
    id_obra_persona?: number;
    id_persona: number;
    id_obra_social: number;
    numero_afiliado: string;
    plan?: string;
    fecha_alta?: string;
    fecha_baja?: string;
    titular?: boolean;
    parentesco?: string;
    activo?: boolean;
    obra_social?: ObraSocial;
  }
  
  export interface Familiar {
    id_familiar?: number;
    id_grupo?: number;
    id_paciente: number;
    parentesco: string;
    responsable: boolean;
    paciente?: Paciente;
  }