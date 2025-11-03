// ../controlador/LoginController.ts
import { type LoginResponse, type LoginCredentials, LoginModel } from "../modelo/LoginModel"
import { apiService } from "../src/services/api"
import { guardarSesion } from "../src/services/sesion"

export class LoginController {
  static async handleLogin(
    credentials: LoginCredentials,
    onSuccess: (rol: string) => void,
    onError: (message: string) => void,
  ): Promise<void> {
    try {
      // Validar campos
      if (!LoginModel.validateCredentials(credentials.usuario, credentials.contrasena)) {
        onError("Por favor, complete todos los campos")
        return
      }

      // Llamar a la API
      const response: LoginResponse = await apiService.login(credentials)

      if (response.success && response.rol && response.id_usuario) {
        const idStr = response.id_usuario.toString()

        // Guardar sesión completa
        await guardarSesion(
          credentials.usuario,
          idStr,
          response.rol as 'odontologo' | 'recepcionista'
        )

        // Éxito
        onSuccess(response.rol)
      } else {
        onError(response.message || "Usuario o contraseña incorrectos")
      }
    } catch (error) {
      const mensaje = error instanceof Error ? error.message : "Error de conexión"
      onError(mensaje)
    }
  }
}
