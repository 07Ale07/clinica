import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, TextInput, ActivityIndicator } from 'react-native';
import { PatientHistory } from '../modelo/historial_modelo';
import { HistorialControl } from '../controlador/historial_controlador';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Feather } from '@expo/vector-icons';
import { styles } from '../css/historialStyles';

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

  if (isLoading) {
    return (
      <View style={styles.container}>
        <ActivityIndicator size="large" color="#4B9CDB" />
      </View>
    );
  }

  if (error) {
    return (
      <View style={styles.container}>
        <Text style={styles.errorText}>{error}</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
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
    </View>
  );
};

export default Historial;