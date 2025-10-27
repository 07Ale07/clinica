const express = require("express")
const router = express.Router()
const mysql = require("mysql2/promise")

// Configuración de la conexión a la base de datos
const pool = mysql.createPool({
  host: "localhost",
  user: "root",
  password: "",
  database: "clinica",
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
})

// Probar conexión al iniciar
pool
  .getConnection()
  .then((conn) => {
    console.log("Conexión a la base de datos exitosa en recepcion_horarios.js")
    conn.release()
  })
  .catch((err) => {
    console.error("Error al conectar a la base de datos en recepcion_horarios.js:", err)
  })

// Ruta para obtener los horarios del recepcionista (mis horarios)
router.get("/horarios/recepcionista/:id_empleado", async (req, res) => {
  const { id_empleado } = req.params
  const { fecha } = req.query

  if (!id_empleado) {
    return res.status(400).json({
      success: false,
      message: "ID de empleado es requerido",
    })
  }

  try {
    console.log(`Consultando horarios para recepcionista ID: ${id_empleado}`)

    let query = `
      SELECT 
        he.id_horario,
        he.id_empleado,
        he.dia_semana,
        he.hora_inicio,
        he.hora_fin,
        he.fecha_desde,
        he.fecha_hasta,
        he.activo,
        p.nombre,
        p.apellido
      FROM horario_empleados he
      JOIN empleados e ON he.id_empleado = e.id_empleado
      JOIN personas p ON e.id_persona = p.id_persona
      WHERE he.id_empleado = ? 
      AND he.activo = 1
    `

    const params = [id_empleado]

    if (fecha) {
      query += ` 
        AND (
          (he.fecha_desde IS NULL OR he.fecha_desde <= ?) 
          AND (he.fecha_hasta IS NULL OR he.fecha_hasta >= ?)
        )
      `
      params.push(fecha, fecha)
    }

    query += " ORDER BY he.dia_semana, he.hora_inicio"

    const [horarios] = await pool.query(query, params)

    console.log(`Horarios encontrados: ${horarios.length}`)
    res.json({ success: true, data: horarios })
  } catch (error) {
    console.error("Error al consultar horarios del recepcionista:", error.message, error.stack)
    res.status(500).json({
      success: false,
      message: "Error en el servidor",
      error: error.message,
    })
  }
})

// Ruta para obtener todos los horarios de los odontólogos
router.get("/horarios/odontologos", async (req, res) => {
  const { fecha, dia_semana } = req.query

  try {
    console.log("Consultando horarios de todos los odontólogos")

    let query = `
      SELECT 
        he.id_horario,
        he.id_empleado,
        he.dia_semana,
        he.hora_inicio,
        he.hora_fin,
        he.fecha_desde,
        he.fecha_hasta,
        he.activo,
        p.nombre,
        p.apellido,
        e.id_empleado
      FROM horario_empleados he
      JOIN empleados e ON he.id_empleado = e.id_empleado
      JOIN personas p ON e.id_persona = p.id_persona
      JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado
      WHERE ce.id_cargo = 1
      AND he.activo = 1
    `

    const params = []

    if (fecha) {
      query += ` 
        AND (
          (he.fecha_desde IS NULL OR he.fecha_desde <= ?) 
          AND (he.fecha_hasta IS NULL OR he.fecha_hasta >= ?)
        )
      `
      params.push(fecha, fecha)
    }

    if (dia_semana) {
      query += " AND he.dia_semana = ?"
      params.push(dia_semana)
    }

    query += " ORDER BY p.apellido, p.nombre, he.dia_semana, he.hora_inicio"

    const [horarios] = await pool.query(query, params)

    console.log(`Horarios de odontólogos encontrados: ${horarios.length}`)
    res.json({ success: true, data: horarios })
  } catch (error) {
    console.error("Error al consultar horarios de odontólogos:", error.message, error.stack)
    res.status(500).json({
      success: false,
      message: "Error en el servidor",
      error: error.message,
    })
  }
})

// Ruta para obtener citas del día para el recepcionista
router.get("/citas/recepcionista/:id_empleado", async (req, res) => {
  const { id_empleado } = req.params
  const { fecha } = req.query

  if (!id_empleado) {
    return res.status(400).json({
      success: false,
      message: "ID de empleado es requerido",
    })
  }

  const fechaConsulta = fecha || new Date().toISOString().split("T")[0]

  try {
    console.log(`Consultando citas para recepcionista ID: ${id_empleado}, fecha: ${fechaConsulta}`)

    const query = `
      SELECT 
        c.id_cita,
        c.id_paciente,
        c.fecha_inicio,
        c.fecha_fin,
        c.tipo,
        c.estado,
        c.observaciones,
        pac_persona.nombre AS nombre_paciente,
        pac_persona.apellido AS apellido_paciente,
        odon_persona.nombre AS nombre_odontologo,
        odon_persona.apellido AS apellido_odontologo
      FROM citas c
      JOIN pacientes pac ON c.id_paciente = pac.id_paciente
      JOIN personas pac_persona ON pac.id_persona = pac_persona.id_persona
      JOIN empleados odon ON c.id_empleado = odon.id_empleado
      JOIN personas odon_persona ON odon.id_persona = odon_persona.id_persona
      WHERE DATE(c.fecha_inicio) = ?
      ORDER BY c.fecha_inicio
    `

    const [citas] = await pool.query(query, [fechaConsulta])

    console.log(`Citas encontradas: ${citas.length}`)
    res.json({ success: true, data: citas })
  } catch (error) {
    console.error("Error al consultar citas:", error.message, error.stack)
    res.status(500).json({
      success: false,
      message: "Error en el servidor",
      error: error.message,
    })
  }
})

module.exports = router
