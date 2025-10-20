"use client"

import type React from "react"
import { useState, useEffect, useRef } from "react"
import { View, Animated } from "react-native"
import VerificarPaciente from "./VerificarPaciente"
import RegistroPaciente from "./RegistroPaciente"
import SeleccionOdontologo from "./SeleccionOdontologo"
import ConfirmacionTurno from "./ConfirmacionTurno"
import ProgressHeader from "./components/ProgressHeader"
import type { Paciente, Turno } from "../modelo/Paciente"
import { turnoStyles } from "../css/sacar-turno-styles"
import { createFadeInAnimation, createSlideInAnimation } from "../css/animations"

const SacarTurnoMain: React.FC = () => {
  const [step, setStep] = useState<"verificar" | "registro" | "seleccion" | "confirmacion">("verificar")
  const [paciente, setPaciente] = useState<Paciente | null>(null)
  const [dniInicial, setDniInicial] = useState("")
  const [turnoConfirmado, setTurnoConfirmado] = useState<Turno | null>(null)

  const fadeAnim = useRef(new Animated.Value(0)).current
  const slideAnim = useRef(new Animated.Value(50)).current

  const stepConfig = {
    verificar: { number: 1, title: "Verificación de Paciente" },
    registro: { number: 2, title: "Registro de Datos" },
    seleccion: { number: 2, title: "Selección de Turno" },
    confirmacion: { number: 3, title: "Confirmación" },
  }

  const currentStepNumber = stepConfig[step].number
  const currentStepTitle = stepConfig[step].title
  const totalSteps = 3

  useEffect(() => {
    fadeAnim.setValue(0)
    slideAnim.setValue(50)

    Animated.parallel([createFadeInAnimation(fadeAnim, 400), createSlideInAnimation(slideAnim, 400)]).start()
  }, [step])

  const handlePacienteVerificado = (pac: Paciente | null, dni: string) => {
    setPaciente(pac)
    setDniInicial(dni)
    setStep(pac ? "seleccion" : "registro")
  }

  const handleRegistroCompletado = (pac: Paciente) => {
    setPaciente(pac)
    setStep("seleccion")
  }

  const handleTurnoConfirmado = (turno: Turno) => {
    setTurnoConfirmado(turno)
    setStep("confirmacion")
  }

  const handleVolver = () => {
    setStep("verificar")
    setPaciente(null)
    setTurnoConfirmado(null)
  }

  const handleVolverPaso = () => {
    if (step === "registro") {
      setStep("verificar")
    } else if (step === "seleccion") {
      setStep("verificar")
      setPaciente(null)
    }
  }

  return (
    <View style={turnoStyles.screenContainer}>
      <ProgressHeader currentStep={currentStepNumber} totalSteps={totalSteps} stepTitle={currentStepTitle} />

      <Animated.View
        style={[
          turnoStyles.contentContainer,
          {
            opacity: fadeAnim,
            transform: [{ translateY: slideAnim }],
          },
        ]}
      >
        {step === "verificar" && <VerificarPaciente onPacienteVerificado={handlePacienteVerificado} />}
        {step === "registro" && (
          <RegistroPaciente
            dniInicial={dniInicial}
            onRegistroCompletado={handleRegistroCompletado}
            onVolver={handleVolverPaso}
          />
        )}
        {step === "seleccion" && paciente && (
          <SeleccionOdontologo
            paciente={paciente}
            onTurnoConfirmado={handleTurnoConfirmado}
            onVolver={handleVolverPaso}
          />
        )}
        {step === "confirmacion" && turnoConfirmado && (
          <ConfirmacionTurno turno={turnoConfirmado} onVolver={handleVolver} />
        )}
      </Animated.View>
    </View>
  )
}

export default SacarTurnoMain
