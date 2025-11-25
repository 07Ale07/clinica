"use client"

import type React from "react"
import { useState, useEffect } from "react"
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  Alert,
} from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"
import { TurnoController } from "../controlador/TurnoController"
import type { TurnoInfo } from "../modelo/TurnoModel"
import { LinearGradient } from "expo-linear-gradient"
import { Feather } from "@expo/vector-icons"
import * as Animatable from "react-native-animatable"
import * as Calendar from "expo-calendar"
import { styles } from "../css/TurnoVistaStyles"

const TurnoVista: React.FC = () => {
  const [dni, setDni] = useState<string>("")
  const [turnos, setTurnos] = useState<TurnoInfo[]>([])
  const [isLoading, setIsLoading] = useState<boolean>(false)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    ;(async () => {
      const { status } = await Calendar.requestCalendarPermissionsAsync()
      if (status !== "granted") {
        Alert.alert("Permiso denegado", "Se necesitan permisos para acceder al calendario.")
      }
    })()
  }, [])

  const handleConsultar = async () => {
    setIsLoading(true)
    setError(null)
    setTurnos([])

    try {
      const result = await TurnoController.fetchTurno(dni)
      if (result.length === 0) {
        setError("No existe ese DNI en mis registros")
      } else {
        console.log("Turnos recibidos:", result)
        setTurnos(result)
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : "Error desconocido")
    } finally {
      setIsLoading(false)
    }
  }

  const handleCancelTurno = async (id_cita: number) => {
    Alert.alert("Confirmar Cancelación", "¿Estás seguro de que deseas cancelar este turno?", [
      { text: "Cancelar", style: "cancel" },
      {
        text: "Confirmar",
        onPress: async () => {
          try {
            setIsLoading(true)
            await TurnoController.cancelTurno(id_cita)
            const updatedTurnos = turnos.map((turno) =>
              turno.id_cita === id_cita ? { ...turno, estado: "cancelada" } : turno,
            )
            setTurnos(updatedTurnos)
            Alert.alert("Éxito", "El turno ha sido cancelado.")
          } catch (error: any) {
            Alert.alert("Error", error.message || "No se pudo cancelar el turno.")
          } finally {
            setIsLoading(false)
          }
        },
      },
    ])
  }

  const getTurnoStatus = (fecha: string, estado: string | undefined) => {
    const now = new Date()
    const turnoDate = new Date(fecha)
    const today = new Date()
    today.setHours(0, 0, 0, 0)
    turnoDate.setSeconds(0, 0)
    const normalizedEstado = estado ? estado.toLowerCase() : "pendiente"

    const isDateBeforeToday = turnoDate < today
    const isTodayAndPastTime = turnoDate.getTime() === today.getTime() && now > turnoDate
    const isExpired = isDateBeforeToday && normalizedEstado !== "completada"
    const isPastTime = isTodayAndPastTime && normalizedEstado !== "completada"

    return {
      isCompleted: normalizedEstado === "completada",
      isExpired,
      isPastTime,
      isPending: normalizedEstado === "pendiente",
    }
  }

  const addToCalendar = async (turno: TurnoInfo) => {
    try {
      const calendars = await Calendar.getCalendarsAsync(Calendar.EntityTypes.EVENT)
      const defaultCalendar = calendars.find((cal) => cal.allowsModifications)

      if (!defaultCalendar) {
        Alert.alert("Error", "No se encontró un calendario modificable.")
        return
      }

      const turnoDate = new Date(turno.fecha)
      const startDate = new Date(turnoDate)
      startDate.setDate(turnoDate.getDate() - 2)
      const endDate = new Date(turnoDate)
      const events = await Calendar.getEventsAsync([defaultCalendar.id], startDate, endDate)
      const eventExists = events.some((event) => event.title === `Recordatorio: Turno ${turno.motivo}`)

      if (eventExists) {
        Alert.alert("Aviso", "Ya existe un recordatorio para este turno en el calendario.")
        return
      }

      Alert.alert("Elegir recordatorio", "¿Cuándo desea añadir el recordatorio?", [
        { text: "1 día antes", onPress: () => createEvent(turno, 1, defaultCalendar.id) },
        { text: "2 días antes", onPress: () => createEvent(turno, 2, defaultCalendar.id) },
        { text: "Cancelar", style: "cancel" },
      ])
    } catch (error) {
      console.error("Error al verificar calendario:", error)
      Alert.alert("Error", "No se pudo verificar el calendario.")
    }
  }

  const createEvent = async (turno: TurnoInfo, daysBefore: number, calendarId: string) => {
    try {
      const turnoDate = new Date(turno.fecha)
      const eventDate = new Date(turnoDate)
      eventDate.setDate(turnoDate.getDate() - daysBefore)

      const eventDetails = {
        title: `Recordatorio: Turno ${turno.motivo}`,
        startDate: eventDate,
        endDate: new Date(eventDate.getTime() + 60 * 60 * 1000),
        notes: `Turno para ${turno.nombre} ${turno.apellido} el ${formatFecha(turno.fecha)}`,
        calendarId,
        alarms: [{ relativeOffset: -15 }],
      }

      await Calendar.createEventAsync(calendarId, eventDetails)
      Alert.alert("Éxito", `Evento añadido para ${daysBefore} día${daysBefore > 1 ? "s" : ""} antes.`)
    } catch (error) {
      console.error("Error al añadir evento al calendario:", error)
      Alert.alert("Error", "No se pudo añadir el evento al calendario.")
    }
  }

  // Función para formatear fecha en español: "3 de abril de 2025"
  const formatFecha = (fechaIso: string): string => {
    const date = new Date(fechaIso)
    if (isNaN(date.getTime())) {
      return "Fecha inválida"
    }

    return new Intl.DateTimeFormat("es-ES", {
      day: "numeric",
      month: "long",
      year: "numeric",
    }).format(date)
  }

  return (
    <SafeAreaView style={styles.safeArea}>
      <LinearGradient colors={["#4B9CDB", "#E6F0FA"]} style={styles.container}>
        <KeyboardAvoidingView
          behavior={Platform.OS === "ios" ? "padding" : "height"}
          style={styles.container}
          keyboardVerticalOffset={Platform.OS === "ios" ? 100 : 0}
        >
          <ScrollView contentContainerStyle={styles.scrollContainer} keyboardShouldPersistTaps="handled">
            <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
              <Text style={styles.title}>Consultar Turno</Text>
            </Animatable.View>

            <Animatable.View animation="fadeInUp" duration={1200} style={styles.formContainer}>
              <View style={styles.inputContainer}>
                <Feather name="search" size={24} color="#4B9CDB" style={styles.icon} />
                <TextInput
                  style={styles.input}
                  placeholder="Ingrese su DNI"
                  placeholderTextColor="#8A8F9E"
                  value={dni}
                  onChangeText={setDni}
                  keyboardType="numeric"
                  editable={!isLoading}
                />
              </View>

              <TouchableOpacity onPress={handleConsultar} disabled={isLoading} style={styles.button}>
                <LinearGradient colors={["#4B9CDB", "#2A6EBB"]} style={styles.buttonGradient}>
                  <Text style={styles.buttonText}>{isLoading ? "Consultando..." : "Consultar"}</Text>
                </LinearGradient>
              </TouchableOpacity>

              {error && <Text style={styles.errorText}>{error}</Text>}

              {turnos.map((turno, index) => {
                const { isCompleted, isExpired, isPastTime, isPending } = getTurnoStatus(turno.fecha, turno.estado)
                return (
                  <Animatable.View key={index} animation="fadeInUp" duration={800 + index * 100}>
                    <View style={styles.turnoCardContainer}>
                      <View style={styles.turnoHeaderDecoration}>
                        <View style={styles.turnoHeaderLeft}>
                          <View
                            style={[
                              styles.statusBadge,
                              isCompleted && styles.statusCompleted,
                              isPastTime && styles.statusPastTime,
                              isExpired && styles.statusExpired,
                              isPending && styles.statusPending,
                            ]}
                          >
                            <Feather
                              name={isCompleted ? "check-circle" : isPending ? "clock" : "alert-circle"}
                              size={16}
                              color="#FFFFFF"
                            />
                            <Text style={styles.statusBadgeText}>
                              {isCompleted ? "Completado" : isPending ? "Pendiente" : isExpired ? "Expirado" : "Pasado"}
                            </Text>
                          </View>
                        </View>
                        <View style={styles.turnoHeaderRight}>
                          <Feather name="calendar" size={20} color="#4B9CDB" />
                        </View>
                      </View>

                      <View style={styles.dividerLine} />

                      <View style={styles.turnoInfoSection}>
                        <View style={styles.infoRow}>
                          <Feather name="user" size={18} color="#4B9CDB" style={styles.infoIcon} />
                          <View style={styles.infoContent}>
                            <Text style={styles.infoLabel}>Paciente</Text>
                            <Text style={styles.infoValue}>
                              {turno.nombre} {turno.apellido}
                            </Text>
                          </View>
                        </View>

                        <View style={styles.miniDivider} />

                        <View style={styles.infoRow}>
                          <Feather name="briefcase" size={18} color="#4B9CDB" style={styles.infoIcon} />
                          <View style={styles.infoContent}>
                            <Text style={styles.infoLabel}>Motivo</Text>
                            <Text style={styles.infoValue}>{turno.motivo}</Text>
                          </View>
                        </View>

                        <View style={styles.miniDivider} />

                        <View style={styles.infoRow}>
                          <Feather name="calendar" size={18} color="#4B9CDB" style={styles.infoIcon} />
                          <View style={styles.infoContent}>
                            <Text style={styles.infoLabel}>Fecha y Hora</Text>
                            <Text style={styles.infoValue}>{formatFecha(turno.fecha)}</Text>
                          </View>
                        </View>
                      </View>

                      <View style={styles.statusMessageContainer}>
                        {isCompleted && (
                          <View style={styles.statusMessage}>
                            <Feather name="check" size={16} color="#008000" />
                            <Text style={styles.completedText}>Turno atendido correctamente</Text>
                          </View>
                        )}
                        {isPastTime && (
                          <View style={styles.statusMessage}>
                            <Feather name="alert-circle" size={16} color="#FF8C00" />
                            <Text style={styles.pastTimeText}>Turno pasado de hora</Text>
                          </View>
                        )}
                        {isExpired && !isPastTime && (
                          <View style={styles.statusMessage}>
                            <Feather name="x-circle" size={16} color="#FF4444" />
                            <Text style={styles.expiredText}>Este turno ha expirado</Text>
                          </View>
                        )}
                      </View>

                      {!isCompleted && !isExpired && !isPastTime && isPending && (
                        <View style={styles.actionButtonsContainer}>
                          <TouchableOpacity style={styles.recordatorioButton} onPress={() => addToCalendar(turno)}>
                            <Feather name="bell" size={18} color="#4B9CDB" />
                            <Text style={styles.recordatorioText}>Añadir Recordatorio</Text>
                          </TouchableOpacity>
                          <View style={styles.buttonDivider} />
                          <TouchableOpacity
                            style={styles.cancelButton}
                            onPress={() => handleCancelTurno(turno.id_cita)}
                          >
                            <Feather name="x" size={18} color="#FF4444" />
                            <Text style={styles.cancelText}>Cancelar Turno</Text>
                          </TouchableOpacity>
                        </View>
                      )}
                    </View>
                  </Animatable.View>
                )
              })}
            </Animatable.View>
          </ScrollView>
        </KeyboardAvoidingView>
      </LinearGradient>
    </SafeAreaView>
  )
}

export default TurnoVista