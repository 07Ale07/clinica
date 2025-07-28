document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = window.location.origin + '/Sistema_Clinica/pacientes/modelo/Database.php';
    
    // Elementos del DOM
    const searchForm = document.getElementById('searchForm');
    const patientInfo = document.getElementById('patientInfo');
    const appointmentSection = document.getElementById('appointmentSection');
    const confirmation = document.getElementById('confirmation');
    const existingAppointmentSection = document.getElementById('existingAppointmentSection');
    const cancelReasonModal = document.getElementById('cancelReasonModal');
    const cancelReasonTextarea = document.getElementById('cancelReason');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');
    
    // Variables de estado
    let selectedDentist = null;
    let selectedDate = null;
    let selectedTime = null;
    let currentPatient = null;
    let currentAppointment = null;

    // Configurar manejadores de eventos
    searchForm.addEventListener('submit', handleSearch);
    document.getElementById('requestNewAppointment').addEventListener('click', handleRequestNewAppointment);
    document.getElementById('showCancelModal').addEventListener('click', showCancelModal);
    confirmCancelBtn.addEventListener('click', handleCancelAppointment);
    document.getElementById('confirmAppointment').addEventListener('click', handleConfirmAppointment);

    // Función principal para buscar pacientes
    async function handleSearch(e) {
        e.preventDefault();
        const dni = document.getElementById('dni').value.trim();
        
        if (!dni) {
            showError('Por favor ingrese un número de DNI');
            return;
        }

        showLoading(true);
        
        try {
            // Buscar paciente
            const response = await safeFetch(`${baseUrl}PacienteController.php?action=buscarPorDni`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `dni=${dni}`
            });
            
            currentPatient = response.paciente;
            displayPatientInfo(response.paciente);
            
            if (response.tiene_turno) {
                currentAppointment = response.turno_actual;
                displayExistingAppointment(response.turno_actual);
                existingAppointmentSection.classList.remove('hidden');
                appointmentSection.classList.add('hidden');
            } else {
                await loadAvailableDentists();
                appointmentSection.classList.remove('hidden');
                existingAppointmentSection.classList.add('hidden');
            }
            
        } catch (error) {
            console.error('Error en handleSearch:', error);
            showError(error.message || 'Ocurrió un error al buscar el paciente');
        } finally {
            showLoading(false);
        }
    }

    // Mostrar información del paciente
    function displayPatientInfo(paciente) {
        const patientDetails = document.getElementById('patientDetails');
        patientDetails.innerHTML = `
            <p><strong>Nombre:</strong> ${paciente.nombre} ${paciente.apellido}</p>
            <p><strong>DNI:</strong> ${paciente.dni}</p>
            <p><strong>Fecha de Nacimiento:</strong> ${formatDate(paciente.fecha)}</p>
        `;
        patientInfo.classList.remove('hidden');
    }

    // Mostrar turno existente
    function displayExistingAppointment(turno) {
        const appointmentDetails = document.getElementById('existingAppointmentDetails');
        appointmentDetails.innerHTML = `
            <div class="appointment-card">
                <h3>Turno Actual</h3>
                <p><strong>Fecha:</strong> ${formatDate(new Date(turno.fecha))}</p>
                <p><strong>Hora:</strong> ${turno.hora.substring(0, 5)}</p>
                <p><strong>Odontólogo:</strong> ${turno.empleado_nombre} ${turno.empleado_apellido}</p>
                <p><strong>Estado:</strong> <span class="status-${turno.estado_cita.toLowerCase()}">${turno.estado_cita}</span></p>
            </div>
            <div class="appointment-actions">
                <button id="showCancelModal" class="btn btn-danger">Cancelar Turno</button>
                <button id="requestNewAppointment" class="btn btn-secondary">Solicitar Nuevo Turno</button>
            </div>
        `;
        
        // Reasignar eventos a los nuevos botones
        document.getElementById('showCancelModal').addEventListener('click', showCancelModal);
        document.getElementById('requestNewAppointment').addEventListener('click', handleRequestNewAppointment);
    }

    // Mostrar modal para cancelación
    function showCancelModal() {
        cancelReasonTextarea.value = '';
        cancelReasonModal.style.display = 'block';
    }

    // Cerrar modal
    function closeModal() {
        cancelReasonModal.style.display = 'none';
    }

    // Manejar cancelación de turno
    async function handleCancelAppointment() {
        const motivo = cancelReasonTextarea.value.trim() || "Cancelado por el paciente";
        
        if (!currentAppointment) {
            showError('No hay un turno seleccionado para cancelar');
            return;
        }

        showLoading(true);
        
        try {
            const response = await safeFetch(`${baseUrl}PacienteController.php?action=cancelarTurno`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id_cita: currentAppointment.id_cita,
                    motivo: motivo
                })
            });
            
            showSuccess('Turno cancelado exitosamente');
            closeModal();
            existingAppointmentSection.classList.add('hidden');
            await loadAvailableDentists();
            appointmentSection.classList.remove('hidden');
            
        } catch (error) {
            console.error('Error en handleCancelAppointment:', error);
            showError(error.message || 'Ocurrió un error al cancelar el turno');
        } finally {
            showLoading(false);
        }
    }

    // Solicitar nuevo turno
    function handleRequestNewAppointment() {
        existingAppointmentSection.classList.add('hidden');
        appointmentSection.classList.remove('hidden');
    }

    // Cargar odontólogos disponibles
    async function loadAvailableDentists() {
        showLoading(true, 'Cargando odontólogos...');
        
        try {
            const response = await safeFetch(`${baseUrl}TurnoController.php?action=obtenerOdontologos`);
            
            const dentistSelection = document.getElementById('dentistSelection');
            dentistSelection.innerHTML = '<h3>Seleccione un Odontólogo</h3>';
            
            if (response.odontologos.length === 0) {
                dentistSelection.innerHTML += '<p class="no-dentists">No hay odontólogos disponibles en este momento</p>';
                return;
            }
            
            response.odontologos.forEach(dentist => {
                const dentistCard = document.createElement('div');
                dentistCard.className = 'dentist-card';
                dentistCard.innerHTML = `
                    <h4>${dentist.nombre} ${dentist.apellido}</h4>
                    <p>Cargo: ${dentist.cargo}</p>
                `;
                dentistCard.addEventListener('click', () => selectDentist(dentist, dentistCard));
                dentistSelection.appendChild(dentistCard);
            });
            
        } catch (error) {
            console.error('Error en loadAvailableDentists:', error);
            showError(error.message || 'Ocurrió un error al cargar los odontólogos');
        } finally {
            showLoading(false);
        }
    }

    // Seleccionar odontólogo
    function selectDentist(dentist, cardElement) {
        document.querySelectorAll('.dentist-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        cardElement.classList.add('selected');
        selectedDentist = dentist;
        document.getElementById('calendarSection').classList.remove('hidden');
        loadAvailableDates(dentist.id_empleado);
    }

    // Cargar fechas disponibles
    async function loadAvailableDates(dentistId) {
        showLoading(true, 'Cargando fechas disponibles...');
        
        try {
            // En un sistema real, aquí harías una llamada al servidor
            // Para este ejemplo, simulamos fechas disponibles
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '<h4>Próximas fechas disponibles</h4>';
            
            // Generar 5 días laborables a partir de mañana
            let datesAdded = 0;
            let currentDate = new Date();
            
            while (datesAdded < 5) {
                currentDate.setDate(currentDate.getDate() + 1);
                
                // Solo días de semana (lunes a viernes)
                if (currentDate.getDay() >= 1 && currentDate.getDay() <= 5) {
                    const dayElement = document.createElement('div');
                    dayElement.className = 'calendar-day';
                    dayElement.textContent = formatDate(currentDate);
                    dayElement.dataset.date = formatDateForDB(currentDate);
                    dayElement.addEventListener('click', () => selectDate(currentDate, dayElement));
                    calendar.appendChild(dayElement);
                    datesAdded++;
                }
            }
            
        } catch (error) {
            console.error('Error en loadAvailableDates:', error);
            showError(error.message || 'Ocurrió un error al cargar las fechas disponibles');
        } finally {
            showLoading(false);
        }
    }

    // Seleccionar fecha
    function selectDate(date, dayElement) {
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('selected');
        });
        
        dayElement.classList.add('selected');
        selectedDate = date;
        loadAvailableTimes(selectedDentist.id_empleado, date);
    }

    // Cargar horarios disponibles
    async function loadAvailableTimes(dentistId, date) {
        showLoading(true, 'Cargando horarios disponibles...');
        
        try {
            // En un sistema real, verificarías disponibilidad con el servidor
            const timeSlotsContainer = document.createElement('div');
            timeSlotsContainer.id = 'timeSlots';
            timeSlotsContainer.innerHTML = '<h4>Horarios disponibles</h4>';
            
            // Limpiar contenedor existente
            const existingContainer = document.getElementById('timeSlots');
            if (existingContainer) {
                existingContainer.remove();
            }
            
            // Simular horarios disponibles (de 9:00 a 17:00)
            const startHour = 9;
            const endHour = 17;
            
            for (let hour = startHour; hour < endHour; hour++) {
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot';
                timeSlot.textContent = `${hour}:00`;
                timeSlot.dataset.time = `${hour}:00:00`;
                timeSlot.addEventListener('click', () => selectTime(hour, timeSlot));
                timeSlotsContainer.appendChild(timeSlot);
            }
            
            document.getElementById('calendar').appendChild(timeSlotsContainer);
            document.getElementById('confirmAppointment').classList.remove('hidden');
            
        } catch (error) {
            console.error('Error en loadAvailableTimes:', error);
            showError(error.message || 'Ocurrió un error al cargar los horarios disponibles');
        } finally {
            showLoading(false);
        }
    }

    // Seleccionar hora
    function selectTime(hour, timeSlotElement) {
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        timeSlotElement.classList.add('selected');
        selectedTime = `${hour}:00:00`;
    }

    // Confirmar nuevo turno
    async function handleConfirmAppointment() {
        if (!selectedDentist || !selectedDate || !selectedTime) {
            showError('Por favor complete todos los campos');
            return;
        }
        
        const formattedDate = formatDateForDB(selectedDate);
        
        showLoading(true, 'Confirmando turno...');
        
        try {
            const response = await safeFetch(`${baseUrl}TurnoController.php?action=asignarTurno`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id_persona: currentPatient.id_persona,
                    id_empleado: selectedDentist.id_empleado,
                    fecha: formattedDate,
                    hora: selectedTime
                })
            });
            
            showConfirmation(response.turno);
            
        } catch (error) {
            console.error('Error en handleConfirmAppointment:', error);
            showError(error.message || 'Ocurrió un error al confirmar el turno');
        } finally {
            showLoading(false);
        }
    }

    // Mostrar confirmación de turno
    function showConfirmation(turno) {
        appointmentSection.classList.add('hidden');
        
        const appointmentDetails = document.getElementById('appointmentDetails');
        appointmentDetails.innerHTML = `
            <div class="confirmation-card">
                <h3>¡Turno confirmado!</h3>
                <p><strong>Paciente:</strong> ${currentPatient.nombre} ${currentPatient.apellido}</p>
                <p><strong>Odontólogo:</strong> ${turno.empleado_nombre} ${turno.empleado_apellido}</p>
                <p><strong>Fecha:</strong> ${formatDate(new Date(turno.fecha))}</p>
                <p><strong>Hora:</strong> ${turno.hora.substring(0, 5)}</p>
                <p><strong>Estado:</strong> <span class="status-pendiente">${turno.estado_cita}</span></p>
            </div>
            <button class="btn" onclick="window.location.reload()">Volver al inicio</button>
        `;
        
        confirmation.classList.remove('hidden');
    }

    // Función safeFetch mejorada con manejo de errores
    async function safeFetch(url, options) {
        try {
            const response = await fetch(url, options);
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                const errorMessage = errorData.error || 
                                   errorData.message || 
                                   `Error en la solicitud (${response.status})`;
                
                throw new Error(errorMessage);
            }
            
            return await response.json();
        } catch (error) {
            console.error(`Error en safeFetch (${url}):`, error);
            throw error;
        }
    }

    // Mostrar/ocultar loading
    function showLoading(show, message = 'Cargando...') {
        const loadingElement = document.getElementById('loadingOverlay') || createLoadingElement();
        loadingElement.querySelector('.loading-message').textContent = message;
        loadingElement.style.display = show ? 'flex' : 'none';
    }

    function createLoadingElement() {
        const loadingElement = document.createElement('div');
        loadingElement.id = 'loadingOverlay';
        loadingElement.style.display = 'none';
        loadingElement.style.position = 'fixed';
        loadingElement.style.top = '0';
        loadingElement.style.left = '0';
        loadingElement.style.width = '100%';
        loadingElement.style.height = '100%';
        loadingElement.style.backgroundColor = 'rgba(0,0,0,0.5)';
        loadingElement.style.justifyContent = 'center';
        loadingElement.style.alignItems = 'center';
        loadingElement.style.zIndex = '1000';
        loadingElement.innerHTML = `
            <div style="background: white; padding: 20px; border-radius: 5px; text-align: center;">
                <div class="spinner"></div>
                <p class="loading-message" style="margin-top: 10px;"></p>
            </div>
        `;
        document.body.appendChild(loadingElement);
        return loadingElement;
    }

    // Mostrar mensajes de error
    function showError(message) {
        const errorElement = document.getElementById('errorMessage') || createMessageElement('errorMessage');
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        
        setTimeout(() => {
            errorElement.style.display = 'none';
        }, 5000);
    }

    // Mostrar mensajes de éxito
    function showSuccess(message) {
        const successElement = document.getElementById('successMessage') || createMessageElement('successMessage');
        successElement.textContent = message;
        successElement.style.display = 'block';
        
        setTimeout(() => {
            successElement.style.display = 'none';
        }, 3000);
    }

    function createMessageElement(id) {
        const element = document.createElement('div');
        element.id = id;
        element.style.display = 'none';
        element.style.position = 'fixed';
        element.style.top = '20px';
        element.style.right = '20px';
        element.style.padding = '15px';
        element.style.borderRadius = '5px';
        element.style.color = 'white';
        element.style.zIndex = '1001';
        
        if (id === 'errorMessage') {
            element.style.backgroundColor = '#dc3545';
        } else {
            element.style.backgroundColor = '#28a745';
        }
        
        document.body.appendChild(element);
        return element;
    }

    // Funciones auxiliares de formato
    function formatDate(date) {
        if (!(date instanceof Date)) {
            date = new Date(date);
        }
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('es-ES', options);
    }

    function formatDateForDB(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Cerrar modal al hacer clic fuera
    window.addEventListener('click', function(event) {
        if (event.target === cancelReasonModal) {
            closeModal();
        }
    });
});