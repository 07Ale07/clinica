"use client"

import type React from "react"
import { useState, useEffect } from "react"
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  RefreshControl,
  TouchableOpacity,
  ActivityIndicator,
  Alert,
} from "react-native"
import { LinearGradient } from "expo-linear-gradient"
import { RecepcionistaHorariosController } from "../controlador/RecepcionistaHorariosController"
import type { Horario } from "../modelo/RecepcionistaHorariosModel"

const HorarioOdontologos: React.FC = () => {
  const [horarios, setHorarios] = useState<Horario[]>([])
  const [horariosAgrupados, setHorariosAgrupados] = useState<Map<string, Horario[]>>(new Map())
  const [loading, setLoading] = useState<boolean>(true)
  const [refreshing, setRefreshing] = useState<boolean>(false)
  const [diaSeleccionado, setDiaSeleccionado] = useState<string>("")

  const controller = new RecepcionistaHorariosController()
  const diasSemana = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]

  useEffect(() => {
    cargarHorarios()
  }, [diaSeleccionado])

  const cargarHorarios = async () => {
    try {
      setLoading(true)
      const dia = diaSeleccionado || undefined
      const horariosData = await controller.cargarHorariosOdontologos(undefined, dia)
      setHorarios(horariosData)

      const agrupados = controller.obtenerHorariosAgrupadosPorOdontologo(horariosData)
      setHorariosAgrupados(agrupados)
    } catch (error) {
      Alert.alert("Error", "No se pudieron cargar los horarios de los odontólogos")
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

  const seleccionarDia = (dia: string) => {
    setDiaSeleccionado(dia === diaSeleccionado ? "" : dia)
  }

  const renderHorariosPorOdontologo = (nombreOdontologo: string, horariosOdontologo: Horario[]) => {
    const horariosPorDia = controller.obtenerHorariosAgrupadosPorDia(horariosOdontologo)

    return (
      <View key={nombreOdontologo} style={styles.odontologoContainer}>
        <Text style={styles.odontologoNombre}>{nombreOdontologo}</Text>
        {Array.from(horariosPorDia.entries()).map(([dia, horariosDelDia]) => {
          if (horariosDelDia.length === 0) return null

          return (
            <View key={`${nombreOdontologo}-${dia}`} style={styles.diaSubContainer}>
              <Text style={styles.diaSubTitulo}>{dia}</Text>
              {horariosDelDia.map((horario) => (
                <View key={horario.id_horario} style={styles.horarioCardSmall}>
                  <Text style={styles.horarioHoraSmall}>
                    {controller.formatearHora(horario.hora_inicio)} - {controller.formatearHora(horario.hora_fin)}
                  </Text>
                </View>
              ))}
            </View>
          )
        })}
      </View>
    )
  }

  if (loading) {
    return (
      <LinearGradient colors={["#5CB85C", "#E8F5E9"]} style={styles.container}>
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" color="#FFFFFF" />
          <Text style={styles.loadingText}>Cargando horarios...</Text>
        </View>
      </LinearGradient>
    )
  }

  return (
    <LinearGradient colors={["#5CB85C", "#E8F5E9"]} style={styles.container}>
      <ScrollView
        contentContainerStyle={styles.content}
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh} tintColor="#5CB85C" />}
      >
        <View style={styles.card}>
          <Text style={styles.title}>Horario Odontólogos</Text>
          <Text style={styles.description}>Consulta los horarios disponibles de todos los odontólogos</Text>
        </View>

        <View style={styles.filtroCard}>
          <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={styles.filtroScroll}>
            <TouchableOpacity
              style={[styles.filtroBoton, !diaSeleccionado && styles.filtroBotonActivo]}
              onPress={() => setDiaSeleccionado("")}
            >
              <Text style={[styles.filtroTexto, !diaSeleccionado && styles.filtroTextoActivo]}>Todos</Text>
            </TouchableOpacity>
            {diasSemana.map((dia) => (
              <TouchableOpacity
                key={dia}
                style={[styles.filtroBoton, diaSeleccionado === dia && styles.filtroBotonActivo]}
                onPress={() => seleccionarDia(dia)}
              >
                <Text style={[styles.filtroTexto, diaSeleccionado === dia && styles.filtroTextoActivo]}>{dia}</Text>
              </TouchableOpacity>
            ))}
          </ScrollView>
        </View>

        {horarios.length === 0 ? (
          <View style={styles.emptyCard}>
            <Text style={styles.emptyText}>No hay horarios disponibles</Text>
          </View>
        ) : (
          <View style={styles.horariosContainer}>
            {Array.from(horariosAgrupados.entries()).map(([nombreOdontologo, horariosOdontologo]) =>
              renderHorariosPorOdontologo(nombreOdontologo, horariosOdontologo),
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
    color: "#5CB85C",
    marginBottom: 10,
  },
  description: {
    fontSize: 16,
    color: "#666",
    lineHeight: 24,
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
  filtroCard: {
    backgroundColor: "#FFFFFF",
    borderRadius: 15,
    padding: 12,
    marginBottom: 15,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 6,
    elevation: 3,
  },
  filtroScroll: {
    gap: 8,
  },
  filtroBoton: {
    paddingHorizontal: 16,
    paddingVertical: 8,
    borderRadius: 20,
    backgroundColor: "#F0F0F0",
  },
  filtroBotonActivo: {
    backgroundColor: "#5CB85C",
  },
  filtroTexto: {
    fontSize: 14,
    color: "#666",
    fontWeight: "500",
  },
  filtroTextoActivo: {
    color: "#FFFFFF",
    fontWeight: "bold",
  },
  horariosContainer: {
    gap: 15,
  },
  odontologoContainer: {
    backgroundColor: "#FFFFFF",
    borderRadius: 15,
    padding: 15,
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 6,
    elevation: 3,
  },
  odontologoNombre: {
    fontSize: 18,
    fontWeight: "bold",
    color: "#5CB85C",
    marginBottom: 12,
    borderBottomWidth: 2,
    borderBottomColor: "#5CB85C",
    paddingBottom: 8,
  },
  diaSubContainer: {
    marginBottom: 10,
  },
  diaSubTitulo: {
    fontSize: 14,
    fontWeight: "600",
    color: "#666",
    marginBottom: 6,
  },
  horarioCardSmall: {
    backgroundColor: "#F0F8F0",
    borderRadius: 8,
    padding: 10,
    marginBottom: 4,
    borderLeftWidth: 3,
    borderLeftColor: "#5CB85C",
  },
  horarioHoraSmall: {
    fontSize: 14,
    color: "#333",
    fontWeight: "500",
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

export default HorarioOdontologos
