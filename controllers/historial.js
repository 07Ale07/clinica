const mysql = require('mysql2/promise');

// Configuración de la conexión a la base de datos (ajusta según tu entorno)
const pool = mysql.createPool({
  host: 'localhost', // O tu host de DB
  user: 'root', // Usuario de DB
  password: '', // Contraseña de DB
  database: 'clinica', // Nombre de la DB basado en clinica.txt
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// Endpoint para obtener historial de pacientes atendidos por odontólogo
exports.getHistorial = async (req, res) => {
  const id_empleado = req.params.id_empleado;
  try {
    const [rows] = await pool.query(`
      SELECT 
        p.id_paciente AS id,
        CONCAT(pe.nombre, ' ', pe.apellido) AS name,
        DATE_FORMAT(MAX(c.fecha_inicio), '%Y-%m-%d %H:%i:%s') AS lastVisit,
        (SELECT tipo FROM citas WHERE id_paciente = p.id_paciente AND id_empleado = ? ORDER BY fecha_inicio DESC LIMIT 1) AS diagnosis
      FROM pacientes p
      JOIN personas pe ON p.id_persona = pe.id_persona
      JOIN citas c ON p.id_paciente = c.id_paciente
      WHERE c.id_empleado = ? AND c.estado = 'completada' AND c.fecha_inicio < NOW()
      GROUP BY p.id_paciente, pe.nombre, pe.apellido
      ORDER BY MAX(c.fecha_inicio) DESC
    `, [id_empleado, id_empleado]);

    res.json(rows);
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Error al obtener el historial de pacientes' });
  }
};

// Endpoint auxiliar para obtener id_empleado desde id_usuario
exports.getUsuario = async (req, res) => {
  const id_usuario = req.params.id_usuario;
  try {
    const [rows] = await pool.query('SELECT id_empleado FROM usuarios WHERE id_usuario = ?', [id_usuario]);
    if (rows.length > 0) {
      res.json(rows[0]);
    } else {
      res.status(404).json({ error: 'Usuario no encontrado' });
    }
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Error al obtener datos del usuario' });
  }
};

// Configurar rutas (exportar como router para app.js)
const router = require('express').Router();
router.get('/historial/:id_empleado', exports.getHistorial);
router.get('/usuario/:id_usuario', exports.getUsuario);

module.exports = router;
