import React from 'react';
import { View, Text, StyleSheet, FlatList, TouchableOpacity } from 'react-native';

interface Schedule {
  id: string;
  time: string;
  patient: string;
  procedure: string;
  status: string;
}

const mockSchedules: Schedule[] = [
  { id: '1', time: '2025-08-31 09:00', patient: 'Carlos Sánchez', procedure: 'Ortodoncia', status: 'Confirmado' },
  { id: '2', time: '2025-08-31 11:30', patient: 'Laura Martínez', procedure: 'Blanqueamiento', status: 'Pendiente' },
  { id: '3', time: '2025-09-01 15:00', patient: 'Diego Fernández', procedure: 'Consulta', status: 'Confirmado' },
];

const Horarios: React.FC = () => {
  const renderSchedule = ({ item }: { item: Schedule }) => (
    <View style={styles.scheduleItem}>
      <Text style={styles.scheduleText}>{item.time} - {item.patient}</Text>
      <Text style={styles.scheduleSubText}>{item.procedure} - {item.status}</Text>
      <TouchableOpacity style={styles.editButton}>
        <Text style={styles.editButtonText}>Editar</Text>
      </TouchableOpacity>
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Gestión de Turnos y Horarios</Text>
      <Text style={styles.subtitle}>Administra las citas y horarios de la clínica</Text>
      <FlatList
        data={mockSchedules}
        renderItem={renderSchedule}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.list}
      />
      <TouchableOpacity style={styles.addButton}>
        <Text style={styles.addButtonText}>+ Nuevo Turno</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 10,
  },
  subtitle: {
    fontSize: 18,
    color: '#666',
    marginBottom: 20,
  },
  list: {
    paddingBottom: 20,
  },
  scheduleItem: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 15,
    marginBottom: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  scheduleText: {
    fontSize: 16,
    fontWeight: '600',
    color: '#333',
  },
  scheduleSubText: {
    fontSize: 14,
    color: '#666',
    marginVertical: 5,
  },
  editButton: {
    backgroundColor: '#007bff',
    borderRadius: 5,
    padding: 8,
    alignSelf: 'flex-end',
  },
  editButtonText: {
    color: '#fff',
    fontSize: 14,
  },
  addButton: {
    backgroundColor: '#28a745',
    borderRadius: 10,
    padding: 15,
    alignItems: 'center',
    marginTop: 10,
  },
  addButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default Horarios;