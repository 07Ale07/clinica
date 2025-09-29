const express = require('express');
const mysql = require('mysql2/promise');

const router = express.Router();

// Configuración del pool de conexiones
const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'clinica',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// Probar conexión al iniciar
pool.getConnection()
  .then(conn => {
    console.log('Conexión a la base de datos exitosa en sacar_turno.js');
    conn.release();
  })
  .catch(err => {
    console.error('Error al conectar a la base de datos en sacar_turno.js:', err);
  });

// Endpoint para verificar paciente por DNI
router.post('/verificar_paciente', async (req, res) => {
  console.log('Recibida solicitud POST para /verificar_paciente con body:', req.body);
  const { dni } = req.body;
  if (!dni || !/^\d{8,10}$/.test(dni)) {
    console.log('DNI inválido:', dni);
    return res.status(400).json({ message: 'DNI inválido' });
  }
  try {
    console.log('Ejecutando consulta SQL con DNI:', dni);
    const [results] = await pool.query(
      `
      SELECT p.*, pac.id_paciente 
      FROM personas p
      JOIN pacientes pac ON p.id_persona = pac.id_persona
      WHERE p.DNI = ?
      `,
      [dni]
    );
    console.log('Resultado de la consulta:', results);
    res.json({ paciente: results[0] || null });
  } catch (err) {
    console.error('Error en la consulta SQL:', err);
    res.status(500).json({ message: 'Error en la DB', error: err.message });
  }
});

// Endpoint para registrar paciente
router.post('/registrar_paciente', async (req, res) => {
  console.log('Recibida solicitud POST para /registrar_paciente con body:', req.body);
  const { nombre, apellido, fecha_nac, dni } = req.body;
  if (!nombre || !apellido || !fecha_nac || !dni || !/^\d{8,10}$/.test(dni)) {
    console.log('Datos inválidos:', req.body);
    return res.status(400).json({ message: 'Datos inválidos' });
  }
  const fechaNacDate = new Date(fecha_nac);
  const hoy = new Date();
  if (fechaNacDate > hoy || (hoy.getFullYear() - fechaNacDate.getFullYear()) > 120) {
    console.log('Fecha de nacimiento inválida:', fecha_nac);
    return res.status(400).json({ message: 'Fecha de nacimiento inválida' });
  }
  const tipo = determinarTipoPaciente(fecha_nac);
  let connection;
  try {
    connection = await pool.getConnection();
    await connection.beginTransaction();
    console.log('Insertando persona:', { nombre, apellido, dni });
    const [resultPersona] = await connection.query(
      'INSERT INTO personas (nombre, apellido, DNI) VALUES (?, ?, ?)',
      [nombre, apellido, dni]
    );
    const id_persona = resultPersona.insertId;
    const fecha_registro = new Date().toISOString().slice(0, 10);
    console.log('Insertando paciente:', { id_persona, fecha_registro, tipo });
    await connection.query(
      'INSERT INTO pacientes (id_persona, fecha_registro, tipo, activo) VALUES (?, ?, ?, 1)',
      [id_persona, fecha_registro, tipo]
    );
    await connection.commit();
    res.json({ id_persona, nombre, apellido, fecha_nac, dni });
  } catch (err) {
    if (connection) await connection.rollback();
    console.error('Error al registrar paciente:', err);
    res.status(500).json({ message: 'Error al registrar paciente', error: err.message });
  } finally {
    if (connection) connection.release();
  }
});

// Endpoint para obtener odontólogos
router.get('/obtener_odontologos', async (req, res) => {
  console.log('Recibida solicitud GET para /obtener_odontologos');
  try {
    const [results] = await pool.query(`
      SELECT 
        p.id_persona, 
        p.nombre, 
        p.apellido, 
        e.id_empleado
      FROM personas p
      INNER JOIN empleados e ON p.id_persona = e.id_persona
      INNER JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado
      WHERE ce.id_cargo = 1
      ORDER BY p.apellido, p.nombre
    `);
    console.log('Resultado de odontólogos:', results);
    res.json(results);
  } catch (err) {
    console.error('Error en la consulta SQL:', err);
    res.status(500).json({ message: 'Error en la DB', error: err.message });
  }
});

// Endpoint para obtener horarios disponibles
router.post('/horarios_disponibles', async (req, res) => {
  console.log('Recibida solicitud POST para /horarios_disponibles con body:', req.body);
  const { id_odontologo, fecha } = req.body;
  if (!id_odontologo || !fecha) {
    console.log('Datos requeridos faltantes:', req.body);
    return res.status(400).json({ message: 'Datos requeridos' });
  }
  const horariosLaborales = ['09:00', '10:00', '11:00', '12:00', '15:00', '16:00', '17:00', '18:00'];
  const disponibles = [];
  try {
    for (const hora of horariosLaborales) {
      const fecha_inicio = `${fecha} ${hora}:00`;
      const fecha_fin = new Date(new Date(fecha_inicio).getTime() + 60 * 60 * 1000)
        .toISOString()
        .slice(0, 19)
        .replace('T', ' ');
      console.log('Verificando disponibilidad para:', { id_odontologo, fecha_inicio, fecha_fin });
      const [result] = await pool.query(
        `
        SELECT COUNT(*) as count 
        FROM citas 
        WHERE id_empleado = ? 
        AND fecha_inicio < ? 
        AND fecha_fin > ? 
        AND estado IN ('pendiente', 'confirmada')
        `,
        [id_odontologo, fecha_fin, fecha_inicio]
      );
      if (result[0].count === 0) {
        disponibles.push(hora);
      }
    }
    console.log('Horarios disponibles:', disponibles);
    res.json(disponibles);
  } catch (err) {
    console.error('Error en la consulta SQL:', err);
    res.status(500).json({ message: 'Error en la DB', error: err.message });
  }
});

