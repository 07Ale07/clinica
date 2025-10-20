"use client"

import type React from "react"
import { useState, useRef } from "react"
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  Animated,
  ActivityIndicator,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  TouchableWithoutFeedback,
  Keyboard,
} from "react-native"
import { SafeAreaView } from "react-native-safe-area-context"
import { verificarPaciente } from "../controlador/SacarTurnoController"
import type { Paciente } from "../modelo/Paciente"
import { turnoStyles } from "../css/sacar-turno-styles"
import { createScaleAnimation } from "../css/animations"

interface Props {
  onPacienteVerificado: (paciente: Paciente | null, dni: string) => void
}

const VerificarPaciente: React.FC<Props> = ({ onPacienteVerificado }) => {
  const [dni, setDni] = useState("")
  const [error, setError] = useState("")
  const [loading, setLoading] = useState(false)
  const [isFocused, setIsFocused] = useState(false)

  const buttonScale = useRef(new Animated.Value(1)).current

  const handleSubmit = async () => {
    console.log("Botón Continuar presionado, DNI ingresado:", dni)

    if (!/^\d{8,10}$/.test(dni)) {
      console.log("Validación de DNI fallida:", dni)
      setError("El DNI debe contener entre 8 y 10 dígitos numéricos")
      return
    }

    createScaleAnimation(buttonScale, 0.95, 100).start()

    setLoading(true)
    setError("")

    try {
      console.log("Llamando a verificarPaciente con DNI:", dni)
      const paciente = await verificarPaciente(dni)
      console.log("Respuesta de verificarPaciente:", paciente)

      setTimeout(() => {
        setLoading(false)
        onPacienteVerificado(paciente, dni)
      }, 300)
    } catch (err: any) {
      console.error("Error en handleSubmit:", err.message || err)
      setLoading(false)
      setError(err.message || "Error al verificar paciente")
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
              <Text style={turnoStyles.cardTitle}>Verificación de Paciente</Text>
              <Text style={turnoStyles.cardDescription}>
                Ingrese su número de DNI para verificar si ya está registrado en nuestro sistema.
              </Text>

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Número de DNI</Text>
                <TextInput
                  style={[turnoStyles.input, isFocused && turnoStyles.inputFocused, error && turnoStyles.inputError]}
                  placeholder="Ej: 12345678"
                  value={dni}
                  onChangeText={(text) => {
                    setDni(text)
                    setError("")
                  }}
                  keyboardType="numeric"
                  maxLength={10}
                  onFocus={() => setIsFocused(true)}
                  onBlur={() => setIsFocused(false)}
                  editable={!loading}
                  returnKeyType="done"
                  onSubmitEditing={handleSubmit}
                />
              </View>

              {error && (
                <View style={turnoStyles.errorContainer}>
                  <Text style={turnoStyles.errorText}>{error}</Text>
                </View>
              )}

              <Animated.View style={{ transform: [{ scale: buttonScale }] }}>
                <TouchableOpacity
                  style={[turnoStyles.primaryButton, (loading || !dni) && turnoStyles.primaryButtonDisabled]}
                  onPress={handleSubmit}
                  disabled={loading || !dni}
                  activeOpacity={0.8}
                >
                  {loading ? (
                    <ActivityIndicator color="#FFFFFF" />
                  ) : (
                    <Text style={turnoStyles.primaryButtonText}>Continuar</Text>
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

export default VerificarPaciente