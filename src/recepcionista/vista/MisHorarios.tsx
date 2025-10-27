"use client"

import type React from "react"
import { useState, useEffect } from "react"
import { View, Text, StyleSheet, ScrollView, RefreshControl, ActivityIndicator, Alert } from "react-native"
import { LinearGradient } from "expo-linear-gradient"
import { RecepcionistaHorariosController } from "../controlador/RecepcionistaHorariosController"
import type { Horario } from "../modelo/RecepcionistaHorariosModel"

interface MisHorariosProps {
  idEmpleado: number
  nombreEmpleado?: string
}

const MisHorarios: React.FC<MisHorariosProps> = ({ idEmpleado, nombreEmpleado = "Recepcionista" }) => {
  const [horarios, setHorarios] = useState<Horario[]>([])
  const [horariosAgrupados, setHorariosAgrupados] = useState<Map<string, Horario[]>>(new Map())
  const [loading, setLoading] = useState<boolean>(true)
  const [refreshing, setRefreshing] = useState<boolean>(false)

  const controller = new RecepcionistaHorariosController()

  useEffect(() => {
    cargarHorarios()
  }, [])

  const cargarHorarios = async () => {
    try {
      setLoading(true)
      const horariosData = await controller.cargarMisHorarios(idEmpleado)
      setHorarios(horariosData)

      const agrupados = controller.obtenerHorariosAgrupadosPorDia(horariosData)
      setHorariosAgrupados(agrupados)
    } catch (error) {
      Alert.alert("Error", "No se pudieron cargar los horarios")
      console.error(error)
    } finally {
      setLoading(false)
    }
  }

  const onRefresh = async () => {
    setRefreshing(true)
    await cargarHorarios()
    setRefreshing(false)
  }

  const renderHorarioPorDia = (dia: string, horariosDelDia: Horario[]) => {
    if (horariosDelDia.length === 0) return null

    return (
      <View key={dia} style={styles.diaContainer}>
        <Text style={styles.diaTitulo}>{dia}</Text>
        {horariosDelDia.map((horario) => (
          <View key={horario.id_horario} style={styles.horarioCard}>
            <View style={styles.horarioInfo}>
              <Text style={styles.horarioHora}>
                {controller.formatearHora(horario.hora_inicio)} - {controller.formatearHora(horario.hora_fin)}
              </Text>
              {horario.fecha_desde && horario.fecha_hasta && (
                <Text style={styles.horarioFechas}>
                  Desde: {horario.fecha_desde} | Hasta: {horario.fecha_hasta}
                </Text>
              )}
            </View>
            <View style={[styles.estadoBadge, horario.activo ? styles.estadoActivo : styles.estadoInactivo]}>
              <Text style={styles.estadoTexto}>{horario.activo ? "Activo" : "Inactivo"}</Text>
            </View>
          </View>
        ))}
      </View>
    )
  }

  if (loading) {
    return (
      <LinearGradient colors={["#4B9CDB", "#E6F0FA"]} style={styles.container}>
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" color="#FFFFFF" />
          <Text style={styles.loadingText}>Cargando horarios...</Text>
        </View>
      </LinearGradient>
    )
  }

  return (
    <LinearGradient colors={["#4B9CDB", "#E6F0FA"]} style={styles.container}>
      <ScrollView
        contentContainerStyle={styles.content}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} tintColor="#4B9CDB" />}
      >
        <View style={styles.card}>
          <Text style={styles.title}>Mis Horarios</Text>
          <Text style={styles.subtitle}>{nombreEmpleado}</Text>
        </View>

        {horarios.length === 0 ? (
          <View style={styles.emptyCard}>
            <Text style={styles.emptyText}>No tienes horarios asignados</Text>
          </View>
        ) : (
          <View style={styles.horariosContainer}>
            {Array.from(horariosAgrupados.entries()).map(([dia, horariosDelDia]) =>
              renderHorarioPorDia(dia, horariosDelDia),
            )}
          </View>
        )}
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
    marginBottom: 15,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 5,
  },
  title: {
    fontSize: 24,
    fontWeight: "bold",
    color: "#4B9CDB",
    marginBottom: 5,
  },
  subtitle: {
    fontSize: 14,
    color: "#666",
  },
  loadingContainer: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  loadingText: {
    marginTop: 10,
    fontSize: 16,
    color: "#FFFFFF",
    fontWeight: "500",
  },
  horariosContainer: {
    gap: 15,
  },
  diaContainer: {
    backgroundColor: "#FFFFFF",
    borderRadius: 15,
    padding: 15,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 6,
    elevation: 3,
  },
  diaTitulo: {
    fontSize: 18,
    fontWeight: "bold",
    color: "#4B9CDB",
    marginBottom: 12,
    borderBottomWidth: 2,
    borderBottomColor: "#4B9CDB",
    paddingBottom: 8,
  },
  horarioCard: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    backgroundColor: "#F0F8FF",
    borderRadius: 10,
    padding: 12,
    marginBottom: 8,
    borderLeftWidth: 4,
    borderLeftColor: "#4B9CDB",
  },
  horarioInfo: {
    flex: 1,
  },
  horarioHora: {
    fontSize: 16,
    fontWeight: "600",
    color: "#333",
    marginBottom: 4,
  },
  horarioFechas: {
    fontSize: 12,
    color: "#666",
  },
  estadoBadge: {
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderRadius: 12,
  },
  estadoActivo: {
    backgroundColor: "#4CAF50",
  },
  estadoInactivo: {
    backgroundColor: "#F44336",
  },
  estadoTexto: {
    fontSize: 12,
    fontWeight: "bold",
    color: "#FFFFFF",
  },
  emptyCard: {
    backgroundColor: "#FFFFFF",
    borderRadius: 15,
    padding: 40,
    alignItems: "center",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 6,
    elevation: 3,
  },
  emptyText: {
    fontSize: 16,
    color: "#999",
    textAlign: "center",
  },
})

export default MisHorarios
