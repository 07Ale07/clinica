// odontologo/modelo/OdontogramaModel.ts
export interface OdontogramaData {
  [key: number]: string; // e.g., { 11: 'caries', 12: 'sano' }
}

export interface Odontograma {
  id_odontograma?: number;
  id_paciente: number;
  odontograma: OdontogramaData;
  fecha_actualizacion?: string;
}

export const toothNames: { [key: number]: string } = {
  11: "Incisivo central superior derecho",
  12: "Incisivo lateral superior derecho",
  13: "Canino superior derecho",
  14: "Primer premolar superior derecho",
  15: "Segundo premolar superior derecho",
  16: "Primer molar superior derecho",
  17: "Segundo molar superior derecho",
  18: "Tercer molar superior derecho",
  21: "Incisivo central superior izquierdo",
  22: "Incisivo lateral superior izquierdo",
  23: "Canino superior izquierdo",
  24: "Primer premolar superior izquierdo",
  25: "Segundo premolar superior izquierdo",
  26: "Primer molar superior izquierdo",
  27: "Segundo molar superior izquierdo",
  28: "Tercer molar superior izquierdo",
  31: "Incisivo central inferior izquierdo",
  32: "Incisivo lateral inferior izquierdo",
  33: "Canino inferior izquierdo",
  34: "Primer premolar inferior izquierdo",
  35: "Segundo premolar inferior izquierdo",
  36: "Primer molar inferior izquierdo",
  37: "Segundo molar inferior izquierdo",
  38: "Tercer molar inferior izquierdo",
  41: "Incisivo central inferior derecho",
  42: "Incisivo lateral inferior derecho",
  43: "Canino inferior derecho",
  44: "Primer premolar inferior derecho",
  45: "Segundo premolar inferior derecho",
  46: "Primer molar inferior derecho",
  47: "Segundo molar inferior derecho",
  48: "Tercer molar inferior derecho"
};

export const procedureNames: { [key: string]: string } = {
  sano: "Sano (sin tratamiento)",
  caries: "Caries (necesita tratamiento)",
  restauracion: "Restauración (ya tratado)"
};

export const teethNumbers: number[] = [
  18, 17, 16, 15, 14, 13, 12, 11,
  21, 22, 23, 24, 25, 26, 27, 28,
  48, 47, 46, 45, 44, 43, 42, 41,
  31, 32, 33, 34, 35, 36, 37, 38
];