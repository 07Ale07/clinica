// LandingView.tsx
"use client"

import type React from "react"
import { useState, useEffect, useRef } from "react"
import {
  View,
  Text,
  ScrollView,
  TouchableOpacity,
  Dimensions,
  Animated,
  Linking,
} from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"
import { useNavigation } from "@react-navigation/native"
import type { StackNavigationProp } from "@react-navigation/stack"
import { Ionicons } from "@expo/vector-icons"
import { LinearGradient } from "expo-linear-gradient"
import { LandingController } from "../controlador/LandingController"
import { landingStyles } from "../css/LandingStyles"
import type { RootStackParamList } from "../../navigation/types"

type LandingNavigationProp = StackNavigationProp<RootStackParamList, "Landing">

const { width } = Dimensions.get("window")

const LandingView: React.FC = () => {
  const navigation = useNavigation<LandingNavigationProp>()
  const [currentSlide, setCurrentSlide] = useState(0)
  const scrollViewRef = useRef<ScrollView>(null)
  const fadeAnim = useRef(new Animated.Value(0)).current

  const data = LandingController.getLandingData()

  useEffect(() => {
    Animated.timing(fadeAnim, {
      toValue: 1,
      duration: 1000,
      useNativeDriver: true,
    }).start()

    // Auto-scroll del carrusel
    const interval = setInterval(() => {
      setCurrentSlide((prev) => {
        const next = (prev + 1) % data.procedures.length
        scrollViewRef.current?.scrollTo({ x: next * width, animated: true })
        return next
      })
    }, 5000)

    return () => clearInterval(interval)
  }, [data.procedures.length])

  // WhatsApp con número dinámico desde la base de datos
  const handleWhatsApp = async () => {
    try {
      await LandingController.openWhatsApp()
    } catch (error) {
      // Fallback silencioso: si falla la API, abre WhatsApp con número por defecto
      const fallbackUrl = "https://wa.me/5493704037812?text=Hola,%20me%20interesa%20saber%20más%20sobre%20sus%20servicios"
      Linking.canOpenURL(fallbackUrl).then((supported) => {
        if (supported) Linking.openURL(fallbackUrl)
      })
    }
  }

  return (
    <SafeAreaView style={landingStyles.container} edges={["top", "left", "right", "bottom"]}>
      <ScrollView showsVerticalScrollIndicator={false} stickyHeaderIndices={[1]}>
        {/* Top Banner */}
        <LinearGradient colors={["#1a4b8c", "#2c5aa0"]} style={landingStyles.topBanner}>
          <Ionicons name="trophy" size={20} color="#ffd166" />
          <Text style={landingStyles.topBannerText}>
            ¡Somos la mejor clínica dental de la región! Reconocidos por nuestra excelencia en 2025
          </Text>
        </LinearGradient>

        {/* Header con Logo y 3 Botones */}
        <View style={landingStyles.header}>
          <View style={landingStyles.logoContainer}>
            <Ionicons name="fitness" size={40} color="#00d4aa" />
            <Text style={landingStyles.logoText}>DentalSmile</Text>
          </View>

          <View style={landingStyles.headerButtonsContainer}>
            <TouchableOpacity
              style={landingStyles.headerButton}
              onPress={() => navigation.navigate("Login")}
            >
              <Ionicons name="log-in-outline" size={20} color="#1a4b8c" />
              <Text style={landingStyles.headerButtonText}>Iniciar Sesión</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={landingStyles.headerButton}
              onPress={() => navigation.navigate("TurnoConsulta")}
            >
              <Ionicons name="search-outline" size={20} color="#1a4b8c" />
              <Text style={landingStyles.headerButtonText}>Mis Turnos</Text>
            </TouchableOpacity>

            <TouchableOpacity
              style={landingStyles.headerButton}
              onPress={() => navigation.navigate("SacarTurno")}
            >
              <Ionicons name="calendar-outline" size={20} color="#1a4b8c" />
              <Text style={landingStyles.headerButtonText}>Sacar Turno</Text>
            </TouchableOpacity>
          </View>
        </View>

        {/* Hero Section */}
        <LinearGradient colors={["#1a4b8c", "#2c5aa0", "#00d4aa"]} style={landingStyles.heroSection}>
          <Animated.View style={{ opacity: fadeAnim }}>
            <Ionicons name="fitness" size={80} color="#fff" style={landingStyles.heroIcon} />
            <Text style={landingStyles.heroTitle}>DentalSmile Premium</Text>
            <Text style={landingStyles.heroSubtitle}>Sonrisas perfectas perfectas, cuidado excepcional</Text>
            <Text style={landingStyles.heroDescription}>Transformamos Sonrisas, Creamos Confianza</Text>
          </Animated.View>
        </LinearGradient>

        {/* Carrusel de Procedimientos */}
        <View style={landingStyles.section}>
          <View style={landingStyles.sectionHeader}>
            <Ionicons name="medical" size={28} color="#1a4b8c" />
            <Text style={landingStyles.sectionTitle}>Nuestros Procedimientos</Text>
          </View>
          <Text style={landingStyles.sectionSubtitle}>Ofrecemos los tratamientos dentales avanzados</Text>

          <View style={landingStyles.carouselContainer}>
            <ScrollView
              ref={scrollViewRef}
              horizontal
              pagingEnabled
              showsHorizontalScrollIndicator={false}
              onMomentumScrollEnd={(event) => {
                const slideIndex = Math.round(event.nativeEvent.contentOffset.x / width)
                setCurrentSlide(slideIndex)
              }}
            >
              {data.procedures.map((procedure, index) => (
                <View key={index} style={[landingStyles.procedureSlide, { width }]}>
                  <View style={landingStyles.procedureCard}>
                    <View style={landingStyles.procedureImagePlaceholder}>
                      <Ionicons name="medical" size={60} color="#00d4aa" />
                    </View>
                    <Text style={landingStyles.procedureTitle}>{procedure.descripcion}</Text>
                    <Text style={landingStyles.procedurePrice}>${procedure.costo}</Text>
                    <Text style={landingStyles.procedureDescription}>
                      Tratamiento profesional con tecnología de vanguardia
                    </Text>
                    <TouchableOpacity style={landingStyles.procedureButton}>
                      <Text style={landingStyles.procedureButtonText}>Más Información</Text>
                    </TouchableOpacity>
                  </View>
                </View>
              ))}
            </ScrollView>

            <View style={landingStyles.carouselIndicators}>
              {data.procedures.map((_, index) => (
                <View
                  key={index}
                  style={[
                    landingStyles.indicator,
                    currentSlide === index && landingStyles.indicatorActive,
                  ]}
                />
              ))}
            </View>
          </View>
        </View>

        {/* Sección Informativa */}
        <View style={landingStyles.infoSection}>
          <View style={landingStyles.infoCard}>
            <Ionicons name="hardware-chip" size={50} color="#00d4aa" />
            <Text style={landingStyles.infoTitle}>Tecnología de Vanguardia</Text>
            <Text style={landingStyles.infoText}>
              Diagnósticos precisos y tratamientos mínimamente invasivos con equipos de última generación.
            </Text>
          </View>

          <View style={landingStyles.infoCard}>
            <Ionicons name="people" size={50} color="#00d4aa" />
            <Text style={landingStyles.infoTitle}>Enfoque Personalizado</Text>
            <Text style={landingStyles.infoText}>
              Planes únicos adaptados a tus necesidades y objetivos estéticos.
            </Text>
          </View>

          <View style={landingStyles.infoCard}>
            <Ionicons name="star" size={50} color="#00d4aa" />
            <Text style={landingStyles.infoTitle}>Compromiso con la Excelencia</Text>
            <Text style={landingStyles.infoText}>
              Estándares internacionales de calidad y bioseguridad en cada consulta.
            </Text>
          </View>
        </View>

        {/* Testimonios */}
        <View style={landingStyles.testimonialSection}>
          <Text style={landingStyles.sectionTitle}>Opiniones de Nuestros Pacientes</Text>
          <View style={landingStyles.testimonialCard}>
            <Ionicons name="chatbox-ellipses" size={40} color="#00d4aa" />
            <Text style={landingStyles.testimonialText}>
              "La atención es excelente, los resultados superaron mis expectativas. ¡Totalmente recomendado!"
            </Text>
            <Text style={landingStyles.testimonialAuthor}>- María González</Text>
          </View>
        </View>

        {/* Equipo Profesional */}
        <View style={landingStyles.section}>
          <View style={landingStyles.sectionHeader}>
            <Ionicons name="people-circle" size={28} color="#1a4b8c" />
            <Text style={landingStyles.sectionTitle}>Nuestro Equipo</Text>
          </View>
          <Text style={landingStyles.sectionSubtitle}>Profesionales altamente capacitados</Text>

          <View style={landingStyles.teamGrid}>
            {data.employees.map((employee, index) => (
              <View key={index} style={landingStyles.teamCard}>
                <View style={landingStyles.avatarPlaceholder}>
                  <Ionicons name="person" size={50} color="#00d4aa" />
                </View>
                <Text style={landingStyles.employeeName}>
                  Dr. {employee.nombre} {employee.apellido}
                </Text>
                <Text style={landingStyles.employeeRole}>
                  {employee.especialidad || "Especialista Dental"}
                </Text>
                <Text style={landingStyles.employeeDesc}>Años de experiencia creando sonrisas</Text>
              </View>
            ))}
          </View>
        </View>

        {/* Obras Sociales */}
        <View style={landingStyles.section}>
          <View style={landingStyles.sectionHeader}>
            <Ionicons name="shield-checkmark" size={28} color="#1a4b8c" />
            <Text style={landingStyles.sectionTitle}>Obras Sociales</Text>
          </View>
          <Text style={landingStyles.sectionSubtitle}>Trabajamos con las principales prepagas</Text>

          <View style={landingStyles.insuranceGrid}>
            {data.socialWorks.map((work, index) => (
              <View key={index} style={landingStyles.insuranceCard}>
                <Ionicons name="shield-checkmark" size={40} color="#00d4aa" />
                <Text style={landingStyles.insuranceName}>{work.nombre}</Text>
                <View style={landingStyles.insuranceDetails}>
                  <Ionicons name="call" size={16} color="#6c757d" />
                  <Text style={landingStyles.insuranceText}>{work.telefono}</Text>
                </View>
                <View style={landingStyles.insuranceDetails}>
                  <Ionicons name="location" size={16} color="#6c757d" />
                  <Text style={landingStyles.insuranceText}>{work.direccion}</Text>
                </View>
              </View>
            ))}
          </View>
        </View>

        {/* Footer */}
        <LinearGradient colors={["#1a4b8c", "#0d2847"]} style={landingStyles.footer}>
          <Ionicons name="fitness" size={50} color="#00d4aa" />
          <Text style={landingStyles.footerTitle}>DentalSmile Premium</Text>
          <Text style={landingStyles.footerSubtitle}>Tu sonrisa es nuestra pasión</Text>

          <View style={landingStyles.socialLinks}>
            <TouchableOpacity style={landingStyles.socialButton}>
              <Ionicons name="logo-facebook" size={28} color="#fff" />
            </TouchableOpacity>
            <TouchableOpacity style={landingStyles.socialButton}>
              <Ionicons name="logo-instagram" size={28} color="#fff" />
            </TouchableOpacity>
            <TouchableOpacity style={landingStyles.socialButton}>
              <Ionicons name="logo-twitter" size={28} color="#fff" />
            </TouchableOpacity>
            <TouchableOpacity style={landingStyles.socialButton}>
              <Ionicons name="logo-linkedin" size={28} color="#fff" />
            </TouchableOpacity>
          </View>

          <Text style={landingStyles.footerCopyright}>
            © 2025 DentalSmile Premium. Todos los derechos reservados.
          </Text>
        </LinearGradient>
      </ScrollView>

      {/* Botón Flotante WhatsApp - Número desde DB */}
      <TouchableOpacity style={landingStyles.floatingButton} onPress={handleWhatsApp}>
        <Ionicons name="logo-whatsapp" size={32} color="#fff" />
      </TouchableOpacity>
    </SafeAreaView>
  )
}

export default LandingView