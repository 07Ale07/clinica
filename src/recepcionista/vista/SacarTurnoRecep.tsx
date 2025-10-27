import type React from "react"
import { View, Text, StyleSheet, ScrollView } from "react-native"
import { LinearGradient } from "expo-linear-gradient"

const SacarTurnoRecep: React.FC = () => {
  return (
    <LinearGradient colors={["#F0AD4E", "#FFF3E0"]} style={styles.container}>
      <ScrollView contentContainerStyle={styles.content}>
        <View style={styles.card}>
          <Text style={styles.title}>Sacar Turno</Text>
          <Text style={styles.description}>Agenda nuevos turnos para los pacientes de manera rápida y eficiente.</Text>
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
    color: "#F0AD4E",
    marginBottom: 10,
  },
  description: {
    fontSize: 16,
    color: "#666",
    lineHeight: 24,
  },
})

export default SacarTurnoRecep
