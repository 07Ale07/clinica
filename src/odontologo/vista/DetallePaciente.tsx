import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import { Ionicons } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import { Turno } from '../modelo/turnoModel';

const DetallePaciente: React.FC = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { paciente } = route.params as { paciente: Turno };

  return (
    <View style={styles.container}>
      <Animatable.View 
        animation="fadeInDown" 
        duration={1000} 
        style={styles.headerContainer}
      >
        <TouchableOpacity 
          style={styles.backButton}
          onPress={() => navigation.goBack()}
        >
          <Ionicons name="arrow-back" size={28} color="#4B9CDB" />
        </TouchableOpacity>
        <Text style={styles.title}>Detalles del Paciente</Text>
      </Animatable.View>

      <Animatable.View 
        animation="fadeInUp" 
        duration={1200} 
        style={styles.card}
      >
        <Text style={styles.cardTitle}>{paciente.nombre_paciente}</Text>
        <View style={styles.detailRow}>
          <Ionicons name="time-outline" size={20} color="#4B9CDB" style={styles.icon} />
          <Text style={styles.detailText}>Hora: {paciente.hora_inicio}</Text>
        </View>
        <View style={styles.detailRow}>
          <Ionicons name="medkit-outline" size={20} color="#4B9CDB" style={styles.icon} />
          <Text style={styles.detailText}>Tipo de cita: {paciente.tipo}</Text>
        </View>
        <View style={styles.detailRow}>
          <Ionicons name="checkmark-circle-outline" size={20} color="#4B9CDB" style={styles.icon} />
          <Text style={styles.detailText}>Estado: {paciente.estado}</Text>
        </View>
      </Animatable.View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA', // Light blue background
    padding: 20,
  },
  headerContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 20,
  },
  backButton: {
    padding: 10,
  },
  title: {
    fontSize: 28,
    fontWeight: '700',
    color: '#1B2C40',
    flex: 1,
    textAlign: 'center',
    textShadowColor: 'rgba(0, 0, 0, 0.1)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 3,
  },
  card: {
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    padding: 20,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 5,
    borderLeftWidth: 4,
    borderLeftColor: '#4B9CDB',
  },
  cardTitle: {
    fontSize: 24,
    fontWeight: '600',
    color: '#1B2C40',
    marginBottom: 15,
  },
  detailRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 10,
  },
  icon: {
    marginRight: 10,
  },
  detailText: {
    fontSize: 16,
    color: '#6A7A8A',
  },
});

export default DetallePaciente;