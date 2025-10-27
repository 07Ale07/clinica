export type RootStackParamList = {
  Login: undefined
  Home: undefined
  Odontologo: undefined
  Recepcionista: undefined
  Turnos: undefined
  Horarios: undefined
  Historial: undefined
  Inventario: undefined
  DetallePaciente: { pacienteId: number }
  TurnoConsulta: undefined
  OdontogramaScreen: { pacienteId: number }
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
