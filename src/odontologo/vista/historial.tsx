// screens/historial.tsx
import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  FlatList,
  TextInput,
  ActivityIndicator,
  StyleSheet,
  TouchableOpacity,
} from 'react-native';
import { PatientHistory } from '../modelo/historial_modelo';
import { HistorialControl } from '../controlador/historial_controlador';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Feather, Ionicons } from '@expo/vector-icons';
import CustomHeader from '../../navigation/CustomHeader';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../../navigation/types';

type HistorialNavProp = StackNavigationProp<RootStackParamList, 'Historial'>;

const Historial: React.FC = () => {
  const navigation = useNavigation<HistorialNavProp>();
  const [search, setSearch] = useState('');
  const [patients, setPatients] = useState<PatientHistory[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchHistorial = async () => {
      setIsLoading(true);
      try {
        const id_usuario = await AsyncStorage.getItem('id_usuario');
        if (id_usuario) {
          const data = await HistorialControl.getPatientHistory(id_usuario);
          setPatients(data);
        } else {
          setError('Sesión no encontrada');
        }
      } catch (err: any) {
        setError(err.message);
      } finally {
        setIsLoading(false);
      }
    };
    fetchHistorial();
  }, []);

  const filtered = patients.filter((p) =>
    p.name.toLowerCase().includes(search.toLowerCase())
  );

  const handlePress = (patient: PatientHistory) => {
    navigation.navigate('DetallePaciente', {
      id_paciente: parseInt(patient.id),
    });
  };

  const renderItem = ({ item }: { item: PatientHistory }) => (
    <TouchableOpacity style={styles.patientItem} onPress={() => handlePress(item)}>
      <View style={styles.patientContent}>
        <View>
          <Text style={styles.patientText}>{item.name}</Text>
          <Text style={styles.patientSubText}>Última: {item.lastVisit}</Text>
          <Text style={styles.patientSubText}>Dx: {item.diagnosis}</Text>
        </View>
        <Ionicons name="chevron-forward" size={24} color="#4B9CDB" />
      </View>
    </TouchableOpacity>
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
                value={search}
                onChangeText={setSearch}
              />
            </View>
            <FlatList
              data={filtered}
              renderItem={renderItem}
              keyExtractor={(item) => item.id}
              contentContainerStyle={styles.list}
              ListEmptyComponent={<Text style={styles.noItemsText}>Sin pacientes</Text>}
            />
          </>
        )}
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeAreaContainer: { flex: 1, backgroundColor: '#F7FAFD' },
  container: { flex: 1, padding: 20 },
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
  searchIcon: { marginRight: 10 },
  searchInput: { flex: 1, height: 40, color: '#333' },
  list: { paddingBottom: 20 },
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
  patientContent: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center' },
  patientText: { fontSize: 18, fontWeight: '600', color: '#4B9CDB' },
  patientSubText: { fontSize: 14, color: '#666', marginTop: 5 },
  errorText: { fontSize: 16, color: '#FF6B6B', textAlign: 'center', marginTop: 20 },
  noItemsText: { fontSize: 16, color: '#666', textAlign: 'center', marginTop: 20 },
});

export default Historial;