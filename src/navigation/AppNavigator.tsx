// src/navigation/AppNavigator.tsx
import React from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import { NavigationContainer } from '@react-navigation/native';
import LoginView from '../../vistas/LoginView';
import OdontoloVista from '../odontologo/vista/odontologo_vista';
import TurnoScreen from '../turnos/vista/TurnoScreen'; // ⬅️  Importa el componente TurnoScreen
import RegistrarPacienteScreen from '../turnos/vista/RegistrarPacienteScreen'; // ⬅️  Importa el componente TurnoScreen
import ListaPacientesScreen from '../turnos/vista/ListaPacientesScreen'; // ⬅️  Importa el componente TurnoScreen
import { RootStackParamList } from './types';

const Stack = createStackNavigator<RootStackParamList>();

const AppNavigator: React.FC = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Login">
        <Stack.Screen 
          name="Login" 
          component={LoginView} 
          options={{ headerShown: false }}
        />
        <Stack.Screen 
          name="Odontologo" 
          component={OdontoloVista} 
          options={{ title: 'Panel Odontólogo', headerBackTitle: 'Cerrar Sesión' }}
        />
        <Stack.Screen // ⬅️ Añade la nueva pantalla aquí
          name="TurnoScreen"
          component={TurnoScreen}
          options={{ title: 'Crear Turno' }}
        />
        <Stack.Screen // ⬅️ Añade la nueva pantalla aquí
          name="RegistrarPacienteScreen"
          component={RegistrarPacienteScreen}
          options={{ title: 'Crear Turno' }}
        />
         <Stack.Screen // ⬅️ Añade la nueva pantalla aquí
          name="ListaPacientesScreen"
          component={ListaPacientesScreen}
          options={{ title: 'lista' }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default AppNavigator;