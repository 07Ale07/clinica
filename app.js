
const express = require('express');
const bodyParser = require('body-parser');
const authController = require('./controllers/authController');
const turnosRoutes = require('./controllers/turnos');
const citasRoutes = require('./controllers/citas');
const historialRoutes = require('./controllers/historial');
const inventarioRoutes = require('./controllers/inventario');
const pacientesRoutes = require('./controllers/pacientes');
const odontogramaRoutes = require('./controllers/odontograma');
const sacarTurnoRoutes = require('./controllers/sacar_turno');

const app = express();
const port = 3000;

app.use(bodyParser.json());

// Ruta para iniciar sesión
app.post('/login', authController.login);

// Usar rutas de turnos
app.use('/', turnosRoutes);

// Usar rutas de citas
app.use('/', citasRoutes);

// Usar rutas de historial
app.use('/', historialRoutes);

// Usar rutas de inventario
app.use('/', inventarioRoutes);

// Usar rutas de pacientes
app.use('/pacientes', pacientesRoutes);

// Usar rutas de odontograma
app.use('/', odontogramaRoutes);

// Usar rutas de sacar turno
app.use('/api/sacar_turno', sacarTurnoRoutes);

// Ruta básica de prueba
app.get('/', (req, res) => {
  res.send('La API está funcionando');
});

app.listen(port, '0.0.0.0', () => {
  console.log(`Servidor corriendo en http://localhost:${port} (accesible por IP local)`);
});

