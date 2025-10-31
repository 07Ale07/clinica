"use client"

import type React from "react"
import { useState } from "react"
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Platform, KeyboardAvoidingView } from "react-native"
import { LoginController } from "../controlador/LoginController"
import { useNavigation } from "@react-navigation/native"
import type { StackNavigationProp } from "@react-navigation/stack"
import type { RootStackParamList } from "../../navigation/types"
import * as Animatable from "react-native-animatable"
import { LinearGradient } from "expo-linear-gradient"
import { Feather } from "@expo/vector-icons"
import { styles } from "../css/loginStyle"

type LoginScreenNavigationProp = StackNavigationProp<RootStackParamList, "Login">

const LoginView: React.FC = () => {
  const [usuario, setUsuario] = useState<string>("")
  const [contrasena, setContrasena] = useState<string>("")
  const [isLoading, setIsLoading] = useState<boolean>(false)
  const [showPassword, setShowPassword] = useState<boolean>(false)

  const navigation = useNavigation<LoginScreenNavigationProp>()

  const handleLogin = async () => {
    setIsLoading(true)

    await LoginController.handleLogin(
      { usuario, contrasena },
      (rol) => {
        setIsLoading(false)
        if (rol === "odontólogo") {
          navigation.navigate("Odontologo")
        } else if (rol === "recepcionista") {
          navigation.navigate("Recepcionista")
        } else {
          navigation.navigate("Home")
        }
      },
      (errorMessage) => {
        setIsLoading(false)
      },
    )
  }

  return (
    <LinearGradient colors={["#4B9CDB", "#E6F0FA"]} style={styles.container}>
      <KeyboardAvoidingView
        behavior={Platform.OS === "ios" ? "padding" : "height"}
        style={styles.keyboardAvoidingContainer}
        keyboardVerticalOffset={Platform.OS === "ios" ? 0 : 20}
      >
        <Animatable.View animation="fadeInDown" duration={1000} style={styles.headerContainer}>
          <Text style={styles.title}>DENTAL SMILE</Text>
          <Text style={styles.subtitle}>Tus Prioridades, a Mano</Text>
        </Animatable.View>

        <Animatable.View animation="fadeInUp" duration={1200} style={styles.formContainer}>
          <View style={styles.inputContainer}>
            <Feather name="user" size={24} color="#4B9CDB" style={styles.icon} />
            <TextInput
              style={styles.input}
              placeholder="Usuario"
              placeholderTextColor="#8A8F9E"
              value={usuario}
              onChangeText={setUsuario}
              editable={!isLoading}
            />
          </View>

          <View style={styles.inputContainer}>
            <Feather name="lock" size={24} color="#4B9CDB" style={styles.icon} />
            <TextInput
              style={styles.input}
              placeholder="Contraseña"
              placeholderTextColor="#8A8F9E"
              value={contrasena}
              onChangeText={setContrasena}
              secureTextEntry={!showPassword}
              editable={!isLoading}
            />
            <TouchableOpacity onPress={() => setShowPassword(!showPassword)} style={styles.eyeIcon}>
              <Feather name={showPassword ? "eye-off" : "eye"} size={20} color="#4B9CDB" />
            </TouchableOpacity>
          </View>

          <Animatable.View animation="pulse" iterationCount="infinite" duration={2000} style={styles.buttonContainer}>
            <TouchableOpacity onPress={handleLogin} disabled={isLoading} style={styles.button}>
              <LinearGradient colors={["#4B9CDB", "#2A6EBB"]} style={styles.buttonGradient}>
                <Text style={styles.buttonText}>{isLoading ? "Cargando..." : "Iniciar Sesión"}</Text>
              </LinearGradient>
            </TouchableOpacity>
          </Animatable.View>
        </Animatable.View>

        <Animatable.View animation="fadeInUp" duration={1200} style={styles.actionButtonsContainer}>
          <TouchableOpacity onPress={() => navigation.navigate("TurnoConsulta")} style={styles.actionButton}>
            <LinearGradient colors={["#4B9CDB", "#2A6EBB"]} style={styles.actionButtonGradient}>
              <Text style={styles.actionButtonText}>Consultar Turno</Text>
            </LinearGradient>
          </TouchableOpacity>
          <TouchableOpacity onPress={() => navigation.navigate("SacarTurno")} style={styles.actionButton}>
            <LinearGradient colors={["#4B9CDB", "#2A6EBB"]} style={styles.actionButtonGradient}>
              <Text style={styles.actionButtonText}>Sacar Turno</Text>
            </LinearGradient>
          </TouchableOpacity>
        </Animatable.View>
      </KeyboardAvoidingView>
    </LinearGradient>
  )
}


export default LoginView
