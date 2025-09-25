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

// Ruta para consultar turnos por DNI
router.get('/citas', async (req, res) => {
  const { dni } = req.query;

  if (!dni) {
    return res.status(400).json({ success: false, message: 'DNI es requerido' });
  }

  try {
    console.log(`Consultando turnos para DNI: ${dni}`); // Log para depuración
    // Consulta para obtener información del paciente y sus citas
    const [turnos] = await pool.query(`
      SELECT pe.nombre, pe.apellido, c.id_paciente, c.tipo AS motivo, c.fecha_inicio AS fecha, c.estado
      FROM pacientes p
      JOIN personas pe ON p.id_persona = pe.id_persona
      JOIN citas c ON p.id_paciente = c.id_paciente
      WHERE pe.DNI = ?
    `, [dni]);

    console.log(`Resultados encontrados: ${turnos.length}`); // Log para verificar resultados
    console.log('Datos de turnos:', turnos); // Log adicional para inspeccionar los datos
    res.json(turnos);
  } catch (error) {
    console.error('Error al consultar turnos:', error.message, error.stack); // Log detallado
    res.status(500).json({ success: false, message: 'Error en el servidor', error: error.message });
  }
});

module.exports = router;
