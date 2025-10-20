"use client"

import type React from "react"
import { useState, useEffect, useRef } from "react"
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
import { Picker } from "@react-native-picker/picker"
import DateTimePicker from "@react-native-community/datetimepicker"
import { obtenerOdontologos, obtenerHorariosDisponibles, confirmarTurno } from "../controlador/SacarTurnoController"
import type { Odontologo, Turno, Paciente } from "../modelo/Paciente"
import { turnoStyles } from "../css/sacar-turno-styles"
import { createScaleAnimation } from "../css/animations"

interface Props {
  paciente: Paciente
  onTurnoConfirmado: (turno: Turno) => void
  onVolver: () => void
}

const SeleccionOdontologo: React.FC<Props> = ({ paciente, onTurnoConfirmado, onVolver }) => {
  const [odontologos, setOdontologos] = useState<Odontologo[]>([])
  const [idOdontologo, setIdOdontologo] = useState<number | null>(null)
  const [fecha, setFecha] = useState<Date | null>(null)
  const [showDatePicker, setShowDatePicker] = useState(false)
  const [hora, setHora] = useState("")
  const [horarios, setHorarios] = useState<string[]>([])
  const [email, setEmail] = useState("")
  const [error, setError] = useState("")
  const [loading, setLoading] = useState(false)
  const [loadingHorarios, setLoadingHorarios] = useState(false)
  const [focusedField, setFocusedField] = useState<string | null>(null)

  const buttonScale = useRef(new Animated.Value(1)).current

  useEffect(() => {
    async function fetchOdontologos() {
      try {
        const lista = await obtenerOdontologos()
        setOdontologos(lista)
      } catch (err) {
        setError("Error al cargar odontólogos")
      }
    }
    fetchOdontologos()
  }, [])

  useEffect(() => {
    if (idOdontologo !== null && fecha) {
      async function fetchHorarios() {
        setLoadingHorarios(true)
        try {
          const lista = await obtenerHorariosDisponibles(idOdontologo, formatToISO(fecha))
          setHorarios(lista)
          setHora("")
        } catch (err) {
          setError("Error al cargar horarios")
        } finally {
          setLoadingHorarios(false)
        }
      }
      fetchHorarios()
    }
  }, [idOdontologo, fecha])

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
    const currentDate = selectedDate || fecha
    setShowDatePicker(Platform.OS === "ios")
    if (selectedDate) {
      setFecha(currentDate)
      setError("")
    }
  }

  const validateForm = (): boolean => {
    if (!idOdontologo) {
      setError("Seleccione un odontólogo")
      return false
    }
    if (!fecha) {
      setError("Seleccione una fecha")
      return false
    }
    const fechaObj = new Date(fecha)
    if (fechaObj.getDay() === 0 || fechaObj.getDay() === 6) {
      setError("No se pueden agendar turnos los fines de semana")
      return false
    }
    if (new Date(fecha) < new Date()) {
      setError("La fecha no puede ser pasada")
      return false
    }
    if (!hora) {
      setError("Seleccione una hora")
      return false
    }
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      setError("Correo electrónico inválido")
      return false
    }
    return true
  }

  const handleSubmit = async () => {
    if (!validateForm()) return

    createScaleAnimation(buttonScale, 0.95, 100).start()
    setLoading(true)
    setError("")

    try {
      if (idOdontologo === null) {
        throw new Error("Odontólogo no seleccionado")
      }
      const turno: Turno = {
        id_odontologo: idOdontologo,
        fecha: formatToISO(fecha),
        hora,
        email,
      }
      const confirmado = await confirmarTurno(paciente.id_persona!, turno)

      setTimeout(() => {
        setLoading(false)
        onTurnoConfirmado(confirmado)
      }, 300)
    } catch (err: any) {
      setLoading(false)
      setError(err.message || "Error al confirmar turno")
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

              <Text style={turnoStyles.cardTitle}>Selección de Turno</Text>
              <Text style={turnoStyles.cardDescription}>
                Bienvenido/a {paciente.nombre}. Seleccione el profesional, fecha y horario de su preferencia.
              </Text>

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Odontólogo</Text>
                <View style={turnoStyles.pickerContainer}>
                  <Picker
                    selectedValue={idOdontologo}
                    onValueChange={(value) => {
                      setIdOdontologo(value as number | null)
                      setError("")
                    }}
                    style={turnoStyles.picker}
                    enabled={!loading}
                  >
                    <Picker.Item label="Seleccione un odontólogo..." value={null} />
                    {odontologos.map((odo) => (
                      <Picker.Item
                        key={odo.id_persona}
                        label={`Dr/a. ${odo.nombre} ${odo.apellido}`}
                        value={odo.id_persona}
                      />
                    ))}
                  </Picker>
                </View>
              </View>

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Fecha</Text>
                <TouchableOpacity
                  style={[turnoStyles.input, focusedField === "fecha" && turnoStyles.inputFocused]}
                  onPress={() => {
                    Keyboard.dismiss()
                    setShowDatePicker(true)
                    setFocusedField("fecha")
                  }}
                  disabled={loading}
                >
                  <Text style={{ color: fecha ? "#1E293B" : "#94A3B8" }}>
                    {fecha ? formatDate(fecha) : "Seleccione fecha (DD/MM/YYYY)"}
                  </Text>
                </TouchableOpacity>
              </View>

              {showDatePicker && (
                <DateTimePicker
                  value={fecha || new Date()}
                  mode="date"
                  display="default"
                  onChange={handleDateChange}
                  minimumDate={new Date()}
                />
              )}

              {idOdontologo && fecha && (
                <View style={turnoStyles.inputContainer}>
                  <Text style={turnoStyles.inputLabel}>Horarios Disponibles</Text>
                  {loadingHorarios ? (
                    <View style={{ padding: 20, alignItems: "center" }}>
                      <ActivityIndicator size="small" color="#0EA5E9" />
                      <Text style={turnoStyles.loadingText}>Cargando horarios...</Text>
                    </View>
                  ) : horarios.length > 0 ? (
                    <View style={turnoStyles.horariosGrid}>
                      {horarios.map((h) => (
                        <TouchableOpacity
                          key={h}
                          style={[turnoStyles.horarioChip, hora === h && turnoStyles.horarioChipSelected]}
                          onPress={() => {
                            setHora(h)
                            setError("")
                          }}
                          disabled={loading}
                        >
                          <Text style={[turnoStyles.horarioChipText, hora === h && turnoStyles.horarioChipTextSelected]}>
                            {h}
                          </Text>
                        </TouchableOpacity>
                      ))}
                    </View>
                  ) : (
                    <View style={turnoStyles.infoCard}>
                      <Text style={turnoStyles.infoLabel}>Sin horarios disponibles</Text>
                      <Text style={turnoStyles.infoValue}>
                        No hay turnos disponibles para esta fecha. Por favor, seleccione otra.
                      </Text>
                    </View>
                  )}
                </View>
              )}

              <View style={turnoStyles.inputContainer}>
                <Text style={turnoStyles.inputLabel}>Email (opcional)</Text>
                <TextInput
                  style={[turnoStyles.input, focusedField === "email" && turnoStyles.inputFocused]}
                  placeholder="correo@ejemplo.com"
                  value={email}
                  onChangeText={(text) => {
                    setEmail(text)
                    setError("")
                  }}
                  keyboardType="email-address"
                  autoCapitalize="none"
                  onFocus={() => setFocusedField("email")}
                  onBlur={() => setFocusedField(null)}
                  editable={!loading}
                  returnKeyType="done"
                  onSubmitEditing={Keyboard.dismiss}
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
                    (loading || !idOdontologo || !fecha || !hora) && turnoStyles.primaryButtonDisabled,
                  ]}
                  onPress={handleSubmit}
                  disabled={loading || !idOdontologo || !fecha || !hora}
                  activeOpacity={0.8}
                >
                  {loading ? (
                    <ActivityIndicator color="#FFFFFF" />
                  ) : (
                    <Text style={turnoStyles.primaryButtonText}>Confirmar Turno</Text>
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

export default SeleccionOdontologo