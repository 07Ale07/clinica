import { Alert } from 'react-native';
import { LoginResponse, LoginCredentials, LoginModel } from '../modelo/LoginModel';
import { apiService } from '../src/services/api';
import AsyncStorage from '@react-native-async-storage/async-storage';

export class LoginController {
  static async handleLogin(
    credentials: LoginCredentials,
    onSuccess: (rol: string) => void,
    onError: (message: string) => void
  ): Promise<void> {
    try {
      // Validar credenciales
      if (!LoginModel.validateCredentials(credentials.usuario, credentials.contrasena)) {
        onError('Por favor, complete todos los campos');
        return;
      }

      // Realizar login
      const response: LoginResponse = await apiService.login(credentials);

      if (response.success && response.rol) {
        // Almacenar id_usuario en AsyncStorage
        if (response.id_usuario) {
          await AsyncStorage.setItem('id_usuario', response.id_usuario.toString());
        } else {
          console.warn('id_usuario no incluido en la respuesta de la API');
        }
        onSuccess(response.rol);
      } else {
        onError(response.message || 'Usuario o contraseña incorrectos');
      }
    } catch (error) {
      onError(error instanceof Error ? error.message : 'Error desconocido');
    }
  }
}