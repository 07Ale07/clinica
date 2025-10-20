"use client"

import type React from "react"
import { useEffect, useRef } from "react"
import { View, Text, TouchableOpacity, Animated } from "react-native"
import type { Turno } from "../modelo/Paciente"
import { turnoStyles } from "../css/sacar-turno-styles"
import { createScaleAnimation } from "../css/animations"

interface Props {
  turno: Turno
  onVolver: () => void
}

const ConfirmacionTurno: React.FC<Props> = ({ turno, onVolver }) => {
  const scaleAnim = useRef(new Animated.Value(0)).current
  const buttonScale = useRef(new Animated.Value(1)).current

  useEffect(() => {
    createScaleAnimation(scaleAnim, 1, 500).start()
  }, [])

  const formatDate = (dateString: string): string => {
    const [year, month, day] = dateString.split("-")
    return `${day}/${month}/${year}`
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
            <Text style={turnoStyles.turnoDetailLabel}>Fecha</Text>
            <Text style={turnoStyles.turnoDetailValue}>{formatDate(turno.fecha)}</Text>
          </View>

          <View style={turnoStyles.turnoDetailRow}>
            <Text style={turnoStyles.turnoDetailLabel}>Hora</Text>
            <Text style={turnoStyles.turnoDetailValue}>{turno.hora}</Text>
          </View>

          {turno.email && (
            <View style={[turnoStyles.turnoDetailRow, { borderBottomWidth: 0 }]}>
              <Text style={turnoStyles.turnoDetailLabel}>Email</Text>
              <Text style={turnoStyles.turnoDetailValue}>{turno.email}</Text>
            </View>
          )}
        </View>

        {turno.email && (
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
