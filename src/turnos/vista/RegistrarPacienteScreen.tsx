import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, ScrollView, Alert, Switch } from 'react-native';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../../navigation/types';
import TurnoController from '../controlador/TurnoController';
import { Persona, Paciente, ObraPersona, Familiar } from '../modelo/PacienteModel';
import { styles } from '../css/TurnoStyles';

type RegistrarPacienteScreenNavigationProp = StackNavigationProp<RootStackParamList, 'RegistrarPacienteScreen'>;

interface Props {
  navigation: RegistrarPacienteScreenNavigationProp;
}

const RegistrarPacienteScreen: React.FC<Props> = ({ navigation }) => {
  const [nombre, setNombre] = useState('');
  const [apellido, setApellido] = useState('');
  const [dni, setDni] = useState('');
  const [alergias, setAlergias] = useState('');
  const [observaciones, setObservaciones] = useState('');
  
  // Campos para obra social
  const [mostrarObraSocial, setMostrarObraSocial] = useState(false);
  const [obraSocialId, setObraSocialId] = useState('');
  const [numeroAfiliado, setNumeroAfiliado] = useState('');
  const [plan, setPlan] = useState('');
  
  // Campos para familiar
  const [mostrarFamiliar, setMostrarFamiliar] = useState(false);
  const [parentesco, setParentesco] = useState('');
  const [esResponsable, setEsResponsable] = useState(false);

  const [cargando, setCargando] = useState(false);

  const registrarPacienteScreen = async () => {
    if (!nombre || !apellido || !dni) {
      Alert.alert('Error', 'Por favor complete todos los campos obligatorios');
      return;
    }

    setCargando(true);

    try {
      // 1. Crear la persona
      const persona: Omit<Persona, 'id_persona'> = {
        nombre,
        apellido,
        DNI: dni
      };
      
      const nuevaPersona = await TurnoController.crearPersona(persona);

      // 2. Crear el paciente
      const paciente: Omit<Paciente, 'id_paciente'> = {
        id_persona: nuevaPersona.id_persona!,
        alergias: alergias || undefined,
        observaciones_generales: observaciones || undefined,
        tipo: 'adulto' // Por defecto, se puede cambiar después
      };
      
      const nuevoPaciente = await TurnoController.crearPaciente(paciente);

      // 3. Si se especificó obra social, agregarla
      if (mostrarObraSocial && obraSocialId && numeroAfiliado) {
        const obraPersona: Omit<ObraPersona, 'id_obra_persona'> = {
          id_persona: nuevaPersona.id_persona!,
          id_obra_social: parseInt(obraSocialId),
          numero_afiliado: numeroAfiliado,
          plan: plan || undefined,
          titular: true // Asumimos que es titular por defecto
        };
        
        await TurnoController.agregarObraSocialPaciente(obraPersona);
      }

      // 4. Si se especificó familiar, agregarlo
      if (mostrarFamiliar && parentesco) {
        // Aquí necesitaríamos el ID del paciente familiar que ya debería existir
        // Esta implementación es básica y necesitaría más lógica
        Alert.alert('Info', 'La funcionalidad de agregar familiar requiere más implementación');
      }

      Alert.alert('Éxito', 'Paciente registrado correctamente');
      navigation.goBack();
      
    } catch (error) {
      Alert.alert('Error', 'No se pudo registrar el paciente');
      console.error(error);
    } finally {
      setCargando(false);
    }
  };

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>Registrar Nuevo Paciente</Text>
      
      <Text style={styles.label}>Nombre *</Text>
      <TextInput
        style={styles.input}
        value={nombre}
        onChangeText={setNombre}
        placeholder="Ingrese el nombre"
      />
      
      <Text style={styles.label}>Apellido *</Text>
      <TextInput
        style={styles.input}
        value={apellido}
        onChangeText={setApellido}
        placeholder="Ingrese el apellido"
      />
      
      <Text style={styles.label}>DNI *</Text>
      <TextInput
        style={styles.input}
        value={dni}
        onChangeText={setDni}
        placeholder="Ingrese el DNI"
        keyboardType="numeric"
      />
      
      <Text style={styles.label}>Alergias</Text>
      <TextInput
        style={styles.input}
        value={alergias}
        onChangeText={setAlergias}
        placeholder="Ingrese las alergias (opcional)"
      />
      
      <Text style={styles.label}>Observaciones</Text>
      <TextInput
        style={[styles.input, styles.textArea]}
        value={observaciones}
        onChangeText={setObservaciones}
        placeholder="Observaciones generales (opcional)"
        multiline
        numberOfLines={3}
      />
      
      {/* Sección de Obra Social */}
      <View style={styles.section}>
        <View style={styles.switchContainer}>
          <Text style={styles.sectionTitle}>Agregar Obra Social</Text>
          <Switch
            value={mostrarObraSocial}
            onValueChange={setMostrarObraSocial}
          />
        </View>
        
        {mostrarObraSocial && (
          <View>
            <Text style={styles.label}>ID Obra Social</Text>
            <TextInput
              style={styles.input}
              value={obraSocialId}
              onChangeText={setObraSocialId}
              placeholder="ID de la obra social"
              keyboardType="numeric"
            />
            
            <Text style={styles.label}>Número de Afiliado *</Text>
            <TextInput
              style={styles.input}
              value={numeroAfiliado}
              onChangeText={setNumeroAfiliado}
              placeholder="Número de afiliado"
            />
            
            <Text style={styles.label}>Plan</Text>
            <TextInput
              style={styles.input}
              value={plan}
              onChangeText={setPlan}
              placeholder="Plan (opcional)"
            />
          </View>
        )}
      </View>
      
      {/* Sección de Familiar */}
      <View style={styles.section}>
        <View style={styles.switchContainer}>
          <Text style={styles.sectionTitle}>Agregar Familiar</Text>
          <Switch
            value={mostrarFamiliar}
            onValueChange={setMostrarFamiliar}
          />
        </View>
        
        {mostrarFamiliar && (
          <View>
            <Text style={styles.label}>Parentesco</Text>
            <TextInput
              style={styles.input}
              value={parentesco}
              onChangeText={setParentesco}
              placeholder="Ej: Padre, Madre, Hijo, etc."
            />
            
            <View style={styles.switchContainer}>
              <Text style={styles.label}>Es responsable</Text>
              <Switch
                value={esResponsable}
                onValueChange={setEsResponsable}
              />
            </View>
            
            <Text style={styles.infoText}>
              Nota: Para agregar un familiar, la persona debe estar previamente registrada en el sistema.
            </Text>
          </View>
        )}
      </View>
      
      <TouchableOpacity 
        style={[styles.button, cargando && styles.buttonDisabled]}
        onPress={registrarPacienteScreen}
        disabled={cargando}
      >
        <Text style={styles.buttonText}>
          {cargando ? 'Registrando...' : 'Registrar Paciente'}
        </Text>
      </TouchableOpacity>
    </ScrollView>
  );
};

export default RegistrarPacienteScreen;