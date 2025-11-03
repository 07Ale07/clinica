// ../controlador/SacarTurnoController.ts

import { API_BASE_URL } from "../../services/api"
import type { Paciente, Odontologo, Turno } from "../modelo/Paciente"
import { obtenerIdEmpleado, obtenerRol } from "../../services/sesion"

export async function verificarPaciente(dni: string): Promise<Paciente | null> {
  const response = await fetch(`${API_BASE_URL}/api/sacar_turno/verificar_paciente`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ dni }),
  })
  if (!response.ok) throw new Error((await response.json()).message || "Error al verificar")
  const data = await response.json()
  return data.paciente || null
}

export async function registrarPaciente(paciente: Paciente): Promise<Paciente> {
  const response = await fetch(`${API_BASE_URL}/api/sacar_turno/registrar_paciente`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(paciente),
  })
  if (!response.ok) throw new Error("Error al registrar paciente")
  return response.json()
}

export async function obtenerOdontologos(): Promise<Odontologo[]> {
  const response = await fetch(`${API_BASE_URL}/api/sacar_turno/obtener_odontologos`)
  if (!response.ok) throw new Error("Error al obtener odontólogos")
  return response.json()
}

export async function obtenerHorariosDisponibles(id_empleado: number, fecha: string): Promise<string[]> {
  const response = await fetch(`${API_BASE_URL}/api/sacar_turno/horarios_disponibles`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id_odontologo: id_empleado, fecha }),
  })
  if (!response.ok) throw new Error("Error al obtener horarios")
  return response.json()
}

// === CONFIRMAR TURNO CON SESIÓN ===
export async function confirmarTurnoConSesion(id_persona: number, turno: Turno): Promise<Turno> {
  const rol = await obtenerRol()
  const id_empleado = rol === "recepcionista" ? await obtenerIdEmpleado() : undefined

  const body: any = {
    id_persona,
    ...turno,
  }

  if (id_empleado) {
    body.id_empleado = id_empleado
  }

  console.log("Enviando turno con body:", body)

  const response = await fetch(`${API_BASE_URL}/api/sacar_turno/confirmar_turno`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(body),
  })

  if (!response.ok) {
    const error = await response.json()
    throw new Error(error.message || "Error al confirmar turno")
  }

  return response.json()
}
