import type React from "react"
import { createStackNavigator } from "@react-navigation/stack"
import { createDrawerNavigator } from "@react-navigation/drawer"
import { NavigationContainer } from "@react-navigation/native"
import LandingView from "../landing/vista/LandingView"
import LoginView from "../../vistas/LoginView"
import Odontolo from "../odontologo/vista/Odontologo"
import Turnos from "../odontologo/vista/odontologo_vista"
import Horarios from "../odontologo/vista/horarios"
import Historial from "../odontologo/vista/historial"
import Inventario from "../odontologo/vista/inventario"
import DetallePaciente from "../odontologo/vista/DetallePaciente"
import OdontogramaScreen from "../odontologo/vista/OdontogramaScreen"
import RecepcionistaMain from "../recepcionista/vista/RecepcionistaMain"
import MisHorarios from "../recepcionista/vista/MisHorarios"
import HorarioOdontologos from "../recepcionista/vista/HorarioOdontologos"
import SacarTurnoRecep from "../recepcionista/vista/SacarTurnoRecep"
import Pagos from "../recepcionista/vista/Pagos"
import RegistrarPacientes from "../recepcionista/vista/RegistrarPacientes"
import type { RootStackParamList, RecepStackParamList } from "./types"
import CustomDrawerContent from "./CustomDrawerContent"
import TurnoVista from "../turnos/vista/turno_vista"
import SacarTurnoMain from "../sacar_turno/vista/SacarTurnoMain"
import CustomHeader from "./CustomHeader"

const Stack = createStackNavigator<RootStackParamList>()
const Drawer = createDrawerNavigator()
const RecepStack = createStackNavigator<RecepStackParamList>()

const MainDrawer: React.FC = () => {
  return (
    <Drawer.Navigator
      drawerContent={(props) => <CustomDrawerContent {...props} />}
      screenOptions={{
        drawerStyle: {
          backgroundColor: "#FFFFFF",
          width: 300,
        },
        drawerPosition: "left",
        headerShown: false,
      }}
    >
      <Drawer.Screen name="Odontologo" component={Odontolo} options={{ headerShown: false }} />
      <Drawer.Screen name="SacarTurno" component={SacarTurnoMain} options={{ headerShown: false }} />
      <Drawer.Screen name="Turnos" component={Turnos} options={{ headerShown: false }} />
      <Drawer.Screen name="Horarios" component={Horarios} options={{ headerShown: false }} />
      <Drawer.Screen name="Historial" component={Historial} options={{ headerShown: false }} />
      <Drawer.Screen name="Inventario" component={Inventario} options={{ headerShown: false }} />
    </Drawer.Navigator>
  )
}

const RecepcionisaStackNavigator: React.FC = () => {
  return (
    <RecepStack.Navigator>
      <RecepStack.Screen
        name="RecepcionistaMain"
        component={RecepcionistaMain}
        options={{
          header: () => <CustomHeader title="Recepción" showBackButton={false} showMenuButton={false} />,
        }}
      />
      <RecepStack.Screen
        name="MisHorarios"
        component={MisHorarios}
        options={{
          header: () => <CustomHeader title="Mis Horarios" showBackButton={true} showMenuButton={false} />,
        }}
      />
      <RecepStack.Screen
        name="HorarioOdontologos"
        component={HorarioOdontologos}
        options={{
          header: () => <CustomHeader title="Horario Odontólogos" showBackButton={true} showMenuButton={false} />,
        }}
      />
      <RecepStack.Screen
        name="SacarTurnoRecep"
        component={SacarTurnoRecep}
        options={{
          header: () => <CustomHeader title="Sacar Turno" showBackButton={true} showMenuButton={false} />,
        }}
      />
      <RecepStack.Screen
        name="Pagos"
        component={Pagos}
        options={{
          header: () => <CustomHeader title="Pagos" showBackButton={true} showMenuButton={false} />,
        }}
      />
      <RecepStack.Screen
        name="RegistrarPacientes"
        component={RegistrarPacientes}
        options={{
          header: () => <CustomHeader title="Registrar Pacientes" showBackButton={true} showMenuButton={false} />,
        }}
      />
    </RecepStack.Navigator>
  )
}

const AppNavigator: React.FC = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Landing">
        <Stack.Screen name="Landing" component={LandingView} options={{ headerShown: false }} />
        <Stack.Screen name="Login" component={LoginView} options={{ headerShown: false }} />
        <Stack.Screen name="Odontologo" component={MainDrawer} options={{ headerShown: false }} />
        <Stack.Screen name="Recepcionista" component={RecepcionisaStackNavigator} options={{ headerShown: false }} />
        <Stack.Screen
          name="Turnos"
          component={Turnos}
          options={{
            header: () => <CustomHeader title="Turnos" showBackButton={true} showMenuButton={true} />,
          }}
        />
        <Stack.Screen
          name="Horarios"
          component={Horarios}
          options={{
            header: () => <CustomHeader title="Horarios" showBackButton={true} showMenuButton={true} />,
          }}
        />
        <Stack.Screen
          name="Historial"
          component={Historial}
          options={{
            header: () => <CustomHeader title="Historial" showBackButton={true} showMenuButton={true} />,
          }}
        />
        <Stack.Screen
          name="Inventario"
          component={Inventario}
          options={{
            header: () => <CustomHeader title="Inventario" showBackButton={true} showMenuButton={true} />,
          }}
        />
        <Stack.Screen
          name="DetallePaciente"
          component={DetallePaciente}
          options={{
            header: () => <CustomHeader title="Detalles del Paciente" showMenuButton={false} showBackButton={true} />,
          }}
        />
        <Stack.Screen
          name="TurnoConsulta"
          component={TurnoVista}
          options={{
            header: () => <CustomHeader title="Consulta de Turnos" showMenuButton={false} showBackButton={true} />,
          }}
        />
        <Stack.Screen
          name="OdontogramaScreen"
          component={OdontogramaScreen}
          options={{
            header: () => <CustomHeader title="Odontograma" showMenuButton={false} showBackButton={true} />,
          }}
        />
        <Stack.Screen name="SacarTurno" component={SacarTurnoMain} options={{ headerShown: false }} />
      </Stack.Navigator>
    </NavigationContainer>
  )
}

export default AppNavigator
