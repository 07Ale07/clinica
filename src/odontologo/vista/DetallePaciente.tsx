// odontologo/vista/DetallePaciente.tsx
import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView, Alert } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import { Ionicons } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import { Turno } from '../modelo/turnoModel';
import { usePacienteDetails } from '../modelo/usePacienteDetails';

const DetallePaciente: React.FC = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { paciente: turno } = route.params as { paciente: Turno };
  const { paciente, familiares, citasAnteriores, loading, error } = usePacienteDetails(turno);

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <Animatable.Text animation="pulse" style={styles.loadingText}>Cargando detalles...</Animatable.Text>
      </View>
    );
  }

  if (error) {
    Alert.alert('Error', error);
  }

  const fullName = paciente?.persona ? `${paciente.persona.nombre} ${paciente.persona.apellido}` : turno.nombre_paciente;

  const navigateToOdontograma = () => {
    if (!turno.id_paciente) {
      Alert.alert('Error', 'ID de paciente no disponible');
      return;
    }
    navigation.navigate('OdontogramaScreen', { idPaciente: turno.id_paciente });
  };

  return (
    <ScrollView style={styles.container}>
      <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
        <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
          <Ionicons name="arrow-back" size={28} color="#4B9CDB" />
        </TouchableOpacity>
        <Text style={styles.title}>Detalles del Paciente</Text>
      </Animatable.View>

      <Animatable.View animation="fadeInUp" duration={1200} style={styles.card}>
        <Text style={styles.cardTitle}>{fullName}</Text>
        <View style={styles.detailRow}>
          <Ionicons name="time-outline" size={20} color="#4B9CDB" style={styles.icon} />
          <Text style={styles.detailText}>Hora: {turno.hora_inicio}</Text>
        </View>
        <View style={styles.detailRow}>
          <Ionicons name="medkit-outline" size={20} color="#4B9CDB" style={styles.icon} />
          <Text style={styles.detailText}>Tipo de cita: {turno.tipo}</Text>
        </View>
        <View style={styles.detailRow}>
          <Ionicons name="checkmark-circle-outline" size={20} color="#4B9CDB" style={styles.icon} />
          <Text style={styles.detailText}>Estado: {turno.estado}</Text>
        </View>

        {/* Alergias y Observaciones */}
        {paciente && (
          <>
            <View style={styles.sectionDivider} />
            <Text style={styles.sectionTitle}>Información General</Text>
            <View style={styles.detailRow}>
              <Ionicons name="alert-circle-outline" size={20} color="#4B9CDB" style={styles.icon} />
              <Text style={styles.detailText}>Alergias: {paciente.alergias || 'Ninguna'}</Text>
            </View>
            <View style={styles.detailRow}>
              <Ionicons name="document-text-outline" size={20} color="#4B9CDB" style={styles.icon} />
              <Text style={styles.detailText}>Observaciones: {paciente.observaciones_generales || 'Ninguna'}</Text>
            </View>
          </>
        )}

        {/* Botón Odontograma */}
        <TouchableOpacity style={styles.button} onPress={navigateToOdontograma}>
          <Ionicons name="grid-outline" size={20} color="#FFF" style={styles.buttonIcon} />
          <Text style={styles.buttonText}>Ver Odontograma</Text>
        </TouchableOpacity>

        {/* Familiares */}
        <View style={styles.sectionDivider} />
        <Text style={styles.sectionTitle}>Familiares</Text>
        {familiares.length > 0 ? (
          familiares.map((familiar) => (
            <View key={familiar.id_familiar || familiar.nombre} style={styles.listItem}>
              <Text style={styles.listText}>{familiar.nombre} {familiar.apellido} ({familiar.relacion})</Text>
            </View>
          ))
        ) : (
          <Text style={styles.detailText}>No hay familiares registrados</Text>
        )}

        {/* Citas Anteriores */}
        <View style={styles.sectionDivider} />
        <Text style={styles.sectionTitle}>Citas Anteriores</Text>
        {citasAnteriores.length > 0 ? (
          citasAnteriores.map((cita) => (
            <View key={cita.id_cita} style={styles.listItem}>
              <Text style={styles.listText}>{cita.fecha} - {cita.tipo} ({cita.estado})</Text>
              {cita.descripcion && <Text style={styles.smallText}>{cita.descripcion}</Text>}
            </View>
          ))
        ) : (
          <Text style={styles.detailText}>No hay citas anteriores</Text>
        )}
      </Animatable.View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA',
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loadingText: {
    fontSize: 18,
    color: '#4B9CDB',
  },
  headerContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 20,
    padding: 20,
    backgroundColor: '#E6F0FA',
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
    margin: 20,
  },
  cardTitle: {
    fontSize: 24,
    fontWeight: '600',
    color: '#1B2C40',
    marginBottom: 15,
    textAlign: 'center',
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
    flex: 1,
  },
  sectionDivider: {
    height: 1,
    backgroundColor: '#E0E0E0',
    marginVertical: 15,
  },
  sectionTitle: {
    fontSize: 20,
    fontWeight: '600',
    color: '#1B2C40',
    marginBottom: 10,
  },
  listItem: {
    backgroundColor: '#F8F9FA',
    padding: 10,
    borderRadius: 8,
    marginBottom: 5,
  },
  listText: {
    fontSize: 16,
    color: '#1B2C40',
  },
  smallText: {
    fontSize: 14,
    color: '#6A7A8A',
    marginTop: 2,
  },
  button: {
    flexDirection: 'row',
    backgroundColor: '#4B9CDB',
    padding: 12,
    borderRadius: 8,
    alignItems: 'center',
    justifyContent: 'center',
    marginVertical: 10,
  },
  buttonIcon: {
    marginRight: 8,
  },
  buttonText: {
    color: '#FFF',
    fontSize: 16,
    fontWeight: '600',
  },
});

export default DetallePaciente;