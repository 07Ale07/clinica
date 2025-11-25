// landig/modelo/contactoService.ts
import { apiService } from "../../services/api"

export const getWhatsAppContact = async (): Promise<string> => {
  try {
    const response = await apiService.get<{ telefono: string }>("/api/contacto-whatsapp")
    return response.data.telefono
  } catch (error) {
    console.warn("No se pudo cargar número de WhatsApp, usando fallback")
    return "3704037812" // fallback seguro
  }
}