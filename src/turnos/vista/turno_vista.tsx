"use client"

import React, { useState, useEffect } from "react"
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  ScrollView,
  KeyboardAvoidingView,
  Platform,
  Alert,
  StatusBar,
} from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"
import { TurnoController } from "../controlador/TurnoController"
import type { TurnoInfo } from "../modelo/TurnoModel"
import { LinearGradient } from "expo-linear-gradient"
import { Feather } from "@expo/vector-icons"
import * as Animatable from "react-native-animatable"
import * as Calendar from "expo-calendar"
import { styles } from "../css/TurnoVistaStyles"

const TurnoVista = () => {
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
    if (!dni.trim()) {
      setError("Por favor ingrese un DNI")
      return
    }

    setIsLoading(true)
    setError(null)
    setTurnos([])

    try {
      const result = await TurnoController.fetchTurno(dni)
      if (result.length === 0) {
        setError("No existe ese DNI en nuestros registros")
      } else {
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
        style: "destructive",
        onPress: async () => {
          try {
            setIsLoading(true)
            await TurnoController.cancelTurno(id_cita)
            setTurnos(prev => prev.map(t =>
              t.id_cita === id_cita ? { ...t, estado: "cancelada" } : t
            ))
            Alert.alert("Éxito", "El turno ha sido cancelado correctamente.")
          } catch (err: any) {
            Alert.alert("Error", err.message || "No se pudo cancelar el turno.")
          } finally {
            setIsLoading(false)
          }
        },
      },
    ])
  }

  const getTurnoStatus = (fecha: string, estado?: string) => {
    const now = new Date()
    const turnoDate = new Date(fecha)
    const today = new Date()
    today.setHours(0, 0, 0, 0)

    const normalizedEstado = estado?.toLowerCase() || "pendiente"
    const isToday = turnoDate.toDateString() === now.toDateString()
    const isPast = turnoDate < now
    const isExpired = isPast && normalizedEstado !== "completada"
    const isPending = normalizedEstado === "pendiente"
    const isCompleted = normalizedEstado === "completada"

    return { isToday, isPast, isExpired, isPending, isCompleted }
  }

  const addToCalendar = async (turno: TurnoInfo) => {
    try {
      const calendars = await Calendar.getCalendarsAsync(Calendar.EntityTypes.EVENT)
      const defaultCalendar = calendars.find(cal => cal.allowsModifications)

      if (!defaultCalendar) {
        Alert.alert("Error", "No se encontró un calendario editable.")
        return
      }

      Alert.alert(
        "Recordatorio",
        "¿Cuántos días antes quieres el recordatorio?",
        [
          { text: "1 día antes", onPress: () => createEvent(turno, 1, defaultCalendar.id) },
          { text: "2 días antes", onPress: () => createEvent(turno, 2, defaultCalendar.id) },
          { text: "Cancelar", style: "cancel" },
        ],
        { cancelable: true }
      )
    } catch (error) {
      Alert.alert("Error", "No se pudo acceder al calendario.")
    }
  }

  const createEvent = async (turno: TurnoInfo, daysBefore: number, calendarId: string) => {
    try {
      const eventDate = new Date(turno.fecha)
      eventDate.setDate(eventDate.getDate() - daysBefore)

      await Calendar.createEventAsync(calendarId, {
        title: `Recordatorio: Turno Dental - ${turno.motivo}`,
        startDate: eventDate,
        endDate: new Date(eventDate.getTime() + 60 * 60 * 1000),
        notes: `Turno con ${turno.nombre} ${turno.apellido} el ${formatFecha(turno.fecha)}`,
        timeZone: "America/Argentina/Buenos_Aires",
        alarms: [{ relativeOffset: -30 }],
      })

      Alert.alert("Éxito", `Recordatorio añadido para ${daysBefore} día${daysBefore > 1 ? "s" : ""} antes`)
    } catch (error) {
      Alert.alert("Error", "No se pudo crear el evento")
    }
  }

  const formatFecha = (fechaIso: string): string => {
    const date = new Date(fechaIso)
    if (isNaN(date.getTime())) return "Fecha inválida"

    return new Intl.DateTimeFormat("es-ES", {
      weekday: "long",
      day: "numeric",
      month: "long",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    }).format(date)
  }

  return (
    <>
      <StatusBar backgroundColor="transparent" translucent barStyle="dark-content" />

      <SafeAreaView style={{ flex: 1 }} edges={["left", "right"]}>
        <LinearGradient colors={["#4B9CDB", "#E6F0FA"]} style={{ flex: 1 }}>
          <KeyboardAvoidingView
            behavior={Platform.OS === "ios" ? "padding" : "height"}
            style={{ flex: 1 }}
            keyboardVerticalOffset={Platform.OS === "ios" ? 90 : 0}
          >
            <ScrollView
              contentContainerStyle={styles.scrollContainer}
              keyboardShouldPersistTaps="handled"
              showsVerticalScrollIndicator={false}
            >
              <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
                <Text style={styles.title}>Consultar Turno</Text>
              </Animatable.View>

              <Animatable.View animation="fadeInUp" duration={1200} style={styles.formContainer}>
                <View style={styles.inputContainer}>
                  <Feather name="search" size={24} color="#4B9CDB" style={styles.icon} />
                  <TextInput
                    style={styles.input}
                    placeholder="Ingrese su DNI (sin puntos)"
                    placeholderTextColor="#8A8F9E"
                    value={dni}
                    onChangeText={setDni}
                    keyboardType="numeric"
                    editable={!isLoading}
                    maxLength={8}
                  />
                </View>

                <TouchableOpacity onPress={handleConsultar} disabled={isLoading} style={styles.button}>
                  <LinearGradient colors={["#4B9CDB", "#2A6EBB"]} style={styles.buttonGradient}>
                    <Text style={styles.buttonText}>
                      {isLoading ? "Consulta..." : "Consultar Turno"}
                    </Text>
                  </LinearGradient>
                </TouchableOpacity>

                {error && <Text style={styles.errorText}>{error}</Text>}

                {turnos.map((turno, index) => {
                  const { isExpired, isPending, isCompleted } = getTurnoStatus(turno.fecha, turno.estado)

                  return (
                    <Animatable.View key={turno.id_cita} animation="fadeInUp" delay={index * 100}>
                      <View style={styles.turnoCardContainer}>
                        <View style={styles.turnoHeaderDecoration}>
                          <View style={styles.turnoHeaderLeft}>
                            <View style={[
                              styles.statusBadge,
                              isCompleted && styles.statusCompleted,
                              isExpired && styles.statusExpired,
                              isPending && styles.statusPending,
                            ]}>
                              <Feather
                                name={isCompleted ? "check-circle" : isExpired ? "x-circle" : "clock"}
                                size={16}
                                color="#fff"
                              />
                              <Text style={styles.statusBadgeText}>
                                {isCompleted ? "Completado" : isExpired ? "Expirado" : "Pendiente"}
                              </Text>
                            </View>
                          </View>
                          <Feather name="calendar" size={22} color="#4B9CDB" />
                        </View>

                        <View style={styles.dividerLine} />

                        <View style={styles.turnoInfoSection}>
                          <View style={styles.infoRow}>
                            <Feather name="user" size={18} color="#4B9CDB" style={styles.infoIcon} />
                            <View style={styles.infoContent}>
                              <Text style={styles.infoLabel}>Paciente</Text>
                              <Text style={styles.infoValue}>{turno.nombre} {turno.apellido}</Text>
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

                        {!isCompleted && !isExpired && (
                          <View style={styles.actionButtonsContainer}>
                            <TouchableOpacity style={styles.recordatorioButton} onPress={() => addToCalendar(turno)}>
                              <Feather name="bell" size={18} color="#4B9CDB" />
                              <Text style={styles.recordatorioText}>Recordatorio</Text>
                            </TouchableOpacity>

                            <View style={styles.buttonDivider} />

                            <TouchableOpacity style={styles.cancelButton} onPress={() => handleCancelTurno(turno.id_cita)}>
                              <Feather name="x" size={18} color="#FF4444" />
                              <Text style={styles.cancelText}>Cancelar</Text>
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
    </>
  )
}

export default TurnoVista