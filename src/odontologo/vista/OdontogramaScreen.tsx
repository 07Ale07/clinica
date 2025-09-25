// odontologo/vista/OdontogramaScreen.tsx
import React, { useState, useEffect } from 'react';
import { View, Text, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import { Ionicons } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import axios from 'axios';
import { API_BASE_URL } from '../../services/api';
import { Odontograma } from '../modelo/OdontogramaModel';

const OdontogramaScreen: React.FC = () => {
  const navigation = useNavigation();
  const route = useRoute();
  const { idPaciente } = route.params as { idPaciente: number };
  const [odontograma, setOdontograma] = useState<Odontograma | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchOdontograma = async () => {
      try {
        const response = await axios.get<Odontograma>(`${API_BASE_URL}/odontograma/${idPaciente}`);
        setOdontograma(response.data);
      } catch (error) {
        Alert.alert('Error', 'No se pudo cargar el odontograma');
        console.error('Error en fetchOdontograma:', error);
      } finally {
        setLoading(false);
      }
    };
    fetchOdontograma();
  }, [idPaciente]);

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <Animatable.Text animation="pulse" style={styles.loadingText}>
          Cargando odontograma...
        </Animatable.Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
        <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
          <Ionicons name="arrow-back" size={28} color="#4B9CDB" />
        </TouchableOpacity>
        <Text style={styles.title}>Odontograma</Text>
      </Animatable.View>

      <Animatable.View animation="fadeInUp" duration={1200} style={styles.card}>
        {odontograma ? (
          <>
            <Text style={styles.cardTitle}>Fecha: {odontograma.fecha_actualizacion}</Text>
            <Text style={styles.detailText}>Estado: {odontograma.hecho ? 'Completado' : 'En progreso'}</Text>
            <View style={styles.odontogramaPlaceholder}>
              <Text style={styles.placeholderText}>[Odontograma Interactivo]</Text>
              <Text style={styles.smallText}>Datos: {odontograma.odontograma}</Text>
              {/* Integra react-native-svg para módulo completo */}
            </View>
          </>
        ) : (
          <Text style={styles.detailText}>No hay odontograma disponible</Text>
        )}
      </Animatable.View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA',
    padding: 20,
  },
  headerContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 20,
  },
  backButton: {
    padding: 10,
  },
  title: {
    fontSize: 28,
    fontWeight: '700',
    color: '#1B2C40',
    flex: 1,
    textAlign: 'center',
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
  },
  cardTitle: {
    fontSize: 24,
    fontWeight: '600',
    color: '#1B2C40',
    marginBottom: 15,
  },
  detailText: {
    fontSize: 16,
    color: '#6A7A8A',
    marginBottom: 10,
  },
  odontogramaPlaceholder: {
    alignItems: 'center',
    justifyContent: 'center',
    height: 300,
    backgroundColor: '#F0F0F0',
    borderRadius: 10,
    marginTop: 10,
  },
  placeholderText: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#4B9CDB',
  },
  smallText: {
    fontSize: 12,
    color: '#6A7A8A',
    marginTop: 5,
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  loadingText: {
    fontSize: 18,
    color: '#4B9CDB',
  },
});

export default OdontogramaScreen;