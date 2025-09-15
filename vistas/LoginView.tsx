// src/vistas/LoginView.tsx
import React, { useState } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert } from 'react-native';
import { LoginController } from '../controlador/LoginController';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../src/navigation/types';

// Define el tipo de navegación para esta pantalla
type LoginScreenNavigationProp = StackNavigationProp<
  RootStackParamList,
  'Login'
>;

const LoginView: React.FC = () => {
  const [usuario, setUsuario] = useState<string>('');
  const [contrasena, setContrasena] = useState<string>('');
  const [isLoading, setIsLoading] = useState<boolean>(false);
  
  // Usa el tipo definido para useNavigation
  const navigation = useNavigation<LoginScreenNavigationProp>();

  const handleLogin = async () => {
    setIsLoading(true);
    
    await LoginController.handleLogin(
      { usuario, contrasena },
      (rol) => {
        Alert.alert('Éxito', `Bienvenido, tu rol es: ${rol}`);
        setIsLoading(false);
        
        // Redirigir según el rol
        if (rol === 'odontologo') {
          navigation.navigate('Odontologo'); // Ahora TypeScript sabe que esta ruta existe
        } else {
          Alert.alert('Información', 'Redirección para otros roles no implementada');
        }
      },
      (errorMessage) => {
        Alert.alert('Error', errorMessage);
        setIsLoading(false);
      }
    );
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>ClinApp - Iniciar Sesión</Text>
      <TextInput
        style={styles.input}
        placeholder="Usuario"
        value={usuario}
        onChangeText={setUsuario}
        editable={!isLoading}
      />
      <TextInput
        style={styles.input}
        placeholder="Contraseña"
        value={contrasena}
        onChangeText={setContrasena}
        secureTextEntry
        editable={!isLoading}
      />
      <Button 
        title={isLoading ? "Cargando..." : "Iniciar Sesión"} 
        onPress={handleLogin}
        disabled={isLoading}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    padding: 20,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
    textAlign: 'center',
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    padding: 10,
    marginBottom: 10,
    borderRadius: 5,
  },
});

export default LoginView;