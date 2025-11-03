// ../src/services/sesion.ts

import AsyncStorage from '@react-native-async-storage/async-storage';

/**
 * Claves usadas en AsyncStorage
 */
const KEYS = {
  LAST_SESSION: '@dental_smile:last_session',
  USER_ID: '@dental_smile:id_empleado',
  USER_ROLE: '@dental_smile:rol', // 'odontologo' | 'recepcionista'
} as const;

/**
 * Tipo para la sesión guardada
 */
interface SessionData {
  usuario: string;
  id_empleado: string;
  rol: 'odontologo' | 'recepcionista';
  timestamp: number;
}

/**
 * Guarda la sesión exitosa en almacenamiento persistente
 */
export const guardarSesion = async (
  usuario: string,
  id_empleado: string,
  rol: 'odontologo' | 'recepcionista'
): Promise<void> => {
  try {
    const session: SessionData = {
      usuario,
      id_empleado,
      rol,
      timestamp: Date.now(),
    };

    await AsyncStorage.setItem(KEYS.LAST_SESSION, JSON.stringify(session));
    await AsyncStorage.setItem(KEYS.USER_ID, id_empleado);
    await AsyncStorage.setItem(KEYS.USER_ROLE, rol);
  } catch (error) {
    console.error('Error al guardar la sesión:', error);
  }
};

/**
 * Recupera la última sesión guardada
 */
export const obtenerSesion = async (): Promise<SessionData | null> => {
  try {
    const sessionJson = await AsyncStorage.getItem(KEYS.LAST_SESSION);
    if (!sessionJson) return null;

    const session = JSON.parse(sessionJson) as SessionData;

    // Opcional: validar que el rol sea válido
    if (!['odontologo', 'recepcionista'].includes(session.rol)) {
      return null;
    }

    return session;
  } catch (error) {
    console.error('Error al leer la sesión:', error);
    return null;
  }
};

/**
 * Obtiene solo el ID del empleado
 */
export const obtenerIdEmpleado = async (): Promise<string | null> => {
  try {
    return await AsyncStorage.getItem(KEYS.USER_ID);
  } catch (error) {
    console.error('Error al obtener id_empleado:', error);
    return null;
  }
};

/**
 * Obtiene solo el rol del usuario
 */
export const obtenerRol = async (): Promise<'odontologo' | 'recepcionista' | null> => {
  try {
    const rol = await AsyncStorage.getItem(KEYS.USER_ROLE);
    return rol === 'odontologo' || rol === 'recepcionista' ? rol : null;
  } catch (error) {
    console.error('Error al obtener rol:', error);
    return null;
  }
};

/**
 * Cierra la sesión (elimina todos los datos)
 */
export const cerrarSesion = async (): Promise<void> => {
  try {
    await AsyncStorage.multiRemove([
      KEYS.LAST_SESSION,
      KEYS.USER_ID,
      KEYS.USER_ROLE,
    ]);
  } catch (error) {
    console.error('Error al cerrar sesión:', error);
  }
};

/**
 * Verifica si hay una sesión activa (útil al iniciar la app)
 */
export const haySesionActiva = async (): Promise<boolean> => {
  const id = await obtenerIdEmpleado();
  const rol = await obtenerRol();
  return !!(id && rol);
};