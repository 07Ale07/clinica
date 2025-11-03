import type { Turno } from "../odontologo/modelo/turnoModel"

export type RootStackParamList = {
  Landing: undefined
  Login: undefined
  Odontologo: undefined
  Recepcionista: undefined
  Turnos: undefined
  Horarios: undefined
  Historial: undefined
  id_paciente: undefined
  Inventario: undefined
  TurnoScreen: undefined
  RegistrarPacienteScreen: undefined
  ListaPacientesScreen: undefined
  OdontologoDashboard: undefined
  DetallePaciente: { paciente: Turno }
  TurnoConsulta: undefined
  OdontogramaScreen: { idPaciente: number }
  SacarTurno: undefined
}

export type RecepStackParamList = {
  RecepcionistaMain: undefined
  MisHorarios: undefined
  HorarioOdontologos: undefined
  SacarTurnoRecep: undefined
  Pagos: undefined
  RegistrarPacientes: undefined
}

declare global {
  namespace ReactNavigation {
    interface RootParamList extends RootStackParamList {}
  }
}
