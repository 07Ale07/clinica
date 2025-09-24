import React from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { NavigationContainer } from '@react-navigation/native';
import LoginView from '../../vistas/LoginView';
import OdontoloVista from '../odontologo/vista/odontologo_vista';
import DetallePaciente from '../odontologo/vista/DetallePaciente';
import { RootStackParamList } from './types';
import CustomDrawerContent from './CustomDrawerContent';
import TurnoVista from '../turnos/vista/turno_vista';

const Stack = createStackNavigator<RootStackParamList>();
const Drawer = createDrawerNavigator();

const MainDrawer: React.FC = () => {
  return (
    <Drawer.Navigator
      drawerContent={(props) => <CustomDrawerContent {...props} />}
      screenOptions={{
        drawerStyle: {
          backgroundColor: '#FFFFFF',
          width: 300,
        },
        drawerPosition: 'left',
        headerShown: false,
      }}
    >
      <Drawer.Screen name="Odontologo" component={OdontoloVista} />
    </Drawer.Navigator>
  );
};

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
          component={MainDrawer} 
          options={{ headerShown: false }}
        />
        <Stack.Screen 
          name="DetallePaciente"
          component={DetallePaciente}
          options={{ title: 'Detalles del Paciente' }}
        />
        <Stack.Screen 
          name="TurnoConsulta"
          component={TurnoVista}
          options={{ title: 'Consultar Turno' }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default AppNavigator;