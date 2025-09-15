export interface LoginResponse {
    success: boolean;
    rol?: string;
    message?: string;
  }
  
  export interface LoginCredentials {
    usuario: string;
    contrasena: string;
  }
  
  export class LoginModel {
    static validateCredentials(usuario: string, contrasena: string): boolean {
      return usuario.trim().length > 0 && contrasena.trim().length > 0;
    }
  }