// screens/DetallePaciente.tsx
import React from 'react';
import {
  View,
  Text,
  TouchableOpacity,
  StyleSheet,
  ScrollView,
  Alert,
  StatusBar,
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import type { NativeStackNavigationProp } from '@react-navigation/native-stack';
import { Ionicons } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import { usePacienteDetails } from '../modelo/usePacienteDetails';
import { RootStackParamList } from '../../navigation/types';
import { useSafeAreaInsets } from 'react-native-safe-area-context';
import { format, parseISO } from 'date-fns';
import { es } from 'date-fns/locale';

type DetallePacienteParams = {
  id_paciente: number;
  turnoActual?: {
    hora_inicio: string;
    tipo: string;
    estado: string;
    nombre_paciente?: string;
  };
};

const DetallePaciente: React.FC = () => {
  const navigation = useNavigation<NativeStackNavigationProp<RootStackParamList>>();
  const route = useRoute();
  const { id_paciente, turnoActual } = route.params as DetallePacienteParams;
  const insets = useSafeAreaInsets();

  const { paciente, familiares, citasAnteriores, loading, error } = usePacienteDetails({
    id_paciente,
    turnoActual,
  });

  if (loading) {
    return (
      <View style={[styles.safeAreaContainer, { paddingTop: insets.top }]}>
        <View style={styles.loadingContainer}>
          <Animatable.Text animation="pulse" iterationCount="infinite" style={styles.loadingText}>
            Cargando detalles...
          </Animatable.Text>
        </View>
      </View>
    );
  }

  if (error) {
    Alert.alert('Error', error);
    return null;
  }

  const fullName = paciente
    ? `${paciente.nombre} ${paciente.apellido}`
    : turnoActual?.nombre_paciente || 'Paciente';

  const navigateToOdontograma = () => {
    navigation.navigate('OdontogramaScreen', { idPaciente: id_paciente });
  };

  const formatDate = (dateString: string) => {
    try {
      return format(parseISO(dateString), "EEEE d 'de' MMMM yyyy", { locale: es });
    } catch {
      return dateString;
    }
  };

  const formatTime = (dateTimeString: string) => {
    try {
      return format(parseISO(dateTimeString), 'HH:mm', { locale: es });
    } catch {
      return dateTimeString;
    }
  };

  return (
    <View style={[styles.safeAreaContainer, { paddingTop: insets.top }]}>
      <StatusBar barStyle="dark-content" backgroundColor="#FFFFFF" />

      <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
        <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
          <Ionicons name="chevron-back" size={28} color="#1B2C40" />
        </TouchableOpacity>
        <Text style={styles.title}>Detalles del Paciente</Text>
        <View style={styles.placeholder} />
      </Animatable.View>

      <ScrollView
        style={styles.scrollViewContent}
        contentContainerStyle={{ paddingBottom: insets.bottom + 20 }}
      >
        <Animatable.View animation="fadeInUp" duration={1200} style={styles.card}>
          <Text style={styles.cardTitle}>{fullName}</Text>

          {paciente && (
            <View style={styles.detailRow}>
              <Ionicons name="card-outline" size={20} color="#4B9CDB" style={styles.icon} />
              <Text style={styles.detailText}>DNI: {paciente.DNI}</Text>
            </View>
          )}

          {turnoActual && (
            <>
              <View style={styles.detailRow}>
                <Ionicons name="time-outline" size={20} color="#4B9CDB" style={styles.icon} />
                <Text style={styles.detailText}>Hora: {formatTime(turnoActual.hora_inicio)}</Text>
              </View>
              <View style={styles.detailRow}>
                <Ionicons name="medkit-outline" size={20} color="#4B9CDB" style={styles.icon} />
                <Text style={styles.detailText}>Tipo: {turnoActual.tipo}</Text>
              </View>
              <View style={styles.detailRow}>
                <Ionicons name="checkmark-circle-outline" size={20} color="#4B9CDB" style={styles.icon} />
                <Text style={styles.detailText}>Estado: {turnoActual.estado}</Text>
              </View>
            </>
          )}

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
                <Text style={styles.detailText}>
                  Observaciones: {paciente.observaciones_generales || 'Ninguna'}
                </Text>
              </View>
            </>
          )}

          <TouchableOpacity style={styles.button} onPress={navigateToOdontograma}>
            <Ionicons name="grid-outline" size={20} color="#FFF" style={styles.buttonIcon} />
            <Text style={styles.buttonText}>Ver Odontograma</Text>
          </TouchableOpacity>

          <View style={styles.sectionDivider} />
          <Text style={styles.sectionTitle}>Familiares</Text>
          {familiares.length > 0 ? (
            familiares.map((f) => (
              <View key={f.id_familiar} style={styles.listItem}>
                <Text style={styles.listText}>Parentesco: {f.parentesco || 'Desconocido'}</Text>
                <Text style={styles.smallText}>
                  Responsable: {f.responsable === 1 ? 'Sí' : 'No'}
                </Text>
              </View>
            ))
          ) : (
            <Text style={styles.detailText}>No hay familiares</Text>
          )}

          <View style={styles.sectionDivider} />
          <Text style={styles.sectionTitle}>Citas Anteriores</Text>
          {citasAnteriores.length > 0 ? (
            citasAnteriores.map((c) => (
              <View key={c.id_cita} style={styles.listItem}>
                <Text style={styles.listText}>
                  {formatDate(c.fecha)} - {c.tipo}{' '}
                  <Text style={{ color: c.estado === 'completada' ? '#4CAF50' : '#FF9800', fontWeight: 'bold' }}>
                    ({c.estado})
                  </Text>
                </Text>
                {c.descripcion && <Text style={styles.smallText}>Obs: {c.descripcion}</Text>}
              </View>
            ))
          ) : (
            <Text style={styles.detailText}>No hay citas anteriores</Text>
          )}
        </Animatable.View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  safeAreaContainer: { flex: 1, backgroundColor: '#FFFFFF' },
  scrollViewContent: { flex: 1, backgroundColor: '#E6F0FA' },
  loadingContainer: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#E6F0FA' },
  loadingText: { fontSize: 18, color: '#4B9CDB' },
  headerContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 15,
    paddingVertical: 10,
    backgroundColor: '#FFFFFF',
    borderBottomWidth: 1,
    borderBottomColor: '#E0E0E0',
  },
  backButton: { padding: 5 },
  title: { fontSize: 18, fontWeight: '600', color: '#1B2C40' },
  placeholder: { width: 38 },
  card: {
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    padding: 20,
    margin: 20,
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
    textAlign: 'center',
    borderBottomWidth: 1,
    borderBottomColor: '#E0E0E0',
    paddingBottom: 10,
  },
  detailRow: { flexDirection: 'row', alignItems: 'center', marginBottom: 10 },
  icon: { marginRight: 10 },
  detailText: { fontSize: 16, color: '#6A7A8A', flex: 1 },
  sectionDivider: { height: 1, backgroundColor: '#E0E0E0', marginVertical: 15 },
  sectionTitle: { fontSize: 20, fontWeight: '600', color: '#1B2C40', marginBottom: 10 },
  listItem: {
    backgroundColor: '#F8F9FA',
    padding: 10,
    borderRadius: 8,
    marginBottom: 5,
    borderLeftWidth: 3,
    borderLeftColor: '#4B9CDB50',
  },
  listText: { fontSize: 16, color: '#1B2C40', fontWeight: '500' },
  smallText: { fontSize: 14, color: '#6A7A8A', marginTop: 2 },
  button: {
    flexDirection: 'row',
    backgroundColor: '#4B9CDB',
    padding: 12,
    borderRadius: 8,
    alignItems: 'center',
    justifyContent: 'center',
    marginVertical: 10,
    shadowColor: '#4B9CDB',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 4,
    elevation: 5,
  },
  buttonIcon: { marginRight: 8 },
  buttonText: { color: '#FFF', fontSize: 16, fontWeight: '600' },
});

export default DetallePaciente;