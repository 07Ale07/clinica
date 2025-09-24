const db = require('../config/db');

function validarInicioSesion(usuario, contrasena, callback) {
  const query = `
    SELECT u.usuario,
           u.clave AS password_desencriptada,
           e.id_cargo
    FROM usuarios u
    JOIN cargo_empleados e ON u.id_empleado = e.id_empleado
    WHERE u.usuario = ?
    LIMIT 1
  `;

  db.query(query, [usuario], (err, results) => {
    if (err) {
      return callback(err, null);
    }

    if (results.length > 0) {
      const user = results[0];
      if (user.password_desencriptada === contrasena) {
        let rol;
        switch (user.id_cargo) {
          case 1:
            rol = 'odontologo';
            break;
          case 2:
            rol = 'paciente';
            break;
          case 3:
            rol = 'Farmaceutico';
            break;
          // Agrega más casos si es necesario (por ejemplo, 'admin' si existe en tu BD)
          default:
            rol = null;
        }
        return callback(null, rol);
      }
    }

    return callback(null, false);
  });
}

module.exports = { validarInicioSesion };
