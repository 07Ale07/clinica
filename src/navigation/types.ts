import { Turno } from '../odontologo/modelo/turnoModel';

export type RootStackParamList = {
  Login: undefined;
  Odontologo: undefined;
  Turnos: undefined;
  Horarios: undefined;
  Historial: undefined;
  Inventario: undefined;
  TurnoScreen: undefined;
  RegistrarPacienteScreen: undefined;
  ListaPacientesScreen: undefined;
  OdontologoDashboard: undefined;
  DetallePaciente: { paciente: Turno };
  TurnoConsulta: undefined;
  OdontogramaScreen: { idPaciente: number };
  SacarTurno: undefined;
};

declare global {
  namespace ReactNavigation {
    interface RootParamList extends RootStackParamList {}
  }
}