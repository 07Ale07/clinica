import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, TextInput, ActivityIndicator, StyleSheet } from 'react-native';
import { PatientHistory } from '../modelo/historial_modelo';
import { HistorialControl } from '../controlador/historial_controlador';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Feather } from '@expo/vector-icons';
import CustomHeader from '../../navigation/CustomHeader';
import { SafeAreaView } from 'react-native-safe-area-context';

const Historial: React.FC = () => {
  const [search, setSearch] = useState('');
  const [patients, setPatients] = useState<PatientHistory[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchHistorial = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const id_usuario = await AsyncStorage.getItem('id_usuario');
        if (id_usuario) {
          const fetchedPatients = await HistorialControl.getPatientHistory(id_usuario);
          setPatients(fetchedPatients);
        } else {
          setError('No se encontró el ID de usuario. Por favor, vuelva a iniciar sesión.');
        }
      } catch (err) {
        setError(err instanceof Error ? err.message : 'Error desconocido al cargar el historial.');
      } finally {
        setIsLoading(false);
      }
    };

    fetchHistorial();
  }, []);

  const filteredPatients = patients.filter((patient) =>
    patient.name.toLowerCase().includes(search.toLowerCase())
  );

  const renderPatient = ({ item }: { item: PatientHistory }) => (
    <View style={styles.patientItem}>
      <Text style={styles.patientText}>{item.name}</Text>
      <Text style={styles.patientSubText}>Última visita: {item.lastVisit}</Text>
      <Text style={styles.patientSubText}>Diagnóstico: {item.diagnosis}</Text>
    </View>
  );

  return (
    <SafeAreaView style={styles.safeAreaContainer}>
      <CustomHeader title="Historial" showBackButton={true} showMenuButton={true} />
      <View style={styles.container}>
        {isLoading ? (
          <ActivityIndicator size="large" color="#4B9CDB" />
        ) : error ? (
          <Text style={styles.errorText}>{error}</Text>
        ) : (
          <>
            <View style={styles.searchContainer}>
              <Feather name="search" size={24} color="#4B9CDB" style={styles.searchIcon} />
              <TextInput
                style={styles.searchInput}
                placeholder="Buscar paciente..."
                placeholderTextColor="#8A8F9E"
                value={search}
                onChangeText={setSearch}
              />
            </View>
            <FlatList
              data={filteredPatients}
              renderItem={renderPatient}
              keyExtractor={(item) => item.id}
              contentContainerStyle={styles.list}
              ListEmptyComponent={<Text style={styles.noItemsText}>No hay pacientes en el historial.</Text>}
            />
          </>
        )}
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeAreaContainer: {
    flex: 1,
    backgroundColor: '#F7FAFD',
  },
  container: {
    flex: 1,
    padding: 20,
  },
  searchContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#FFFFFF',
    borderRadius: 10,
    paddingHorizontal: 10,
    marginBottom: 20,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
    elevation: 3,
  },
  searchIcon: {
    marginRight: 10,
  },
  searchInput: {
    flex: 1,
    height: 40,
    color: '#333',
  },
  list: {
    paddingBottom: 20,
  },
  patientItem: {
    backgroundColor: '#FFFFFF',
    borderRadius: 10,
    padding: 15,
    marginBottom: 10,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
    elevation: 3,
  },
  patientText: {
    fontSize: 18,
    fontWeight: '600',
    color: '#4B9CDB',
  },
  patientSubText: {
    fontSize: 14,
    color: '#666',
    marginTop: 5,
  },
  errorText: {
    fontSize: 16,
    color: '#FF6B6B',
    textAlign: 'center',
    marginTop: 20,
  },
  noItemsText: {
    fontSize: 16,
    color: '#666',
    textAlign: 'center',
    marginTop: 20,
  },
});

export default Historial;