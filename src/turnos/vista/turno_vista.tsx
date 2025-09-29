import React, { useState, useEffect } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, ScrollView, KeyboardAvoidingView, Platform, Alert } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { TurnoController } from '../controlador/TurnoController';
import { TurnoInfo } from '../modelo/TurnoModel';
import { LinearGradient } from 'expo-linear-gradient';
import { Feather } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import * as Calendar from 'expo-calendar';

const TurnoVista: React.FC = () => {
  const [dni, setDni] = useState<string>('');
  const [turnos, setTurnos] = useState<TurnoInfo[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    (async () => {
      const { status } = await Calendar.requestCalendarPermissionsAsync();
      if (status !== 'granted') {
        Alert.alert('Permiso denegado', 'Se necesitan permisos para acceder al calendario.');
      }
    })();
  }, []);

  const handleConsultar = async () => {
    setIsLoading(true);
    setError(null);
    setTurnos([]);
    
    try {
      const result = await TurnoController.fetchTurno(dni);
      if (result.length === 0) {
        setError('No existe ese DNI en mis registros');
      } else {
        console.log('Turnos recibidos:', result);
        setTurnos(result);
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Error desconocido');
    } finally {
      setIsLoading(false);
    }
  };

  const handleCancelTurno = async (id_cita: number) => {
    Alert.alert(
      'Confirmar Cancelación',
      '¿Estás seguro de que deseas cancelar este turno?',
      [
        {
          text: 'Cancelar',
          style: 'cancel',
        },
        {
          text: 'Confirmar',
          onPress: async () => {
            try {
              setIsLoading(true);
              await TurnoController.cancelTurno(id_cita);
              const updatedTurnos = turnos.map(turno =>
                turno.id_cita === id_cita ? { ...turno, estado: 'cancelada' } : turno
              );
              setTurnos(updatedTurnos);
              Alert.alert('Éxito', 'El turno ha sido cancelado.');
            } catch (error: any) {
              Alert.alert('Error', error.message || 'No se pudo cancelar el turno.');
            } finally {
              setIsLoading(false);
            }
          },
        },
      ]
    );
  };

  const getTurnoStatus = (fecha: string, estado: string | undefined) => {
    const now = new Date();
    const turnoDate = new Date(fecha);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    turnoDate.setSeconds(0, 0);
    const normalizedEstado = estado ? estado.toLowerCase() : 'pendiente';
    console.log('Estado del turno:', normalizedEstado);

    const isDateBeforeToday = turnoDate < today;
    const isTodayAndPastTime = turnoDate.getTime() === today.getTime() && now > turnoDate;
    const isExpired = isDateBeforeToday && normalizedEstado !== 'completada';
    const isPastTime = isTodayAndPastTime && normalizedEstado !== 'completada';

    return {
      isCompleted: normalizedEstado === 'completada',
      isExpired: isExpired,
      isPastTime: isPastTime,
      isPending: normalizedEstado === 'pendiente'
    };
  };

  const addToCalendar = async (turno: TurnoInfo) => {
    try {
      const calendars = await Calendar.getCalendarsAsync(Calendar.EntityTypes.EVENT);
      const defaultCalendar = calendars.find(cal => cal.allowsModifications);
      
      if (!defaultCalendar) {
        Alert.alert('Error', 'No se encontró un calendario modificable.');
        return;
      }

      const turnoDate = new Date(turno.fecha);
      const startDate = new Date(turnoDate);
      startDate.setDate(turnoDate.getDate() - 2);
      const endDate = new Date(turnoDate);
      const events = await Calendar.getEventsAsync([defaultCalendar.id], startDate, endDate);
      const eventExists = events.some(event => event.title === `Recordatorio: Turno ${turno.motivo}`);

      if (eventExists) {
        Alert.alert('Aviso', 'Ya existe un recordatorio para este turno en el calendario.');
        return;
      }

      Alert.alert(
        'Elegir recordatorio',
        '¿Cuándo desea añadir el recordatorio?',
        [
          {
            text: '1 día antes',
            onPress: () => createEvent(turno, 1, defaultCalendar.id),
          },
          {
            text: '2 días antes',
            onPress: () => createEvent(turno, 2, defaultCalendar.id),
          },
          {
            text: 'Cancelar',
            style: 'cancel',
          },
        ]
      );
    } catch (error) {
      console.error('Error al verificar calendario:', error);
      Alert.alert('Error', 'No se pudo verificar el calendario.');
    }
  };

  const createEvent = async (turno: TurnoInfo, daysBefore: number, calendarId: string) => {
    try {
      const turnoDate = new Date(turno.fecha);
      const eventDate = new Date(turnoDate);
      eventDate.setDate(turnoDate.getDate() - daysBefore);

      const eventDetails = {
        title: `Recordatorio: Turno ${turno.motivo}`,
        startDate: eventDate,
        endDate: new Date(eventDate.getTime() + 60 * 60 * 1000),
        notes: `Turno para ${turno.nombre} ${turno.apellido} el ${turnoDate.toLocaleString()}`,
        calendarId,
        alarms: [{ relativeOffset: -15 }],
      };

      await Calendar.createEventAsync(calendarId, eventDetails);
      Alert.alert('Éxito', `Evento añadido para ${daysBefore} día${daysBefore > 1 ? 's' : ''} antes.`);
    } catch (error) {
      console.error('Error al añadir evento al calendario:', error);
      Alert.alert('Error', 'No se pudo añadir el evento al calendario.');
    }
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <LinearGradient
        colors={['#4B9CDB', '#E6F0FA']}
        style={styles.container}
      >
        <KeyboardAvoidingView
          behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
          style={styles.container}
          keyboardVerticalOffset={Platform.OS === 'ios' ? 100 : 0}
        >
          <ScrollView 
            contentContainerStyle={styles.scrollContainer}
            keyboardShouldPersistTaps="handled"
          >
            <Animatable.View 
              animation="fadeInDown"
              duration={1000}
              style={styles.headerContainer}
            >
              <Text style={styles.title}>Consultar Turno</Text>
            </Animatable.View>

            <Animatable.View 
              animation="fadeInUp"
              duration={1200}
              style={styles.formContainer}
            >
              <View style={styles.inputContainer}>
                <Feather name="search" size={24} color="#4B9CDB" style={styles.icon} />
                <TextInput
                  style={styles.input}
                  placeholder="Ingrese su DNI"
                  placeholderTextColor="#8A8F9E"
                  value={dni}
                  onChangeText={setDni}
                  keyboardType="numeric"
                  editable={!isLoading}
                />
              </View>

              <TouchableOpacity
                onPress={handleConsultar}
                disabled={isLoading}
                style={styles.button}
              >
                <LinearGradient
                  colors={['#4B9CDB', '#2A6EBB']}
                  style={styles.buttonGradient}
                >
                  <Text style={styles.buttonText}>
                    {isLoading ? 'Consultando...' : 'Consultar'}
                  </Text>
                </LinearGradient>
              </TouchableOpacity>

              {error && (
                <Text style={styles.errorText}>{error}</Text>
              )}

              {turnos.map((turno, index) => {
                const { isCompleted, isExpired, isPastTime, isPending } = getTurnoStatus(turno.fecha, turno.estado);
                return (
                  <View key={index} style={styles.turnoContainer}>
                    <Text style={styles.turnoTitle}>¿Es tu turno?</Text>
                    <Text style={styles.turnoInfo}>Nombre: {turno.nombre} {turno.apellido}</Text>
                    <Text style={styles.turnoInfo}>Turno Motivo: {turno.motivo}</Text>
                    <Text style={styles.turnoInfo}>Fecha: {turno.fecha}</Text>
                    <Text style={styles.turnoInfo}>Estado: {turno.estado || 'No especificado'}</Text>
                    {isCompleted && (
                      <Text style={styles.completedText}>Turno atendido</Text>
                    )}
                    {isPastTime && (
                      <Text style={styles.pastTimeText}>Turno pasado de hora</Text>
                    )}
                    {isExpired && !isPastTime && (
                      <Text style={styles.expiredText}>Este turno expiró</Text>
                    )}
                    {!isCompleted && !isExpired && !isPastTime && isPending && (
                      <>
                        <TouchableOpacity 
                          style={styles.recordatorioButton}
                          onPress={() => addToCalendar(turno)}
                        >
                          <Text style={styles.recordatorioText}>Añadir Recordatorio</Text>
                        </TouchableOpacity>
                        <TouchableOpacity 
                          style={styles.cancelButton}
                          onPress={() => handleCancelTurno(turno.id_cita)}
                        >
                          <Text style={styles.cancelText}>Cancelar Turno</Text>
                        </TouchableOpacity>
                      </>
                    )}
                  </View>
                );
              })}
            </Animatable.View>
          </ScrollView>
        </KeyboardAvoidingView>
      </LinearGradient>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
  },
  container: {
    flex: 1,
  },
  scrollContainer: {
    flexGrow: 1,
    justifyContent: 'center',
    paddingHorizontal: 20,
    paddingBottom: 20,
  },
  headerContainer: {
    alignItems: 'center',
    marginBottom: 40,
  },
  title: {
    fontSize: 36,
    fontWeight: 'bold',
    color: '#FFFFFF',
  },
  formContainer: {
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    padding: 20,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 5,
  },
  inputContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#F7FAFD',
    borderRadius: 10,
    marginBottom: 15,
    paddingHorizontal: 10,
    borderWidth: 1,
    borderColor: '#D1E6F9',
  },
  icon: {
    marginRight: 10,
  },
  input: {
    flex: 1,
    height: 50,
    fontSize: 16,
    color: '#333',
  },
  button: {
    borderRadius: 10,
    overflow: 'hidden',
    marginTop: 20,
  },
  buttonGradient: {
    paddingVertical: 15,
    alignItems: 'center',
  },
  buttonText: {
    color: '#FFFFFF',
    fontSize: 18,
    fontWeight: '600',
  },
  errorText: {
    color: 'red',
    textAlign: 'center',
    marginTop: 10,
  },
  turnoContainer: {
    marginTop: 20,
    padding: 15,
    backgroundColor: '#F7FAFD',
    borderRadius: 10,
    borderWidth: 1,
    borderColor: '#D1E6F9',
  },
  turnoTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  turnoInfo: {
    fontSize: 16,
    marginBottom: 5,
  },
  recordatorioButton: {
    marginTop: 10,
    alignItems: 'center',
  },
  recordatorioText: {
    color: '#4B9CDB',
    fontSize: 16,
    fontWeight: '600',
  },
  cancelButton: {
    marginTop: 10,
    alignItems: 'center',
  },
  cancelText: {
    color: '#FF4444',
    fontSize: 16,
    fontWeight: '600',
  },
  expiredText: {
    color: '#FF4444',
    fontSize: 16,
    fontWeight: '600',
    marginTop: 5,
  },
  completedText: {
    color: '#008000',
    fontSize: 16,
    fontWeight: '600',
    marginTop: 5,
  },
  pastTimeText: {
    color: '#FF8C00',
    fontSize: 16,
    fontWeight: '600',
    marginTop: 5,
  },
});

export default TurnoVista;