import type React from "react"
import { View, Text, TouchableOpacity, StyleSheet, ScrollView } from "react-native"
import { useNavigation } from "@react-navigation/native"
import type { StackNavigationProp } from "@react-navigation/stack"
import type { RecepStackParamList } from "../../navigation/types"
import { LinearGradient } from "expo-linear-gradient"
import { Feather } from "@expo/vector-icons"
import * as Animatable from "react-native-animatable"

type RecepcionistaMainNavigationProp = StackNavigationProp<RecepStackParamList, "RecepcionistaMain">

const RecepcionistaMain: React.FC = () => {
  const navigation = useNavigation<RecepcionistaMainNavigationProp>()

  const menuOptions = [
    {
      title: "Mis Horarios",
      icon: "clock",
      screen: "MisHorarios" as const,
      color: ["#4B9CDB", "#2A6EBB"],
    },
    {
      title: "Horario Odontólogos",
      icon: "calendar",
      screen: "HorarioOdontologos" as const,
      color: ["#5CB85C", "#449D44"],
    },
    {
      title: "Sacar Turno",
      icon: "plus-circle",
      screen: "SacarTurnoRecep" as const,
      color: ["#F0AD4E", "#EC971F"],
    },
    {
      title: "Pagos",
      icon: "dollar-sign",
      screen: "Pagos" as const,
      color: ["#5BC0DE", "#31B0D5"],
    },
    {
      title: "Registrar Pacientes",
      icon: "user-plus",
      screen: "RegistrarPacientes" as const,
      color: ["#D9534F", "#C9302C"],
    },
  ]

  return (
    <LinearGradient colors={["#4B9CDB", "#E6F0FA"]} style={styles.container}>
      <ScrollView contentContainerStyle={styles.scrollContent}>
        <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
          <Text style={styles.title}>Panel de Recepción</Text>
          <Text style={styles.subtitle}>Gestión y Administración</Text>
        </Animatable.View>

        <View style={styles.menuContainer}>
          {menuOptions.map((option, index) => (
            <Animatable.View
              key={option.screen}
              animation="fadeInUp"
              duration={800}
              delay={index * 100}
              style={styles.menuItemWrapper}
            >
              <TouchableOpacity
                style={styles.menuItem}
                onPress={() => navigation.navigate(option.screen)}
                activeOpacity={0.8}
              >
                <LinearGradient colors={option.color} style={styles.menuItemGradient}>
                  <View style={styles.iconContainer}>
                    <Feather name={option.icon as any} size={32} color="#FFFFFF" />
                  </View>
                  <Text style={styles.menuItemText}>{option.title}</Text>
                  <Feather name="chevron-right" size={24} color="#FFFFFF" style={styles.chevron} />
                </LinearGradient>
              </TouchableOpacity>
            </Animatable.View>
          ))}
        </View>
      </ScrollView>
    </LinearGradient>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  scrollContent: {
    paddingHorizontal: 20,
    paddingVertical: 40,
  },
  headerContainer: {
    alignItems: "center",
    marginBottom: 30,
  },
  title: {
    fontSize: 32,
    fontWeight: "bold",
    color: "#FFFFFF",
    textShadowColor: "rgba(0, 0, 0, 0.2)",
    textShadowOffset: { width: 1, height: 1 },
    textShadowRadius: 4,
  },
  subtitle: {
    fontSize: 16,
    color: "#D1E6F9",
    marginTop: 8,
  },
  menuContainer: {
    gap: 15,
  },
  menuItemWrapper: {
    marginBottom: 5,
  },
  menuItem: {
    borderRadius: 15,
    overflow: "hidden",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 5,
  },
  menuItemGradient: {
    flexDirection: "row",
    alignItems: "center",
    padding: 20,
    minHeight: 80,
  },
  iconContainer: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: "rgba(255, 255, 255, 0.2)",
    justifyContent: "center",
    alignItems: "center",
    marginRight: 15,
  },
  menuItemText: {
    flex: 1,
    fontSize: 18,
    fontWeight: "600",
    color: "#FFFFFF",
  },
  chevron: {
    opacity: 0.8,
  },
})

export default RecepcionistaMain
