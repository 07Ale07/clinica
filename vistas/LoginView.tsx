import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Platform, KeyboardAvoidingView } from 'react-native';
import { LoginController } from '../controlador/LoginController';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { RootStackParamList } from '../src/navigation/types';
import * as Animatable from 'react-native-animatable';
import { LinearGradient } from 'expo-linear-gradient';
import { Feather } from '@expo/vector-icons';

type LoginScreenNavigationProp = StackNavigationProp<RootStackParamList, 'Login'>;

const LoginView: React.FC = () => {
  const [usuario, setUsuario] = useState<string>('');
  const [contrasena, setContrasena] = useState<string>('');
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [showPassword, setShowPassword] = useState<boolean>(false);
  
  const navigation = useNavigation<LoginScreenNavigationProp>();

  const handleLogin = async () => {
    setIsLoading(true);
    
    await LoginController.handleLogin(
      { usuario, contrasena },
      (rol) => {
        setIsLoading(false);
        if (rol === 'odontólogo') {
          navigation.navigate('Odontologo');
        } else {
          navigation.navigate('Home');
        }
      },
      (errorMessage) => {
        setIsLoading(false);
      }
    );
  };

  return (
    <LinearGradient
      colors={['#4B9CDB', '#E6F0FA']}
      style={styles.container}
    >
      <KeyboardAvoidingView
        behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
        style={styles.keyboardAvoidingContainer}
        keyboardVerticalOffset={Platform.OS === 'ios' ? 0 : 20}
      >
        <Animatable.View 
          animation="fadeInDown"
          duration={1000}
          style={styles.headerContainer}
        >
          <Text style={styles.title}>DENTAL SMILE</Text>
          <Text style={styles.subtitle}>Tus Prioridades, a Mano</Text>
        </Animatable.View>

        <Animatable.View 
          animation="fadeInUp"
          duration={1200}
          style={styles.formContainer}
        >
          <View style={styles.inputContainer}>
            <Feather name="user" size={24} color="#4B9CDB" style={styles.icon} />
            <TextInput
              style={styles.input}
              placeholder="Usuario"
              placeholderTextColor="#8A8F9E"
              value={usuario}
              onChangeText={setUsuario}
              editable={!isLoading}
            />
          </View>

          <View style={styles.inputContainer}>
            <Feather name="lock" size={24} color="#4B9CDB" style={styles.icon} />
            <TextInput
              style={styles.input}
              placeholder="Contraseña"
              placeholderTextColor="#8A8F9E"
              value={contrasena}
              onChangeText={setContrasena}
              secureTextEntry={!showPassword}
              editable={!isLoading}
            />
            <TouchableOpacity 
              onPress={() => setShowPassword(!showPassword)}
              style={styles.eyeIcon}
            >
              <Feather 
                name={showPassword ? "eye-off" : "eye"} 
                size={20} 
                color="#4B9CDB" 
              />
            </TouchableOpacity>
          </View>

          <Animatable.View
            animation="pulse"
            iterationCount="infinite"
            duration={2000}
            style={styles.buttonContainer}
          >
            <TouchableOpacity
              onPress={handleLogin}
              disabled={isLoading}
              style={styles.button}
            >
              <LinearGradient
                colors={['#4B9CDB', '#2A6EBB']}
                style={styles.buttonGradient}
              >
                <Text style={styles.buttonText}>
                  {isLoading ? 'Cargando...' : 'Iniciar Sesión'}
                </Text>
              </LinearGradient>
            </TouchableOpacity>
          </Animatable.View>

          <TouchableOpacity
            onPress={() => navigation.navigate('TurnoConsulta')}
            style={styles.consultButton}
          >
            <Text style={styles.consultButtonText}>Consultar Turno</Text>
          </TouchableOpacity>
        </Animatable.View>
      </KeyboardAvoidingView>
    </LinearGradient>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#E6F0FA',
  },
  keyboardAvoidingContainer: {
    flex: 1,
    justifyContent: 'center',
    paddingHorizontal: 20,
  },
  headerContainer: {
    alignItems: 'center',
    marginBottom: 40,
  },
  title: {
    fontSize: 36,
    fontWeight: 'bold',
    color: '#FFFFFF',
    textShadowColor: 'rgba(0, 0, 0, 0.2)',
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 4,
  },
  subtitle: {
    fontSize: 18,
    color: '#D1E6F9',
    marginTop: 8,
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
  eyeIcon: {
    padding: 10,
  },
  buttonContainer: {
    marginTop: 20,
  },
  button: {
    borderRadius: 10,
    overflow: 'hidden',
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
  consultButton: {
    marginTop: 20,
    alignItems: 'center',
  },
  consultButtonText: {
    color: '#4B9CDB',
    fontSize: 16,
    fontWeight: '600',
  },
});

export default LoginView;