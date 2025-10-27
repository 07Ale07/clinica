import { LandingModel, type LandingData } from "../modelo/LandingModel"

export class LandingController {
  static getLandingData(): LandingData {
    // En una aplicación real, aquí se haría una llamada a la API
    return LandingModel.getMockData()
  }

  static handleNavigateToLogin(navigation: any): void {
    navigation.navigate("Login")
  }

  static handleWhatsAppContact(): void {
    const phoneNumber = "3704376847"
    const message = "Hola, me interesa saber más sobre sus servicios"
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`
    // En React Native se usaría Linking.openURL(url)
    console.log("Opening WhatsApp:", url)
  }

  static handleSocialMedia(platform: string): void {
    console.log(`Opening ${platform}`)
    // Aquí se implementaría la lógica para abrir redes sociales
  }
}
