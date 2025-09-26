// odontologo/controllers/pacientes.js
const express = require('express');
const mysql = require('mysql2/promise');
const router = express.Router();

// Configuración de la conexión a la base de datos (igual que en historial.js, citas.js y turnos.js)
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'clinica',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// Detalles del paciente
router.get('/paciente/:id/detalles', async (req, res) => {
  const { id } = req.params;
  try {
    const [paciente] = await pool.query(`
      SELECT p.*, per.nombre, per.apellido, per.DNI
      FROM pacientes p
      JOIN personas per ON p.id_persona = per.id_persona
      WHERE p.id_paciente = ?
    `, [id]);
    if (!paciente.length) return res.status(404).json({ error: 'Paciente no encontrado' });
    res.json(paciente[0]);
  } catch (error) {
    console.error('Error en /paciente/:id/detalles:', error);
    res.status(500).json({ error: 'Error en el servidor', details: error.message });
  }
});

// Familiares
router.get('/paciente/:id/familiares', async (req, res) => {
  const { id } = req.params;
  try {
    const [familiares] = await pool.query(`
      SELECT * FROM familiares WHERE id_paciente = ?
    `, [id]);
    res.json(familiares);
  } catch (error) {
    console.error('Error en /paciente/:id/familiares:', error);
    res.status(500).json({ error: 'Error en el servidor', details: error.message });
  }
});

// Citas anteriores (corregido para usar observaciones en lugar de descripcion)
router.get('/paciente/:id/citas-anteriores', async (req, res) => {
  const { id } = req.params;
  try {
    const [citas] = await pool.query(`
      SELECT id_cita, fecha_inicio AS fecha, tipo, observaciones AS descripcion, estado
      FROM citas
      WHERE id_paciente = ? AND DATE(fecha_inicio) < CURDATE()
    `, [id]);
    res.json(citas);
  } catch (error) {
    console.error('Error en /paciente/:id/citas-anteriores:', error);
    res.status(500).json({ error: 'Error en el servidor', details: error.message });
  }
});

// Odontograma
router.get('/odontograma/:id', async (req, res) => {
  const { id } = req.params;
  try {
    const [odontograma] = await pool.query(`
      SELECT * FROM odontogramas WHERE id_paciente = ?
    `, [id]);
    if (!odontograma.length) return res.status(404).json({ error: 'Odontograma no encontrado' });
    res.json(odontograma[0]);
  } catch (error) {
    console.error('Error en /odontograma/:id:', error);
    res.status(500).json({ error: 'Error en el servidor', details: error.message });
  }
});

module.exports = router;
