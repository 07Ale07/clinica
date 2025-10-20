"use client"

import type React from "react"
import { useState, useRef } from "react"
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  Platform,
  Animated,
  ActivityIndicator,
  KeyboardAvoidingView,
  ScrollView,
  TouchableWithoutFeedback,
  Keyboard,
} from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"
import DateTimePicker from "@react-native-community/datetimepicker"
import { registrarPaciente } from "../controlador/SacarTurnoController"
import type { Paciente } from "../modelo/Paciente"
import { turnoStyles } from "../css/sacar-turno-styles"
import { createScaleAnimation } from "../css/animations"

interface Props {
  dniInicial: string
  onRegistroCompletado: (paciente: Paciente) => void
  onVolver: () => void
}

const RegistroPaciente: React.FC<Props> = ({ dniInicial, onRegistroCompletado, onVolver }) => {
  const [nombre, setNombre] = useState("")
  const [apellido, setApellido] = useState("")
  const [fechaNac, setFechaNac] = useState<Date | null>(null)
  const [showDatePicker, setShowDatePicker] = useState(false)
  const [error, setError] = useState("")
  const [loading, setLoading] = useState(false)
  const [focusedField, setFocusedField] = useState<string | null>(null)

  const buttonScale = useRef(new Animated.Value(1)).current

  const formatDate = (date: Date | null): string => {
    if (!date) return ""
    const day = String(date.getDate()).padStart(2, "0")
    const month = String(date.getMonth() + 1).padStart(2, "0")
    const year = date.getFullYear()
    return `${day}/${month}/${year}`
  }

  const formatToISO = (date: Date | null): string => {
    if (!date) return ""
    const year = date.getFullYear()
    const month = String(date.getMonth() + 1).padStart(2, "0")
    const day = String(date.getDate()).padStart(2, "0")
    return `${year}-${month}-${day}`
  }

  const handleDateChange = (event: any, selectedDate?: Date) => {
    const currentDate = selectedDate || fechaNac
    setShowDatePicker(Platform.OS === "ios")
    if (selectedDate) {
      setFechaNac(currentDate)
      setError("")
    }
  }

  const handleSubmit = async () => {
    if (!nombre || !apellido || !fechaNac) {
      setError("Todos los campos son requeridos")
      return
    }

    const hoy = new Date()
    if (fechaNac > hoy) {
      setError("La fecha de nacimiento no puede ser futura")
      return
    }
    if (hoy.getFullYear() - fechaNac.getFullYear() > 120) {
      setError("La fecha de nacimiento no parece válida")
      return
    }

    createScaleAnimation(buttonScale, 0.95, 100).start()
    setLoading(true)
    setError("")

    try {
      const paciente: Paciente = {
        nombre,
        apellido,
        fecha_nac: formatToISO(fechaNac),
        dni: dniInicial,
      }
      const registrado = await registrarPaciente(paciente)

      setTimeout(() => {
        setLoading(false)
        onRegistroCompletado(registrado)
      }, 300)
    } catch (err: any) {
      setLoading(false)
      setError(err.message || "Error al registrar")
    }
  }

  return (
    <SafeAreaView style={{ flex: 1 }} edges={['left', 'right', 'bottom']}>
      <KeyboardAvoidingView
        behavior={Platform.OS === "ios" ? "padding" : "height"}
        style={{ flex: 1 }}
        keyboardVerticalOffset={Platform.OS === "ios" ? 80 : 20}
      >
        <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
          <ScrollView
            contentContainerStyle={{
              flexGrow: 1,
              paddingHorizontal: 16,
              paddingBottom: 100,
              justifyContent: 'center',
            }}
            showsVerticalScrollIndicator={false}
            keyboardShouldPersistTaps="handled"
            bounces={false}
          >
            <View style={turnoStyles.card}>
              <TouchableOpacity style={turnoStyles.backButton} onPress={onVolver} activeOpacity={0.7}>
                <Text style={turnoStyles.backButtonText}>← Volver</Text>
              </TouchableOpacity>

              <Text style={turnoStyles.cardTitle}>Registro de Nuevo Paciente</Text>
              <Text style={turnoStyles.cardDescription}>
                Complete sus datos para registrarse en nuestro sistema y continuar con la solicitud de turno.
              </Text>

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Nombre</Text>
                <TextInput
                  style={[turnoStyles.input, focusedField === "nombre" && turnoStyles.inputFocused]}
                  placeholder="Ingrese su nombre"
                  value={nombre}
                  onChangeText={(text) => {
                    setNombre(text)
                    setError("")
                  }}
                  onFocus={() => setFocusedField("nombre")}
                  onBlur={() => setFocusedField(null)}
                  editable={!loading}
                  returnKeyType="next"
                />
              </View>

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Apellido</Text>
                <TextInput
                  style={[turnoStyles.input, focusedField === "apellido" && turnoStyles.inputFocused]}
                  placeholder="Ingrese su apellido"
                  value={apellido}
                  onChangeText={(text) => {
                    setApellido(text)
                    setError("")
                  }}
                  onFocus={() => setFocusedField("apellido")}
                  onBlur={() => setFocusedField(null)}
                  editable={!loading}
                  returnKeyType="done"
                />
              </View>

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Fecha de Nacimiento</Text>
                <TouchableOpacity
                  style={[turnoStyles.input, focusedField === "fecha" && turnoStyles.inputFocused]}
                  onPress={() => {
                    Keyboard.dismiss()
                    setShowDatePicker(true)
                    setFocusedField("fecha")
                  }}
                  disabled={loading}
                >
                  <Text style={{ color: fechaNac ? "#1E293B" : "#94A3B8" }}>
                    {fechaNac ? formatDate(fechaNac) : "Seleccione fecha (DD/MM/YYYY)"}
                  </Text>
                </TouchableOpacity>
              </View>

              {showDatePicker && (
                <DateTimePicker
                  value={fechaNac || new Date()}
                  mode="date"
                  display="default"
                  onChange={handleDateChange}
                  maximumDate={new Date()}
                />
              )}

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>DNI</Text>
                <TextInput
                  style={[turnoStyles.input, { backgroundColor: "#F1F5F9" }]}
                  value={dniInicial}
                  editable={false}
                />
              </View>

              {error && (
                <View style={turnoStyles.errorContainer}>
                  <Text style={turnoStyles.errorText}>{error}</Text>
                </View>
              )}

              <Animated.View style={{ transform: [{ scale: buttonScale }] }}>
                <TouchableOpacity
                  style={[
                    turnoStyles.primaryButton,
                    (loading || !nombre || !apellido || !fechaNac) && turnoStyles.primaryButtonDisabled,
                  ]}
                  onPress={handleSubmit}
                  disabled={loading || !nombre || !apellido || !fechaNac}
                  activeOpacity={0.8}
                >
                  {loading ? (
                    <ActivityIndicator color="#FFFFFF" />
                  ) : (
                    <Text style={turnoStyles.primaryButtonText}>Registrarse y Continuar</Text>
                  )}
                </TouchableOpacity>
              </Animated.View>
            </View>
          </ScrollView>
        </TouchableWithoutFeedback>
      </KeyboardAvoidingView>
    </SafeAreaView>
  )
}

export default RegistroPaciente