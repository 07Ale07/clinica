<div class="panel-principal">
  <h2>👨‍⚕️ Bienvenido, Dr. López</h2>
  <p>Este es su panel principal. Aquí puede ver un resumen rápido de su actividad diaria.</p>

  <div class="resumen">
    <div class="card">
      <i class="fas fa-calendar-check icon"></i>
      <h3>Turnos Hoy</h3>
      <p>6 turnos programados</p>
    </div>

    <div class="card">
      <i class="fas fa-users icon"></i>
      <h3>Pacientes Atendidos</h3>
      <p>3 pacientes registrados hoy</p>
    </div>

    <div class="card">
      <i class="fas fa-notes-medical icon"></i>
      <h3>Historiales Completados</h3>
      <p>2 historiales actualizados</p>
    </div>

    <div class="card">
      <i class="fas fa-user-nurse icon"></i>
      <h3>Solicitudes a Enfermería</h3>
      <p>1 pendiente</p>
    </div>
  </div>

  <div class="nota">
    <h4>📝 Nota:</h4>
    <p>Recuerde completar los historiales clínicos antes de finalizar su jornada.</p>
  </div>
</div>

<style>
.panel-principal {
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.panel-principal h2 {
  margin-top: 0;
  color: #2c3e50;
}

.resumen {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.card {
  background: #ecf0f1;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.icon {
  font-size: 30px;
  color: #3498db;
  margin-bottom: 10px;
}

.nota {
  margin-top: 30px;
  background: #e8f6ff;
  border-left: 5px solid #3498db;
  padding: 15px;
  border-radius: 8px;
}
</style>