// Endpoint para confirmar turno
router.post('/confirmar_turno', async (req, res) => {
  console.log('Recibida solicitud POST para /confirmar_turno con body:', req.body);
  const { id_persona, id_odontologo, fecha, hora, email } = req.body;
  if (!id_persona || !id_odontologo || !fecha || !hora) {
    console.log('Datos incompletos:', req.body);
    return res.status(400).json({ message: 'Datos incompletos' });
  }
  const fechaObj = new Date(fecha);
  if (fechaObj < new Date() || fechaObj.getDay() === 0 || fechaObj.getDay() === 6) {
    console.log('Fecha inválida:', fecha);
    return res.status(400).json({ message: 'Fecha inválida' });
  }
  const horaNum = parseInt(hora.split(':')[0]);
  if ((horaNum < 9 || horaNum > 12) && (horaNum < 15 || horaNum > 18)) {
    console.log('Hora fuera de horario laboral:', hora);
    return res.status(400).json({ message: 'Hora fuera de horario laboral' });
  }
  if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    console.log('Email inválido:', email);
    return res.status(400).json({ message: 'Email inválido' });
  }
  let connection;
  try {
    connection = await pool.getConnection();
    await connection.beginTransaction();
    console.log('Buscando paciente con id_persona:', id_persona);
    const [pacienteResult] = await connection.query(
      'SELECT id_paciente FROM pacientes WHERE id_persona = ? AND activo = 1',
      [id_persona]
    );
    if (!pacienteResult[0]) {
      console.log('Paciente no encontrado:', id_persona);
      return res.status(500).json({ message: 'Paciente no encontrado' });
    }
    const id_paciente = pacienteResult[0].id_paciente;
    console.log('Verificando turnos existentes para id_paciente:', id_paciente, 'en fecha:', fecha);
    const [turnoResult] = await connection.query(
      `
      SELECT COUNT(*) as count 
      FROM citas 
      WHERE id_paciente = ? 
      AND DATE(fecha_inicio) = ? 
      AND estado IN ('pendiente', 'confirmada')
      `,
      [id_paciente, fecha]
    );
    if (turnoResult[0].count > 0) {
      console.log('Ya existe un turno para esta fecha:', fecha);
      return res.status(400).json({ message: 'Ya tiene un turno esa fecha' });
    }
    const fecha_inicio = `${fecha} ${hora}:00`;
    const fecha_fin = new Date(new Date(fecha_inicio).getTime() + 60 * 60 * 1000)
      .toISOString()
      .slice(0, 19)
      .replace('T', ' ');
    console.log('Verificando disponibilidad para:', { id_odontologo, fecha_inicio, fecha_fin });
    const [dispResult] = await connection.query(
      `
      SELECT COUNT(*) as count 
      FROM citas 
      WHERE id_empleado = ? 
      AND fecha_inicio < ? 
      AND fecha_fin > ? 
      AND estado IN ('pendiente', 'confirmada')
      `,
      [id_odontologo, fecha_fin, fecha_inicio]
    );
    if (dispResult[0].count > 0) {
      console.log('Horario no disponible:', { fecha, hora });
      return res.status(400).json({ message: 'Horario no disponible' });
    }
    console.log('Insertando turno:', { id_paciente, id_odontologo, fecha_inicio, fecha_fin });
    const [insertResult] = await connection.query(
      `
      INSERT INTO citas 
      (id_paciente, id_empleado, fecha_inicio, fecha_fin, estado, tipo) 
      VALUES (?, ?, ?, ?, 'pendiente', 'consulta')
      `,
      [id_paciente, id_odontologo, fecha_inicio, fecha_fin]
    );
    await connection.commit();
    res.json({ id_turno: insertResult.insertId, fecha, hora, email });
  } catch (err) {
    if (connection) await connection.rollback();
    console.error('Error al crear turno:', err);
    res.status(500).json({ message: 'Error al crear turno', error: err.message });
  } finally {
    if (connection) connection.release();
  }
});

function determinarTipoPaciente(fecha_nac) {
  const edad = new Date().getFullYear() - new Date(fecha_nac).getFullYear();
  if (edad < 18) return 'menor';
  if (edad > 65) return 'geriatrico';
  return 'adulto';
}

module.exports = router;
