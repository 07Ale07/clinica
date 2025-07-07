import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import Home from './src/views/home';
import SacarTurno from './src/views/sacar_turno';
import ConsultarTurno from './src/views/consultar_turno';

const Stack = createNativeStackNavigator();

export default function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home" screenOptions={{ headerShown: false }}
>
        <Stack.Screen name="Home" component={Home} options={{ title: 'Inicio' }} />
        <Stack.Screen name="SacarTurno" component={SacarTurno} options={{ title: 'Sacar Turno' }} />
        <Stack.Screen name="ConsultarTurno" component={ConsultarTurno} options={{ title: 'Turnos Pendientes' }} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}
