"use client"

import React, { useEffect, useRef } from "react"
import { View, Text, TouchableOpacity, Animated } from "react-native"
import type { Turno, Paciente, Odontologo } from "../modelo/Paciente"
import { turnoStyles } from "../css/sacar-turno-styles"
import { createScaleAnimation } from "../css/animations"

interface Props {
  paciente: Paciente
  odontologo: Odontologo
  fecha: string
  hora: string
  email?: string
  turnoConfirmado: Turno
  onVolver: () => void
}

const ConfirmacionTurno: React.FC<Props> = ({
  paciente,
  odontologo,
  fecha,
  hora,
  email,
  turnoConfirmado,
  onVolver,
}) => {
  const scaleAnim = useRef(new Animated.Value(0)).current
  const buttonScale = useRef(new Animated.Value(1)).current

  useEffect(() => {
    createScaleAnimation(scaleAnim, 1, 500).start()
  }, [])

  useEffect(() => {
    console.log("[v0] ConfirmacionTurno received data:")
    console.log("[v0] paciente:", paciente)
    console.log("[v0] odontologo:", odontologo)
    console.log("[v0] fecha:", fecha)
    console.log("[v0] hora:", hora)
    console.log("[v0] turnoConfirmado:", turnoConfirmado)
  }, [])

  const formatDate = (dateString: string): string => {
    if (!dateString) return "Fecha no disponible"
    const [year, month, day] = dateString.split("-")
    return `${day}/${month}/${year}`
  }

  if (!turnoConfirmado || !odontologo || !paciente || !fecha || !hora) {
    console.log("[v0] Missing critical data:", {
      turnoConfirmado: !!turnoConfirmado,
      odontologo: !!odontologo,
      paciente: !!paciente,
      fecha: !!fecha,
      hora: !!hora,
    })
    return (
      <View style={[turnoStyles.card, { justifyContent: "center", alignItems: "center", minHeight: 300 }]}>
        <Text style={{ fontSize: 16, color: "#EF4444", textAlign: "center" }}>
          Error: datos de confirmación incompletos
        </Text>
        <Text style={{ fontSize: 12, color: "#666", marginTop: 10, textAlign: "center" }}>
          Por favor, vuelva al inicio e intente nuevamente
        </Text>
        <TouchableOpacity style={[turnoStyles.primaryButton, { marginTop: 20, width: "80%" }]} onPress={onVolver}>
          <Text style={turnoStyles.primaryButtonText}>Volver</Text>
        </TouchableOpacity>
      </View>
    )
  }

  return (
    <View style={turnoStyles.card}>
      <View style={turnoStyles.confirmationContainer}>
        <Animated.View style={[turnoStyles.confirmationIcon, { transform: [{ scale: scaleAnim }] }]}>
          <Text style={{ fontSize: 48, color: "#10B981" }}>✓</Text>
        </Animated.View>

        <Text style={turnoStyles.confirmationTitle}>¡Turno Confirmado!</Text>

        <Text style={turnoStyles.confirmationMessage}>
          Su turno ha sido registrado exitosamente. Por favor, llegue 10 minutos antes de su cita.
        </Text>

        <View style={turnoStyles.turnoDetailsContainer}>
          <View style={turnoStyles.turnoDetailRow}>
            <Text style={turnoStyles.turnoDetailLabel}>Paciente</Text>
            <Text style={turnoStyles.turnoDetailValue}>
              {paciente.nombre} {paciente.apellido}
            </Text>
          </View>

          <View style={turnoStyles.turnoDetailRow}>
            <Text style={turnoStyles.turnoDetailLabel}>Odontólogo</Text>
            <Text style={turnoStyles.turnoDetailValue}>
              Dr/a. {odontologo.nombre} {odontologo.apellido}
            </Text>
          </View>

          <View style={turnoStyles.turnoDetailRow}>
            <Text style={turnoStyles.turnoDetailLabel}>Fecha</Text>
            <Text style={turnoStyles.turnoDetailValue}>{formatDate(fecha)}</Text>
          </View>

          <View style={turnoStyles.turnoDetailRow}>
            <Text style={turnoStyles.turnoDetailLabel}>Hora</Text>
            <Text style={turnoStyles.turnoDetailValue}>{hora}</Text>
          </View>

          {email && (
            <View style={[turnoStyles.turnoDetailRow, { borderBottomWidth: 0 }]}>
              <Text style={turnoStyles.turnoDetailLabel}>Email</Text>
              <Text style={turnoStyles.turnoDetailValue}>{email}</Text>
            </View>
          )}
        </View>

        {email && (
          <View style={turnoStyles.successContainer}>
            <Text style={turnoStyles.successText}>Se ha enviado una confirmación a su correo electrónico</Text>
          </View>
        )}

        <Animated.View style={{ width: "100%", transform: [{ scale: buttonScale }] }}>
          <TouchableOpacity
            style={turnoStyles.primaryButton}
            onPress={() => {
              createScaleAnimation(buttonScale, 0.95, 100).start()
              setTimeout(onVolver, 150)
            }}
            activeOpacity={0.8}
          >
            <Text style={turnoStyles.primaryButtonText}>Volver al Inicio</Text>
          </TouchableOpacity>
        </Animated.View>
      </View>
    </View>
  )
}

export default ConfirmacionTurno