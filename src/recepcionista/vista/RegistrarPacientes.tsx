import type React from "react"
import { View, Text, StyleSheet, ScrollView } from "react-native"
import { LinearGradient } from "expo-linear-gradient"

const RegistrarPacientes: React.FC = () => {
  return (
    <LinearGradient colors={["#D9534F", "#FFEBEE"]} style={styles.container}>
      <ScrollView contentContainerStyle={styles.content}>
        <View style={styles.card}>
          <Text style={styles.title}>Registrar Pacientes</Text>
          <Text style={styles.description}>
            Registra nuevos pacientes en el sistema con toda su información personal y médica.
          </Text>
        </View>
      </ScrollView>
    </LinearGradient>
  )
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  content: {
    padding: 20,
  },
  card: {
    backgroundColor: "#FFFFFF",
    borderRadius: 15,
    padding: 20,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 5,
  },
  title: {
    fontSize: 24,
    fontWeight: "bold",
    color: "#D9534F",
    marginBottom: 10,
  },
  description: {
    fontSize: 16,
    color: "#666",
    lineHeight: 24,
  },
})

export default RegistrarPacientes
