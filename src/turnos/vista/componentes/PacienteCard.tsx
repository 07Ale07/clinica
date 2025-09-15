import React from 'react';
import { View, Text, TouchableOpacity } from 'react-native';
import { Paciente } from '../../modelo/PacienteModel';
import { styles } from '../../css/TurnoStyles';

interface Props {
  paciente: Paciente;
  onSeleccionar: () => void;
}

const PacienteCard: React.FC<Props> = ({ paciente, onSeleccionar }) => {
  return (
    <TouchableOpacity style={styles.card} onPress={onSeleccionar}>
      <Text style={styles.cardTitle}>
        {paciente.persona?.nombre} {paciente.persona?.apellido}
      </Text>
      <Text style={styles.cardText}>DNI: {paciente.persona?.DNI}</Text>
      {paciente.tipo && (
        <Text style={styles.cardText}>Tipo: {paciente.tipo}</Text>
      )}
    </TouchableOpacity>
  );
};

export default PacienteCard;