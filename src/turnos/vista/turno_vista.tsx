import React, { useState, useEffect } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, ScrollView, KeyboardAvoidingView, Platform, Alert } from 'react-native';
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

  // Solicitar permisos para el calendario al montar el componente
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
        console.log('Turnos recibidos:', result); // Log para depuración
        setTurnos(result);
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Error desconocido');
    } finally {
      setIsLoading(false);
    }
  };

  const getTurnoStatus = (fecha: string, estado: string | undefined) => {
    const now = new Date(); // Hora actual
    const turnoDate = new Date(fecha);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Normalizar a medianoche para comparación por día
    turnoDate.setSeconds(0, 0); // Normalizar segundos y milisegundos para comparación precisa
    const normalizedEstado = estado ? estado.toLowerCase() : 'pendiente'; // Asumir 'pendiente' si estado es undefined
    console.log('Estado del turno:', normalizedEstado); // Log para depuración

    // Determinar si el turno está expirado, pasado de hora o completado
    const isDateBeforeToday = turnoDate < today;
    const isTodayAndPastTime = turnoDate.getTime() === today.getTime() && now > turnoDate;
    const isExpired = isDateBeforeToday && normalizedEstado !== 'completada';
    const isPastTime = isTodayAndPastTime && normalizedEstado !== 'completada';

    return {
      isCompleted: normalizedEstado === 'completada',
      isExpired: isExpired,
      isPastTime: isPastTime
    };
  };

  const addToCalendar = async (turno: TurnoInfo) => {
    try {
      // Obtener el calendario predeterminado para eventos
      const calendars = await Calendar.getCalendarsAsync(Calendar.EntityTypes.EVENT);
      const defaultCalendar = calendars.find(cal => cal.allowsModifications);
      
      if (!defaultCalendar) {
        Alert.alert('Error', 'No se encontró un calendario modificable.');
        return;
      }

      // Verificar si ya existe un evento para este turno
      const turnoDate = new Date(turno.fecha);
      const startDate = new Date(turnoDate);
      startDate.setDate(turnoDate.getDate() - 2); // Buscar eventos en un rango de 2 días antes
      const endDate = new Date(turnoDate);
      const events = await Calendar.getEventsAsync([defaultCalendar.id], startDate, endDate);
      const eventExists = events.some(event => event.title === `Recordatorio: Turno ${turno.motivo}`);

      if (eventExists) {
        Alert.alert('Aviso', 'Ya existe un recordatorio para este turno en el calendario.');
        return;
      }

      // Mostrar diálogo para elegir 1 o 2 días antes
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
      eventDate.setDate(turnoDate.getDate() - daysBefore); // Establecer 1 o 2 días antes

      const eventDetails = {
        title: `Recordatorio: Turno ${turno.motivo}`,
        startDate: eventDate,
        endDate: new Date(eventDate.getTime() + 60 * 60 * 1000), // Duración de 1 hora
        notes: `Turno para ${turno.nombre} ${turno.apellido} el ${turnoDate.toLocaleString()}`,
        calendarId,
        alarms: [{ relativeOffset: -15 }], // Alarma 15 minutos antes
      };

      await Calendar.createEventAsync(calendarId, eventDetails);
      Alert.alert('Éxito', `Evento añadido para ${daysBefore} día${daysBefore > 1 ? 's' : ''} antes.`);
    } catch (error) {
      console.error('Error al añadir evento al calendario:', error);
      Alert.alert('Error', 'No se pudo añadir el evento al calendario.');
    }
  };

  return (
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
              const { isCompleted, isExpired, isPastTime } = getTurnoStatus(turno.fecha, turno.estado);
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
                  {!isCompleted && !isExpired && !isPastTime && (
                    <TouchableOpacity 
                      style={styles.recordatorioButton}
                      onPress={() => addToCalendar(turno)}
                    >
                      <Text style={styles.recordatorioText}>Añadir Recordatorio</Text>
                    </TouchableOpacity>
                  )}
                </View>
              );
            })}
          </Animatable.View>
        </ScrollView>
      </KeyboardAvoidingView>
    </LinearGradient>
  );
};

const styles = StyleSheet.create({
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
    color: '#FF8C00', // Naranja para diferenciar de expirado y completado
    fontSize: 16,
    fontWeight: '600',
    marginTop: 5,
  },
});

export default TurnoVista;