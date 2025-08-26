document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario de registro de paciente
    const registroForm = document.querySelector('form[action*="registrar_paciente"]');
    if (registroForm) {
        // Validación DNI (8-10 dígitos)
        const dniInput = document.getElementById('dni');
        if (dniInput) {
            dniInput.addEventListener('blur', function() {
                if (this.value && !/^\d{8,10}$/.test(this.value)) {
                    alert('El DNI debe contener entre 8 y 10 dígitos numéricos');
                    this.focus();
                }
            });
        }

        registroForm.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const dni = document.getElementById('dni').value.trim();
            const fechaNac = document.getElementById('fecha_nac').value;
            
            // Validar campos obligatorios
            if (!nombre || !apellido || !dni || !fechaNac) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos.');
                return;
            }
            
            // Validar formato DNI
            if (!/^\d{8,10}$/.test(dni)) {
                e.preventDefault();
                alert('El DNI debe contener entre 8 y 10 dígitos numéricos');
                dniInput.focus();
                return;
            }
            
            // Validar fecha de nacimiento razonable
            const fechaNacDate = new Date(fechaNac);
            const hoy = new Date();
            const edadMinima = new Date();
            edadMinima.setFullYear(hoy.getFullYear() - 120); // 120 años máximo
            
            if (fechaNacDate > hoy) {
                e.preventDefault();
                alert('La fecha de nacimiento no puede ser futura');
                return;
            }
            
            if (fechaNacDate < edadMinima) {
                e.preventDefault();
                alert('La fecha de nacimiento no parece válida (edad máxima 120 años)');
                return;
            }
        });
    }
    
    // Validación del formulario de verificación de paciente
    const verificarForm = document.querySelector('form[action*="verificar_paciente"]');
    if (verificarForm) {
        const dniInput = document.getElementById('dni');
        if (dniInput) {
            dniInput.addEventListener('blur', function() {
                if (this.value && !/^\d{8,10}$/.test(this.value)) {
                    alert('El DNI debe contener entre 8 y 10 dígitos numéricos');
                    this.focus();
                }
            });
        }

        verificarForm.addEventListener('submit', function(e) {
            const dni = document.getElementById('dni').value.trim();
            
            if (!dni) {
                e.preventDefault();
                alert('Por favor ingrese su DNI.');
                return;
            }
            
            if (!/^\d{8,10}$/.test(dni)) {
                e.preventDefault();
                alert('El DNI debe contener entre 8 y 10 dígitos numéricos');
                dniInput.focus();
                return;
            }
        });
    }
    
    // Validación del formulario de turno
    const turnoForm = document.querySelector('form[action*="confirmar_turno"]');
    if (turnoForm) {
        // Configurar fecha mínima (hoy)
        const fechaInput = document.getElementById('fecha');
        if (fechaInput) {
            const today = new Date().toISOString().split('T')[0];
            fechaInput.setAttribute('min', today);
            
            // Si hay una fecha almacenada (por ejemplo, al volver atrás)
            if (!fechaInput.value) {
                fechaInput.value = today;
            }
        }

        // Validar horarios laborales
        const horaSelect = document.getElementById('hora');
        if (horaSelect) {
            // Opcional: puedes generar las opciones de hora dinámicamente aquí
            const horariosLaborales = ['09:00', '10:00', '11:00', '12:00', '15:00', '16:00', '17:00', '18:00'];
            
            // Limpiar y llenar opciones
            horaSelect.innerHTML = '';
            horariosLaborales.forEach(hora => {
                const option = document.createElement('option');
                option.value = hora;
                option.textContent = hora;
                horaSelect.appendChild(option);
            });
        }

        turnoForm.addEventListener('submit', function(e) {
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            const odontologo = document.getElementById('id_odontologo').value;
            
            if (!fecha || !hora || !odontologo) {
                e.preventDefault();
                alert('Por favor complete todos los campos requeridos.');
                return;
            }
            
            // Validar que no sea fin de semana
            const fechaObj = new Date(fecha);
            const diaSemana = fechaObj.getDay();
            if (diaSemana === 0 || diaSemana === 6) { // 0=Domingo, 6=Sábado
                e.preventDefault();
                alert('No se pueden agendar turnos los fines de semana.');
                return;
            }
            
            // Validar horario laboral
            const horaNum = parseInt(hora.split(':')[0]);
            if ((horaNum < 9 || horaNum > 12) && (horaNum < 15 || horaNum > 18)) {
                e.preventDefault();
                alert('Los turnos deben ser en horario laboral (9-12hs o 15-18hs)');
                return;
            }
            
            // Validar email si fue completado
            const emailInput = document.getElementById('email');
            if (emailInput && emailInput.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    e.preventDefault();
                    alert('Por favor ingrese un correo electrónico válido.');
                    emailInput.focus();
                    return;
                }
            }
        });
    }
    
    // Mejorar experiencia de usuario en selección de fecha
    const fechaInputs = document.querySelectorAll('input[type="date"]');
    fechaInputs.forEach(input => {
        // Establecer fecha mínima como hoy si no está definida
        if (!input.min) {
            const today = new Date().toISOString().split('T')[0];
            input.setAttribute('min', today);
        }
        
        // Mejorar la selección en dispositivos móviles
        input.addEventListener('focus', function() {
            this.showPicker && this.showPicker();
        });
    });
    
    // Mejorar accesibilidad
    document.querySelectorAll('.option-card').forEach(card => {
        card.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                this.click();
            }
        });
        
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
    });
});