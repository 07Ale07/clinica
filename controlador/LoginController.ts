import { Alert } from 'react-native';
import { LoginResponse, LoginCredentials, LoginModel } from '../modelo/LoginModel';
import { apiService } from '../src/services/api';

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
        onSuccess(response.rol);
      } else {
        onError(response.message || 'Usuario o contraseña incorrectos');
      }
    } catch (error) {
      onError(error instanceof Error ? error.message : 'Error desconocido');
    }
  }
}