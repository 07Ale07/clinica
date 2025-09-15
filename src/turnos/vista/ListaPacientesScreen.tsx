import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, ActivityIndicator, Alert } from 'react-native';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../../navigation/types';
import TurnoController from '../controlador/TurnoController';
import { Paciente } from '../modelo/PacienteModel';
import PacienteCard from './componentes/PacienteCard';
import BuscadorPacientes from './componentes/BuscadorPacientes';
import { styles } from '../css/TurnoStyles';

type ListaPacientesScreenNavigationProp = StackNavigationProp<RootStackParamList, 'ListaPacientesScreen'>;

interface Props {
  navigation: ListaPacientesScreenNavigationProp;
}

const ListaPacientesScreen: React.FC<Props> = ({ navigation }) => {
  const [pacientes, setPacientes] = useState<Paciente[]>([]);
  const [pacientesFiltrados, setPacientesFiltrados] = useState<Paciente[]>([]);
  const [cargando, setCargando] = useState(true);

  useEffect(() => {
    cargarPacientes();
  }, []);

  const cargarPacientes = async () => {
    try {
      setCargando(true);
      const datosPacientes = await TurnoController.obtenerPacientes();
      setPacientes(datosPacientes);
      setPacientesFiltrados(datosPacientes);
    } catch (error) {
      Alert.alert('Error', 'No se pudieron cargar los pacientes');
      console.error(error);
    } finally {
      setCargando(false);
    }
  };

  const buscarPacientes = async (termino: string) => {
    if (!termino) {
      setPacientesFiltrados(pacientes);
      return;
    }

    try {
      const resultados = await TurnoController.buscarPacientes(termino);
      setPacientesFiltrados(resultados);
    } catch (error) {
      Alert.alert('Error', 'No se pudo realizar la búsqueda');
      console.error(error);
    }
  };

  const seleccionarPaciente = (paciente: Paciente) => {
    // Navegar a la pantalla de creación de turno con el paciente seleccionado
    navigation.navigate('CrearTurno', { paciente });
  };

  if (cargando) {
    return (
      <View style={styles.centerContainer}>
        <ActivityIndicator size="large" color="#0000ff" />
        <Text>Cargando pacientes...</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Seleccionar Paciente</Text>
      
      <BuscadorPacientes onBuscar={buscarPacientes} />
      
      <FlatList
        data={pacientesFiltrados}
        keyExtractor={(item) => item.id_paciente?.toString() || Math.random().toString()}
        renderItem={({ item }) => (
          <PacienteCard 
            paciente={item} 
            onSeleccionar={() => seleccionarPaciente(item)}
          />
        )}
        ListEmptyComponent={
          <Text style={styles.emptyText}>No se encontraron pacientes</Text>
        }
      />
    </View>
  );
};

export default ListaPacientesScreen;