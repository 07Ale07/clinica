// controlador/LandingController.ts

import { LandingModel, type LandingData } from "../modelo/LandingModel"
import { getWhatsAppContact } from "../modelo/contactoService" // Ajusta ruta si es necesario

export class LandingController {
  static getLandingData(): LandingData {
    return LandingModel.getMockData()
  }

  // Nuevo: obtener número de WhatsApp desde API
  static async getWhatsAppNumber(): Promise<string> {
    return await getWhatsAppContact()
  }

  static handleNavigateToLogin(navigation: any): void {
    navigation.navigate("Login")
  }

  // Ya no usamos número hardcodeado
  static async openWhatsApp() {
    const phoneNumber = await this.getWhatsAppNumber()
    const message = "Hola, me interesa saber más sobre sus servicios"
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`
    
    // En React Native:
    const { Linking } = require("react-native")
    Linking.canOpenURL(url).then(supported => {
      if (supported) {
        Linking.openURL(url)
      }
    }).catch(err => console.error("Error al abrir WhatsApp", err))
  }
}