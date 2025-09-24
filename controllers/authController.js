const mysql = require('mysql2/promise');

const pool = mysql.createPool({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'clinica',
});

exports.login = async (req, res) => {
  const { usuario, contrasena } = req.body;

  try {
    const [rows] = await pool.query(
      `SELECT u.id_usuario, u.id_empleado, c.cargo 
       FROM usuarios u 
       JOIN cargo_empleados ce ON u.id_empleado = ce.id_empleado 
       JOIN cargos c ON ce.id_cargo = c.id_cargo 
       WHERE u.usuario = ? AND u.clave = ?`,
      [usuario, contrasena]
    );

    if (rows.length > 0) {
      const user = rows[0];
      res.json({
        success: true,
        rol: user.cargo.toLowerCase(),
        id_usuario: user.id_usuario,
      });
    } else {
      res.json({ success: false, message: 'Usuario o contraseña incorrectos' });
    }
  } catch (error) {
    console.error('Error en login:', error);
    res.status(500).json({ success: false, message: 'Error al iniciar sesión' });
  }
};
