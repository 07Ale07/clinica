import React from 'react';
import { 
  View, 
  Text, 
  TouchableOpacity, 
  StyleSheet, 
  ScrollView, 
  Alert, 
  Platform, 
  StatusBar 
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import type { NativeStackNavigationProp } from '@react-navigation/native-stack';
import { Ionicons } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import { Turno } from '../modelo/turnoModel';
import { usePacienteDetails } from '../modelo/usePacienteDetails';
import { RootStackParamList } from '../../navigation/types';
import { useSafeAreaInsets } from 'react-native-safe-area-context';
import { format, parseISO } from 'date-fns';
import { es } from 'date-fns/locale';

const DetallePaciente: React.FC = () => {
  const navigation = useNavigation<NativeStackNavigationProp<RootStackParamList>>();
  const route = useRoute();
  const { paciente: turno } = route.params as { paciente: Turno }; 
  const insets = useSafeAreaInsets();

  console.log('ID del paciente desde turno (id_paciente):', turno.id_paciente);

  const { paciente, familiares, citasAnteriores, loading, error } = usePacienteDetails(turno);

  if (loading) {
    return (
      <View style={[styles.safeAreaContainer, { paddingTop: insets.top, paddingBottom: insets.bottom }]}>
        <View style={styles.loadingContainer}>
          <Animatable.Text animation="pulse" easing="ease-in-out" iterationCount="infinite" style={styles.loadingText}>
            Cargando detalles...
          </Animatable.Text>
        </View>
      </View>
    );
  }

  if (error) {
    Alert.alert('Error de Carga', error);
  }

  const fullName = paciente 
    ? `${paciente.nombre} ${paciente.apellido}` 
    : turno.nombre_paciente; 

  const navigateToOdontograma = () => {
    if (!turno.id_paciente) {
      console.log('Error: ID del paciente (id_paciente) no disponible');
      Alert.alert('Error', 'ID de paciente no disponible para el Odontograma.');
      return;
    }

    console.log('ID del paciente para OdontogramaScreen (idPaciente):', turno.id_paciente);
    navigation.navigate('OdontogramaScreen', { idPaciente: turno.id_paciente });
  };

  // Función para formatear la fecha
  const formatDate = (dateString: string) => {
    try {
      const date = parseISO(dateString);
      return format(date, "EEEE d 'de' MMMM yyyy", { locale: es });
    } catch (e) {
      console.error('Error al parsear la fecha:', e);
      return dateString;
    }
  };

  // Función para formatear la hora
  const formatTime = (dateTimeString: string) => {
    try {
      const date = parseISO(dateTimeString);
      return format(date, "HH:mm", { locale: es });
    } catch (e) {
      console.error('Error al parsear la hora:', e);
      return dateTimeString; // Fallback en caso de error
    }
  };

  return (
    <View style={[styles.safeAreaContainer, { paddingTop: insets.top, paddingBottom: insets.bottom }]}>
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
        contentContainerStyle={[styles.scrollViewContentContainer, { paddingBottom: insets.bottom + 20 }]}
      >
        <Animatable.View animation="fadeInUp" duration={1200} style={styles.card}>
          <Text style={styles.cardTitle}>{fullName}</Text>
          
          {paciente && (
              <View style={styles.detailRow}>
                <Ionicons name="card-outline" size={20} color="#4B9CDB" style={styles.icon} />
                <Text style={styles.detailText}>DNI: {paciente.DNI}</Text>
              </View>
            )}

          <View style={styles.detailRow}>
            <Ionicons name="time-outline" size={20} color="#4B9CDB" style={styles.icon} />
            <Text style={styles.detailText}>Hora: {formatTime(turno.hora_inicio)}</Text>
          </View>
          <View style={styles.detailRow}>
            <Ionicons name="medkit-outline" size={20} color="#4B9CDB" style={styles.icon} />
            <Text style={styles.detailText}>Tipo de cita: {turno.tipo}</Text>
          </View>
          <View style={styles.detailRow}>
            <Ionicons name="checkmark-circle-outline" size={20} color="#4B9CDB" style={styles.icon} />
            <Text style={styles.detailText}>Estado: {turno.estado}</Text>
          </View>

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

          <TouchableOpacity style={styles.button} onPress={navigateToOdontograma}>
            <Ionicons name="grid-outline" size={20} color="#FFF" style={styles.buttonIcon} />
            <Text style={styles.buttonText}>Ver Odontograma</Text>
          </TouchableOpacity>

          <View style={styles.sectionDivider} />
          <Text style={styles.sectionTitle}>Familiares (Relación)</Text>
          {familiares.length > 0 ? (
            familiares.map((familiar) => (
              <View key={familiar.id_familiar} style={styles.listItem}> 
                <Text style={styles.listText}>Parentesco: {familiar.parentesco || 'Desconocido'}</Text>
                <Text style={styles.smallText}>Responsable: {familiar.responsable === 1 ? 'Sí' : 'No'}</Text>
              </View>
            ))
          ) : (
            <Text style={styles.detailText}>No hay familiares registrados</Text>
          )}

          <View style={styles.sectionDivider} />
          <Text style={styles.sectionTitle}>Citas Anteriores</Text>
          {citasAnteriores.length > 0 ? (
            citasAnteriores.map((cita) => (
              <View key={cita.id_cita} style={styles.listItem}>
                <Text style={styles.listText}>
                  {formatDate(cita.fecha)} - {cita.tipo} 
                  <Text style={{ color: cita.estado === 'completada' ? '#4CAF50' : '#FF9800', fontWeight: 'bold' }}>
                      {' '}({cita.estado})
                  </Text>
                </Text>
                {cita.descripcion && <Text style={styles.smallText}>Obs: {cita.descripcion}</Text>}
              </View>
            ))
          ) : (
            <Text style={styles.detailText}>No hay citas anteriores registradas</Text>
          )}
        </Animatable.View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  safeAreaContainer: {
    flex: 1,
    backgroundColor: '#FFFFFF',
  },
  scrollViewContent: {
    flex: 1,
    backgroundColor: '#E6F0FA',
  },
  scrollViewContentContainer: {
    paddingHorizontal: 0,
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#E6F0FA',
  },
  loadingText: {
    fontSize: 18,
    color: '#4B9CDB',
  },
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
  backButton: {
    padding: 5,
  },
  title: {
    fontSize: 18,
    fontWeight: '600',
    color: '#1B2C40',
  },
  placeholder: {
    width: 38,
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
    borderBottomWidth: 1,
    borderBottomColor: '#E0E0E0',
    paddingBottom: 10,
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
    borderLeftWidth: 3,
    borderLeftColor: '#4B9CDB50',
  },
  listText: {
    fontSize: 16,
    color: '#1B2C40',
    fontWeight: '500',
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
    shadowColor: '#4B9CDB',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.3,
    shadowRadius: 4,
    elevation: 5,
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