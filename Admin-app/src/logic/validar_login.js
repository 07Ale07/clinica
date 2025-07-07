import { API_URL } from '../api/api';

export async function validarLogin(usuario, clave) {
  try {
    const response = await fetch(`${API_URL}/login`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ usuario, clave }),
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error al validar login:', error);
    return { success: false, error: 'Error de conexión con el servidor' };
  }
}
