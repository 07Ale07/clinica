// src/navigation/types.ts
export type RootStackParamList = {
    Login: undefined;
    Odontologo: undefined;
    TurnoScreen: undefined;
    RegistrarPacienteScreen: undefined;
    ListaPacientesScreen: undefined;
    // Puedes agregar más rutas aquí según necesites
  };
  
  // Extiende los tipos de navegación por defecto
  declare global {
    namespace ReactNavigation {
      interface RootParamList extends RootStackParamList {}
    }
  }