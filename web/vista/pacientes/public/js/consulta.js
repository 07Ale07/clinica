document.getElementById('consultaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const dni = document.getElementById('dni').value;
    const resultadoDiv = document.getElementById('resultado');
    
    fetch(`index.php?action=consultar&dni=${dni}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                resultadoDiv.innerHTML = `<p class="error">${data.error}</p>`;
            } else if (data.fecha) {
                const fecha = new Date(data.fecha + 'T' + data.hora);
                const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const fechaFormateada = fecha.toLocaleDateString('es-ES', opcionesFecha);
                const horaFormateada = data.hora.substring(0, 5); // Formato HH:MM
                
                resultadoDiv.innerHTML = `
                    <div class="turno-info">
                        <h2>Turno encontrado</h2>
                        <p><strong>Paciente:</strong> ${data.nombre} ${data.apellido}</p>
                        <p><strong>Día:</strong> ${fechaFormateada.split(',')[0]}</p>
                        <p><strong>Fecha:</strong> ${fechaFormateada.split(',')[1].trim()}</p>
                        <p><strong>Hora:</strong> ${horaFormateada}</p>
                    </div>
                `;
            } else {
                resultadoDiv.innerHTML = '<p class="no-turno">No se encontró un turno para el DNI ingresado.</p>';
            }
        })
        .catch(error => {
            resultadoDiv.innerHTML = '<p class="error">Ocurrió un error al realizar la consulta.</p>';
            console.error('Error:', error);
        });
});