document.addEventListener('DOMContentLoaded', function() {
    // Validación básica del formulario de registro
    const registroForm = document.querySelector('form[action*="registrar_paciente"]');
    if (registroForm) {
        registroForm.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            const dni = document.getElementById('dni').value;
            
            if (!nombre || !apellido || !dni) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos.');
            }
        });
    }
    
    // Validación del formulario de turno
    const turnoForm = document.querySelector('form[action*="confirmar_turno"]');
    if (turnoForm) {
        turnoForm.addEventListener('submit', function(e) {
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            
            if (!fecha || !hora) {
                e.preventDefault();
                alert('Por favor seleccione fecha y hora para el turno.');
            }
        });
    }
    
    // Manejo de fechas futuras
    const fechaInput = document.getElementById('fecha');
    if (fechaInput) {
        const today = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('min', today);
    }
});