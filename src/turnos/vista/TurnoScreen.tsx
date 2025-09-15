import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../../navigation/types';
import { styles } from '../css/TurnoStyles';

type TurnoScreenNavigationProp = StackNavigationProp<RootStackParamList, 'Turnos'>;

interface Props {
  navigation: TurnoScreenNavigationProp;
}

const TurnoScreen: React.FC<Props> = ({ navigation }) => {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Gestión de Turnos</Text>
      
      <TouchableOpacity 
        style={styles.optionButton}
        onPress={() => navigation.navigate('ListaPacientesScreen')}
      >
        <Text style={styles.optionButtonText}>Elegir Paciente</Text>
      </TouchableOpacity>
      
      <TouchableOpacity 
        style={styles.optionButton}
        onPress={() => navigation.navigate('RegistrarPacienteScreen')}
      >
        <Text style={styles.optionButtonText}>Registrar Nuevo Paciente</Text>
      </TouchableOpacity>
    </View>
  );
};

export default TurnoScreen;