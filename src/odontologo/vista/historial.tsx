import React, { useState } from 'react';
import { View, Text, StyleSheet, FlatList, TouchableOpacity, TextInput } from 'react-native';

interface Patient {
  id: string;
  name: string;
  lastVisit: string;
  diagnosis: string;
}

const mockPatients: Patient[] = [
  { id: '1', name: 'Sofía Ramírez', lastVisit: '2025-08-15', diagnosis: 'Caries tratada' },
  { id: '2', name: 'Pedro Alvarez', lastVisit: '2025-07-20', diagnosis: 'Ortodoncia en curso' },
  { id: '3', name: 'Lucía Torres', lastVisit: '2025-06-10', diagnosis: 'Limpieza dental' },
];

const Historial: React.FC = () => {
  const [search, setSearch] = useState('');

  const filteredPatients = mockPatients.filter((patient) =>
    patient.name.toLowerCase().includes(search.toLowerCase())
  );

  const renderPatient = ({ item }: { item: Patient }) => (
    <View style={styles.patientItem}>
      <Text style={styles.patientText}>{item.name}</Text>
      <Text style={styles.patientSubText}>Última visita: {item.lastVisit}</Text>
      <Text style={styles.patientSubText}>Diagnóstico: {item.diagnosis}</Text>
      <TouchableOpacity style={styles.viewButton}>
        <Text style={styles.viewButtonText}>Ver Detalles</Text>
      </TouchableOpacity>
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Historial de Mis Pacientes</Text>
      <Text style={styles.subtitle}>Busca y revisa el historial médico de tus pacientes</Text>
      <TextInput
        style={styles.searchInput}
        placeholder="Buscar paciente..."
        value={search}
        onChangeText={setSearch}
      />
      <FlatList
        data={filteredPatients}
        renderItem={renderPatient}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.list}
      />
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
  searchInput: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 10,
    fontSize: 16,
    marginBottom: 20,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  list: {
    paddingBottom: 20,
  },
  patientItem: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 15,
    marginBottom: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  patientText: {
    fontSize: 16,
    fontWeight: '600',
    color: '#333',
  },
  patientSubText: {
    fontSize: 14,
    color: '#666',
    marginVertical: 5,
  },
  viewButton: {
    backgroundColor: '#007bff',
    borderRadius: 5,
    padding: 8,
    alignSelf: 'flex-end',
  },
  viewButtonText: {
    color: '#fff',
    fontSize: 14,
  },
});

export default Historial;