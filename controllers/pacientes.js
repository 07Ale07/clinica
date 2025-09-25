// odontologo/controllers/pacientes.js
const express = require('express');
const router = express.Router();
const db = require('../config/db'); // Configura tu conexión a la DB

// Detalles del paciente
router.get('/paciente/:id/detalles', async (req, res) => {
  const { id } = req.params;
  try {
    const [paciente] = await db.query(`
      SELECT p.*, per.nombre, per.apellido, per.DNI
      FROM pacientes p
      JOIN personas per ON p.id_persona = per.id_persona
      WHERE p.id_paciente = ?
    `, [id]);
    if (!paciente) return res.status(404).json({ error: 'Paciente no encontrado' });
    res.json(paciente);
  } catch (error) {
    console.error('Error en /paciente/:id/detalles:', error);
    res.status(500).json({ error: 'Error en el servidor' });
  }
});

// Familiares (asumiendo tabla familiares)
router.get('/paciente/:id/familiares', async (req, res) => {
  const { id } = req.params;
  try {
    const familiares = await db.query(`
      SELECT * FROM familiares WHERE id_paciente = ?
    `, [id]);
    res.json(familiares);
  } catch (error) {
    console.error('Error en /paciente/:id/familiares:', error);
    res.status(500).json({ error: 'Error en el servidor' });
  }
});

// Citas anteriores (asumiendo tabla citas)
router.get('/paciente/:id/citas-anteriores', async (req, res) => {
  const { id } = req.params;
  try {
    const citas = await db.query(`
      SELECT id_cita, fecha, tipo, descripcion, estado
      FROM citas
      WHERE id_paciente = ? AND fecha < CURDATE()
    `, [id]);
    res.json(citas);
  } catch (error) {
    console.error('Error en /paciente/:id/citas-anteriores:', error);
    res.status(500).json({ error: 'Error en el servidor' });
  }
});

// Odontograma
router.get('/odontograma/:id', async (req, res) => {
  const { id } = req.params;
  try {
    const [odontograma] = await db.query(`
      SELECT * FROM odontograma WHERE id_paciente = ?
    `, [id]);
    if (!odontograma) return res.status(404).json({ error: 'Odontograma no encontrado' });
    res.json(odontograma);
  } catch (error) {
    console.error('Error en /odontograma/:id:', error);
    res.status(500).json({ error: 'Error en el servidor' });
  }
});

module.exports = router;
