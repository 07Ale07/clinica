import { Turno } from '../odontologo/modelo/turnoModel';

export type RootStackParamList = {
  Login: undefined;
  Odontologo: undefined;
  TurnoScreen: undefined;
  RegistrarPacienteScreen: undefined;
  ListaPacientesScreen: undefined;
  OdontologoDashboard: undefined; // Unique name for odontólogo screen
  DetallePaciente: { paciente: Turno };
  TurnoConsulta: undefined;
};

declare global {
  namespace ReactNavigation {
    interface RootParamList extends RootStackParamList {}
  }
}