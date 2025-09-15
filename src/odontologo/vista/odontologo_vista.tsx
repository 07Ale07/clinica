import React, { useState } from 'react';
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Gesture, GestureDetector, GestureHandlerRootView } from 'react-native-gesture-handler';
import { useNavigation } from '@react-navigation/native';
import { Ionicons } from '@expo/vector-icons';

import Menu from './menu';
import Horarios from './horarios';
import Historial from './historial';
import Inventario from './inventario';
import TurnoScreen from '../../turnos/vista/TurnoScreen'; // Asumiendo que esta es la ruta de tu componente

const OdontoloVista: React.FC = () => {
  const navigation = useNavigation();
  const options = [
    { name: 'Turnos', icon: 'today-outline' },
    { name: 'Horarios', icon: 'calendar-outline' },
    { name: 'Historial', icon: 'document-text-outline' },
    { name: 'Inventario', icon: 'cube-outline' },
  ];
  const [selectedIndex, setSelectedIndex] = useState(0);

  const renderContent = () => {
    switch (selectedIndex) {
      case 0:
        return (
          <View style={styles.content}>
            <Text style={styles.title}>Turnos para Hoy</Text>
            <Text style={styles.subtitle}>Citas programadas para {new Date().toLocaleDateString()}</Text>
            <View style={styles.appointmentCard}>
              <Text style={styles.appointmentText}>08:30 - Juan Pérez - Limpieza Dental</Text>
              <Text style={styles.appointmentText}>10:00 - María Gómez - Extracción</Text>
              <Text style={styles.appointmentText}>14:00 - Ana López - Consulta General</Text>
            </View>
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

  const panGesture = Gesture.Pan()
    .onEnd((event) => {
      const { translationX } = event;
      const swipeThreshold = 50;

      if (translationX > swipeThreshold && selectedIndex > 0) {
        setSelectedIndex(prevIndex => prevIndex - 1);
      } else if (translationX < -swipeThreshold && selectedIndex < options.length - 1) {
        setSelectedIndex(prevIndex => prevIndex + 1);
      }
    });

  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      <SafeAreaView style={styles.safeAreaContainer}>
        <GestureDetector gesture={panGesture}>
          <View style={styles.container}>
            {renderContent()}
            <Menu
              options={options}
              onSelect={setSelectedIndex}
              selectedIndex={selectedIndex}
            />

            {/* Botón flotante para añadir un nuevo turno */}
            <TouchableOpacity
              style={styles.floatingButton}
              onPress={() => navigation.navigate('TurnoScreen')}
            >
              <Ionicons name="add" size={30} color="#FFFFFF" />
            </TouchableOpacity>
          </View>
        </GestureDetector>
      </SafeAreaView>
    </GestureHandlerRootView>
  );
};

const styles = StyleSheet.create({
  safeAreaContainer: {
    flex: 1,
    backgroundColor: '#F0F2F5',
  },
  container: {
    flex: 1,
  },
  content: {
    flex: 1,
    padding: 20,
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#1B2C40',
    marginBottom: 10,
  },
  subtitle: {
    fontSize: 18,
    color: '#6A7A8A',
    marginBottom: 20,
  },
  appointmentCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 12,
    padding: 20,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.05,
    shadowRadius: 10,
    elevation: 5,
  },
  appointmentText: {
    fontSize: 16,
    color: '#333333',
    marginVertical: 8,
  },
  // Estilos para el botón flotante
  floatingButton: {
    position: 'absolute',
    bottom: 90, // Ajusta la distancia desde abajo para que no se superponga con el menú
    right: 30,
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: '#007bff', // Color azul que coincide con el tema
    justifyContent: 'center',
    alignItems: 'center',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 6,
    elevation: 8,
  },
});

export default OdontoloVista;