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

        // Guardar sesión completa usando el servicio
        await guardarSesion(
          credentials.usuario,
          idStr,
          response.rol // Ya está tipado como 'odontologo' | 'recepcionista'
        )

        console.log('✅ Sesión guardada correctamente para:', credentials.usuario)
        
        // Éxito
        onSuccess(response.rol)
      } else {
        onError(response.message || "Usuario o contraseña incorrectos")
      }
    } catch (error) {
      const mensaje = error instanceof Error ? error.message : "Error de conexión"
      console.error('❌ Error en login:', mensaje)
      onError(mensaje)
    }
  }
}