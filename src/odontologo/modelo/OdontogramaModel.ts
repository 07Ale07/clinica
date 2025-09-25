// odontologo/modelo/OdontogramaModel.ts
export interface Odontograma {
    id_odontograma: number;
    id_paciente: number;
    odontograma: string; // Probablemente JSON stringificado con estado de dientes
    hecho: boolean;
    fecha_inicio: string;
    fecha_fin?: string;
    fecha_actualizacion: string;
  }