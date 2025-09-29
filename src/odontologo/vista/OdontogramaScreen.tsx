// Updated OdontogramaScreen.tsx (replaced custom header with CustomHeader)
import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  TouchableOpacity,
  StyleSheet,
  Alert,
  ScrollView,
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import type { NativeStackNavigationProp } from '@react-navigation/native-stack';
import { Ionicons } from '@expo/vector-icons';
import * as Animatable from 'react-native-animatable';
import { useSafeAreaInsets } from 'react-native-safe-area-context';
import { RootStackParamList } from '../../navigation/types';
import {
  Odontograma,
  OdontogramaData,
  toothNames,
  procedureNames,
  teethNumbers,
} from '../modelo/OdontogramaModel';
import OdontogramaControl from '../controlador/OdontogramaControl';
import CustomHeader from '../../navigation/CustomHeader';

const OdontogramaScreen: React.FC = () => {
  const navigation = useNavigation<NativeStackNavigationProp<RootStackParamList>>();
  const route = useRoute();
  const { idPaciente } = route.params as { idPaciente: number };
  const insets = useSafeAreaInsets();

  const [state, setState] = useState<{
    currentProcedure: string;
    teeth: OdontogramaData;
    selectedTooth: number | null;
  }>({
    currentProcedure: 'sano',
    teeth: {},
    selectedTooth: null,
  });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchOdontograma = async () => {
      try {
        const odontograma = await OdontogramaControl.obtenerOdontograma(idPaciente);
        if (odontograma && odontograma.odontograma) {
          setState((prev) => ({ ...prev, teeth: odontograma.odontograma }));
        } else {
          // Initialize empty odontogram if none exists
          setState((prev) => ({ ...prev, teeth: {} }));
        }
      } catch (err: any) {
        // Handle 404 specifically
        if (err.message.includes('404')) {
          setState((prev) => ({ ...prev, teeth: {} }));
          setError('No se encontró odontograma para este paciente. Se inicializó uno nuevo.');
        } else {
          setError(`Error al cargar el odontograma: ${err.message}`);
          Alert.alert('Error', 'No se pudo cargar el odontograma');
        }
      } finally {
        setLoading(false);
      }
    };
    fetchOdontograma();
  }, [idPaciente]);

  const updateToothState = (toothNum: number) => {
    setState((prev) => {
      const newTeeth = { ...prev.teeth };
      if (prev.currentProcedure === 'sano') {
        delete newTeeth[toothNum];
      } else {
        newTeeth[toothNum] = prev.currentProcedure;
      }
      return { ...prev, teeth: newTeeth, selectedTooth: toothNum };
    });
  };

  const saveOdontograma = async () => {
    if (!idPaciente) {
      Alert.alert('Error', 'ID de paciente no disponible');
      return;
    }
    try {
      await OdontogramaControl.guardarOdontograma(idPaciente, state.teeth);
      Alert.alert('Éxito', 'Odontograma guardado correctamente');
    } catch (err: any) {
      Alert.alert('Error', `Error al guardar: ${err.message}`);
    }
  };

  const resetOdontograma = () => {
    Alert.alert('Confirmar', '¿Está seguro de limpiar todo el odontograma?', [
      { text: 'Cancelar', style: 'cancel' },
      {
        text: 'Sí',
        onPress: () =>
          setState((prev) => ({ ...prev, teeth: {}, selectedTooth: null })),
      },
    ]);
  };

  const setCurrentProcedure = (procedure: string) => {
    setState((prev) => ({ ...prev, currentProcedure: procedure }));
    if (state.selectedTooth) {
      updateToothState(state.selectedTooth);
    }
  };

  const renderTeeth = () => {
    return (
      <View style={styles.dentalArch}>
        {teethNumbers.map((num) => {
          const procedure = state.teeth[num] || 'sano';
          const isSelected = state.selectedTooth === num;
          return (
            <TouchableOpacity
              key={num}
              style={[
                styles.tooth,
                procedure === 'sano' && styles.toothSano,
                procedure === 'caries' && styles.toothCaries,
                procedure === 'restauracion' && styles.toothRestauracion,
                isSelected && styles.toothSelected,
              ]}
              onPress={() => updateToothState(num)}
            >
              <Text style={styles.toothNumber}>{num}</Text>
            </TouchableOpacity>
          );
        })}
      </View>
    );
  };

  const renderToothInfo = () => {
    if (!state.selectedTooth) return null;
    const procedure = state.teeth[state.selectedTooth] || 'sano';
    let stateText = '';
    let stateColor = '#000';
    if (procedure === 'sano') {
      stateText = 'Sano';
      stateColor = '#4CAF50';
    } else if (procedure === 'caries') {
      stateText = 'Con caries';
      stateColor = '#FF0000';
    } else if (procedure === 'restauracion') {
      stateText = 'Restaurado';
      stateColor = '#FFC107';
    }

    return (
      <Animatable.View animation="fadeIn" style={styles.toothInfo}>
        <Text style={styles.infoTitle}>Información del Diente</Text>
        <Text>
          <Text style={styles.infoLabel}>Diente:</Text> {state.selectedTooth}
        </Text>
        <Text>
          <Text style={styles.infoLabel}>Nombre:</Text>{' '}
          {toothNames[state.selectedTooth] || 'Desconocido'}
        </Text>
        <Text>
          <Text style={styles.infoLabel}>Estado:</Text>{' '}
          <Text style={{ color: stateColor }}>{stateText}</Text>
        </Text>
      </Animatable.View>
    );
  };

  if (loading) {
    return (
      <View style={styles.container}>
        <CustomHeader title="Odontograma" showBackButton={true} showMenuButton={false} />
        <Text style={styles.loadingText}>Cargando odontograma...</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <CustomHeader title="Odontograma" showBackButton={true} showMenuButton={false} />
      <ScrollView contentContainerStyle={styles.scrollViewContent}>
        {error && (
          <Text style={styles.errorText}>{error}</Text>
        )}
        <View style={styles.odontogramaContainer}>{renderTeeth()}</View>
        {renderToothInfo()}
        <View style={styles.procedimientos}>
          <TouchableOpacity
            style={[
              styles.procedureButton,
              state.currentProcedure === 'sano' && styles.activeButton,
            ]}
            onPress={() => setCurrentProcedure('sano')}
          >
            <Text
              style={[
                styles.procedureText,
                state.currentProcedure === 'sano' && styles.activeProcedureText,
              ]}
            >
              Sano
            </Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={[
              styles.procedureButton,
              state.currentProcedure === 'caries' && styles.activeButton,
            ]}
            onPress={() => setCurrentProcedure('caries')}
          >
            <Text
              style={[
                styles.procedureText,
                state.currentProcedure === 'caries' && styles.activeProcedureText,
              ]}
            >
              Caries
            </Text>
          </TouchableOpacity>
          <TouchableOpacity
            style={[
              styles.procedureButton,
              state.currentProcedure === 'restauracion' && styles.activeButton,
            ]}
            onPress={() => setCurrentProcedure('restauracion')}
          >
            <Text
              style={[
                styles.procedureText,
                state.currentProcedure === 'restauracion' && styles.activeProcedureText,
              ]}
            >
              Restauración
            </Text>
          </TouchableOpacity>
        </View>
        <View style={styles.actions}>
          <TouchableOpacity style={styles.saveButton} onPress={saveOdontograma}>
            <Text style={styles.buttonText}>Guardar</Text>
          </TouchableOpacity>
          <TouchableOpacity style={styles.resetButton} onPress={resetOdontograma}>
            <Text style={styles.buttonText}>Limpiar</Text>
          </TouchableOpacity>
        </View>
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA',
  },
  scrollViewContent: {
    padding: 20,
  },
  odontogramaContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'center',
  },
  dentalArch: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'center',
  },
  tooth: {
    width: 50,
    height: 80,
    margin: 5,
    justifyContent: 'center',
    alignItems: 'center',
    borderWidth: 1,
    borderColor: '#CCC',
    borderRadius: 5,
  },
  toothSano: {
    backgroundColor: '#FFFFFF',
  },
  toothCaries: {
    backgroundColor: '#FF6B6B',
  },
  toothRestauracion: {
    backgroundColor: '#FFD166',
  },
  toothSelected: {
    borderColor: '#000',
    borderWidth: 2,
  },
  toothNumber: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  toothInfo: {
    backgroundColor: '#FFFFFF',
    padding: 15,
    borderRadius: 10,
    marginVertical: 20,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
    elevation: 3,
  },
  infoTitle: {
    fontSize: 18,
    fontWeight: '600',
    color: '#1B2C40',
    marginBottom: 10,
  },
  infoLabel: {
    fontWeight: 'bold',
    color: '#1B2C40',
  },
  procedimientos: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    marginVertical: 20,
  },
  procedureButton: {
    padding: 10,
    borderRadius: 8,
    borderWidth: 1,
    borderColor: '#4B9CDB',
    backgroundColor: '#FFFFFF',
  },
  activeButton: {
    backgroundColor: '#4B9CDB',
  },
  procedureText: {
    fontSize: 16,
    color: '#4B9CDB',
  },
  activeProcedureText: {
    color: '#FFFFFF',
  },
  actions: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    marginVertical: 20,
  },
  saveButton: {
    backgroundColor: '#4CAF50',
    padding: 15,
    borderRadius: 10,
    flex: 1,
    marginHorizontal: 5,
    alignItems: 'center',
  },
  resetButton: {
    backgroundColor: '#FFC107',
    padding: 15,
    borderRadius: 10,
    flex: 1,
    marginHorizontal: 5,
    alignItems: 'center',
  },
  buttonText: {
    color: '#FFFFFF',
    fontWeight: '600',
    fontSize: 16,
  },
  loadingText: {
    fontSize: 18,
    color: '#4B9CDB',
    textAlign: 'center',
    marginTop: 50,
  },
  errorText: {
    fontSize: 16,
    color: '#FF0000',
    textAlign: 'center',
    marginBottom: 20,
  },
});

export default OdontogramaScreen;