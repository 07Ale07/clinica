import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, TouchableOpacity, ActivityIndicator } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Horario } from '../modelo/horarioModel';
import { TurnoControl } from '../controlador/turno_control';
import { styles } from '../css/horariosStyles';

const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

const Horarios: React.FC = () => {
  const [horarios, setHorarios] = useState<Horario[]>([]);
  const [availableDays, setAvailableDays] = useState<string[]>([]);
  const [selectedDay, setSelectedDay] = useState<string>('');
  const [selectedDate, setSelectedDate] = useState<string>('');
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const getCurrentDay = (): string => {
    const today = new Date().getDay();
    return diasSemana[today === 0 ? 6 : today - 1]; // Adjust for Sunday
  };

  const formatDateToYYYYMMDD = (date: Date): string => {
    return date.toISOString().split('T')[0];
  };

  const fetchHorarios = async (dia: string, id_empleado: string, fecha: string) => {
    setIsLoading(true);
    setError(null);
    try {
      const horariosData = await TurnoControl.getHorariosOdontologo(id_empleado, dia, fecha);
      setHorarios(horariosData);
    } catch (err) {
      console.error('Error fetching horarios:', err);
      setError(err instanceof Error ? err.message : 'Error desconocido al cargar los horarios.');
      setHorarios([]);
    } finally {
      setIsLoading(false);
    }
  };

  const fetchAvailableDays = async (id_empleado: string) => {
    try {
      const availableDaysData = await Promise.all(
        diasSemana.map(async (dia) => {
          try {
            const horarios = await TurnoControl.getHorariosOdontologo(id_empleado, dia, formatDateToYYYYMMDD(new Date()));
            return horarios.length > 0 ? dia : null;
          } catch (err) {
            console.error(`Error fetching horarios for ${dia}:`, err);
            return null;
          }
        })
      );
      const filteredDays = availableDaysData.filter((dia): dia is string => dia !== null);
      setAvailableDays(filteredDays);
      return filteredDays;
    } catch (err) {
      console.error('Error fetching available days:', err);
      setError(err instanceof Error ? err.message : 'Error al cargar los días disponibles.');
      return [];
    }
  };

  useEffect(() => {
    const initializeHorarios = async () => {
      try {
        const id_empleado = await AsyncStorage.getItem('id_usuario');
        if (!id_empleado) {
          setError('No se encontró el ID de usuario. Por favor, vuelva a iniciar sesión.');
          return;
        }

        const today = getCurrentDay();
        const todayDate = formatDateToYYYYMMDD(new Date());
        let diaToFetch = today;
        let fechaToFetch = todayDate;

        // Get available days
        const available = await fetchAvailableDays(id_empleado);
        if (available.length === 0) {
          setError('No hay horarios disponibles para ningún día.');
          return;
        }

        // Get schedules for today
        try {
          const horariosToday = await TurnoControl.getHorariosOdontologo(id_empleado, today, todayDate);
          if (horariosToday.length === 0) {
            // If no schedules for today, fetch next working day
            const proximoDia = await TurnoControl.getProximoDiaLaboral(id_empleado, new Date());
            diaToFetch = proximoDia.dia_semana;
            fechaToFetch = proximoDia.fecha;
          }
        } catch (err) {
          console.error('Error checking today\'s schedules:', err);
          // If error, just use the first available day
          diaToFetch = available[0];
          fechaToFetch = formatDateToYYYYMMDD(new Date());
        }

        setSelectedDay(diaToFetch);
        setSelectedDate(fechaToFetch);
        await fetchHorarios(diaToFetch, id_empleado, fechaToFetch);
      } catch (err) {
        console.error('Error initializing horarios:', err);
        setError(err instanceof Error ? err.message : 'Error al inicializar los horarios.');
      }
    };

    initializeHorarios();
  }, []);

  const handleDayChange = async (itemValue: string) => {
    if (!itemValue) return;
    
    setSelectedDay(itemValue);
    const id_empleado = await AsyncStorage.getItem('id_usuario');
    if (id_empleado) {
      const fecha = selectedDate || formatDateToYYYYMMDD(new Date());
      await fetchHorarios(itemValue, id_empleado, fecha);
    }
  };

  const renderSchedule = ({ item }: { item: Horario }) => (
    <View style={styles.scheduleItem}>
      <Text style={styles.scheduleText}>{item.dia_semana}: {item.hora_inicio} - {item.hora_fin}</Text>
      <Text style={styles.scheduleSubText}>Estado: {item.activo ? 'Activo' : 'Inactivo'}</Text>
      {item.fecha_desde && (
        <Text style={styles.scheduleSubText}>Desde: {item.fecha_desde}</Text>
      )}
      {item.fecha_hasta && (
        <Text style={styles.scheduleSubText}>Hasta: {item.fecha_hasta}</Text>
      )}
    </View>
  );

  if (isLoading && horarios.length === 0) {
    return (
      <View style={styles.container}>
        <ActivityIndicator size="large" color="#4B9CDB" />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <View style={styles.dayPicker}>
        <Picker
          selectedValue={selectedDay}
          style={{ height: 50 }}
          onValueChange={handleDayChange}
        >
          {availableDays.length > 0 ? (
            availableDays.map((dia) => (
              <Picker.Item key={dia} label={dia} value={dia} />
            ))
          ) : (
            <Picker.Item label="No hay días disponibles" value="" />
          )}
        </Picker>
      </View>
      {error ? (
        <Text style={styles.errorText}>{error}</Text>
      ) : horarios.length > 0 ? (
        <FlatList
          data={horarios}
          renderItem={renderSchedule}
          keyExtractor={(item) => item.id_horario.toString()}
          contentContainerStyle={styles.list}
        />
      ) : (
        <Text style={styles.noSchedulesText}>
          No hay horarios disponibles para {selectedDay || 'este día'}.
        </Text>
      )}
    </View>
  );
};

export default Horarios;