// odontologo/controllers/odontograma.js
const express = require('express');
const mysql = require('mysql2/promise');
const router = express.Router();

// Configuración de la conexión a la base de datos
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'clinica',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

// Obtener odontograma
router.get('/odontograma/:id', async (req, res) => {
  const { id } = req.params;
  try {
    const [rows] = await pool.query(
      `
      SELECT id_odontograma, id_paciente, odontograma, fecha_actualizacion
      FROM odontogramas 
      WHERE id_paciente = ? 
      ORDER BY fecha_actualizacion DESC 
      LIMIT 1
    `,
      [id]
    );
    if (!rows.length) {
      // Return an empty odontogram instead of 404
      return res.json({ id_paciente: id, odontograma: {} });
    }
    const odontograma = JSON.parse(rows[0].odontograma);
    res.json({
      id_odontograma: rows[0].id_odontograma,
      id_paciente: rows[0].id_paciente,
      odontograma,
      fecha_actualizacion: rows[0].fecha_actualizacion,
    });
  } catch (error) {
    console.error('Error en /odontograma/:id:', error);
    res.status(500).json({ error: 'Error en el servidor', details: error.message });
  }
});

// Guardar odontograma
router.post('/odontograma/guardar', async (req, res) => {
  const { id_paciente, odontograma } = req.body;
  if (!id_paciente || !odontograma) {
    return res.status(400).json({ error: 'Faltan datos requeridos' });
  }
  const json = JSON.stringify(odontograma);
  try {
    const [result] = await pool.query(
      `
      INSERT INTO odontogramas (id_paciente, odontograma, fecha_actualizacion)
      VALUES (?, ?, NOW())
      ON DUPLICATE KEY UPDATE odontograma = VALUES(odontograma), fecha_actualizacion = NOW()
    `,
      [id_paciente, json]
    );
    res.json({ success: true });
  } catch (error) {
    console.error('Error en /odontograma/guardar:', error);
    res.status(500).json({ error: 'Error en el servidor', details: error.message });
  }
});

module.exports = router;
