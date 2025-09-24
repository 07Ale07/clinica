import React, { useState, useEffect } from 'react';
import { View, Text, ActivityIndicator, FlatList, TouchableOpacity, Alert } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { GestureHandlerRootView } from 'react-native-gesture-handler';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { Ionicons } from '@expo/vector-icons';
import AsyncStorage from '@react-native-async-storage/async-storage';
import * as Animatable from 'react-native-animatable';
import { Turno } from '../modelo/turnoModel';
import { TurnoControl } from '../controlador/turno_control';
import { MenuOption } from './menu';
import Menu from './menu';
import Horarios from './horarios';
import Historial from './historial';
import Inventario from './inventario';
import { styles } from '../css/OdontoloVistaStyles';
import { RootStackParamList } from '../../navigation/types';
import { DrawerActions } from '@react-navigation/native';

type OdontoloVistaNavigationProp = StackNavigationProp<RootStackParamList>;

const OdontoloVista: React.FC = () => {
  const navigation = useNavigation<OdontoloVistaNavigationProp>();
  const options: MenuOption[] = [
    { name: 'Turnos', icon: 'today-outline' },
    { name: 'Horarios', icon: 'calendar-outline' },
    { name: 'Historial', icon: 'document-text-outline' },
    { name: 'Inventario', icon: 'cube-outline' },
  ];
  const [selectedIndex, setSelectedIndex] = useState(0);
  const [turnos, setTurnos] = useState<Turno[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchTurnos = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const id_usuario = await AsyncStorage.getItem('id_usuario');
        if (id_usuario) {
          const fetchedTurnos = await TurnoControl.getTurnosOdontologo(id_usuario);
          setTurnos(fetchedTurnos);
        } else {
          Alert.alert('Error', 'No se encontró el ID de usuario. Por favor, vuelva a iniciar sesión.');
        }
      } catch (err) {
        setError(err instanceof Error ? err.message : 'Error desconocido al cargar los turnos.');
        setTurnos([]);
      } finally {
        setIsLoading(false);
      }
    };

    if (selectedIndex === 0) {
      fetchTurnos();
    }
  }, [selectedIndex]);

  const openDrawer = () => {
    navigation.dispatch(DrawerActions.openDrawer());
  };

  const renderContent = () => {
    switch (selectedIndex) {
      case 0:
        return (
          <View style={styles.content}>
            <Animatable.Text 
              animation="fadeInDown" 
              duration={1200} 
              style={styles.subtitle}
            >
              Citas programadas para {new Date().toLocaleDateString()}
            </Animatable.Text>
            {isLoading ? (
              <ActivityIndicator size="large" color="#4B9CDB" />
            ) : error ? (
              <Animatable.Text 
                animation="fadeIn" 
                duration={1000} 
                style={styles.errorText}
              >
                {error}
              </Animatable.Text>
            ) : turnos.length > 0 ? (
              <FlatList
                data={turnos}
                keyExtractor={(item) => item.id_cita.toString()}
                renderItem={({ item, index }) => (
                  <Animatable.View 
                    animation="fadeInUp" 
                    duration={1000} 
                    delay={index * 100}
                    style={styles.appointmentCard}
                  >
                    <View style={styles.cardContent}>
                      <View style={styles.cardTextContainer}>
                        <Text style={styles.appointmentText}>
                          {item.hora_inicio} - {item.nombre_paciente}
                        </Text>
                        <Text style={styles.appointmentDetail}>
                          Tipo de cita: {item.tipo}
                        </Text>
                        <Text style={styles.appointmentDetail}>
                          Estado: {item.estado}
                        </Text>
                      </View>
                      <TouchableOpacity
                        onPress={() => navigation.navigate('DetallePaciente', { paciente: item })}
                        style={styles.detailButton}
                      >
                        <Ionicons name="chevron-forward" size={24} color="#4B9CDB" />
                      </TouchableOpacity>
                    </View>
                  </Animatable.View>
                )}
              />
            ) : (
              <Animatable.Text 
                animation="fadeIn" 
                duration={1000} 
                style={styles.noAppointmentsText}
              >
                No hay turnos programados para hoy.
              </Animatable.Text>
            )}
          </View>
        );
      case 1:
        return <Horarios />;
      case 2:
        return <Historial />;
      case 3:
        return <Inventario />;
      default:
        return null;
    }
  };

  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      <SafeAreaView style={styles.safeAreaContainer}>
        <View style={styles.container}>
          <TouchableOpacity style={styles.menuButton} onPress={openDrawer}>
            <Ionicons name="menu-outline" size={30} color="#4B9CDB" />
          </TouchableOpacity>
          {renderContent()}
          <Menu
            options={options}
            onSelect={setSelectedIndex}
            selectedIndex={selectedIndex}
          />
        </View>
      </SafeAreaView>
    </GestureHandlerRootView>
  );
};

export default OdontoloVista;