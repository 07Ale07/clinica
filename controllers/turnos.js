// File: controllers/turnos.js

const express = require('express');
const router = express.Router();
const mysql = require('mysql2/promise');

// Configuración de la conexión a la base de datos
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root', // Ajusta según tu configuración
  password: '', // Ajusta según tu configuración
  database: 'clinica',
});

// Ruta para obtener horarios de un empleado
router.get('/horarios/odontologo/:id_empleado', async (req, res) => {
  const { id_empleado } = req.params;
  const { dia, fecha } = req.query;

  try {
    let query = `
      SELECT * FROM horario_empleados 
      WHERE id_empleado = ? 
      AND activo = 1
    `;
    let params = [id_empleado];

    if (dia) {
      query += ' AND dia_semana = ?';
      params.push(dia);
    }

    if (fecha) {
      query += ` 
        AND (
          (fecha_desde IS NULL OR fecha_desde <= ?) 
          AND (fecha_hasta IS NULL OR fecha_hasta >= ?)
        )
      `;
      params.push(fecha, fecha);
    }

    const [rows] = await pool.query(query, params);
    res.json(rows);
  } catch (error) {
    console.error('Error fetching horarios:', error);
    res.status(500).json({ error: 'No se pudieron cargar los horarios.' });
  }
});

// Ruta para obtener citas de un odontólogo
router.get('/citas/odontologo/:id_usuario', async (req, res) => {
  const { id_usuario } = req.params;
  const { fecha } = req.query;

  try {
    // Consulta corregida: unión con pacientes y personas para obtener el nombre del paciente desde la tabla personas
    const query = `
      SELECT c.id_cita, c.id_paciente, c.fecha_inicio, pe.nombre AS nombre_paciente, c.tipo, c.estado
      FROM citas c
      JOIN pacientes p ON c.id_paciente = p.id_paciente
      JOIN personas pe ON p.id_persona = pe.id_persona
      WHERE c.id_empleado = ? AND DATE(c.fecha_inicio) = ?
    `;
    const [rows] = await pool.query(query, [id_usuario, fecha]);
    res.json(rows);
  } catch (error) {
    console.error('Error fetching citas:', error);
    res.status(500).json({ error: 'No se pudieron cargar las citas.' });
  }
});

module.exports = router;
