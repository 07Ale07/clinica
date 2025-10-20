document.addEventListener('DOMContentLoaded', function() {
    // Estado global del odontograma
    const state = {
        currentProcedure: 'sano',
        teeth: {},
        selectedTooth: null
    };

    // Inicializar el odontograma
    function initOdontograma() {
        const dentalChart = document.getElementById('dental-chart');
        if (!dentalChart) return;

        // Cargar datos existentes si hay
        if (window.odontogramaData) {
            state.teeth = window.odontogramaData;
        }

        // Renderizar dientes
        renderTeeth();

        // Eventos para los botones de procedimiento
        document.querySelectorAll('.procedimientos button').forEach(button => {
            button.addEventListener('click', function() {
                // Remover activo de todos los botones
                document.querySelectorAll('.procedimientos button').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Marcar botón actual como activo
                this.classList.add('active');
                
                // Actualizar procedimiento seleccionado
                state.currentProcedure = this.dataset.procedimiento;
                
                // Si hay un diente seleccionado, actualizarlo
                if (state.selectedTooth) {
                    updateToothState(state.selectedTooth);
                }
            });
        });

        // Evento para el botón Guardar
        document.getElementById('btn-guardar')?.addEventListener('click', saveOdontograma);

        // Evento para el botón Limpiar
        document.getElementById('btn-reset')?.addEventListener('click', resetOdontograma);
    }

    // Renderizar los dientes
    function renderTeeth() {
        const dentalChart = document.getElementById('dental-chart');
        if (!dentalChart) return;

        // Números FDI de los dientes (adultos)
        const teethNumbers = [
            18, 17, 16, 15, 14, 13, 12, 11,
            21, 22, 23, 24, 25, 26, 27, 28,
            48, 47, 46, 45, 44, 43, 42, 41,
            31, 32, 33, 34, 35, 36, 37, 38
        ];

        let html = '<div class="dental-arch">';
        
        teethNumbers.forEach(num => {
            const procedure = state.teeth[num] || 'sano';
            const isSelected = state.selectedTooth === num ? 'selected' : '';
            html += `
                <div class="tooth ${procedure} ${isSelected}" data-tooth="${num}">
                    <div class="tooth-number">${num}</div>
                </div>
            `;
        });
        
        html += '</div>';
        dentalChart.innerHTML = html;

        // Agregar eventos a los dientes
        document.querySelectorAll('.tooth').forEach(tooth => {
            tooth.addEventListener('click', function() {
                const toothNum = parseInt(this.dataset.tooth);
                state.selectedTooth = toothNum;
                updateToothState(toothNum);
                showToothInfo(toothNum);
            });
        });
    }

    // Mostrar información del diente seleccionado
    function showToothInfo(toothNum) {
        const procedure = state.teeth[toothNum] || 'sano';
        const infoPanel = document.getElementById('tooth-info');
        const toothNumberElement = document.getElementById('info-tooth-number');
        const toothNameElement = document.getElementById('info-tooth-name');
        const toothStateElement = document.getElementById('info-tooth-state');
        const toothProcedureElement = document.getElementById('info-tooth-procedure');
        
        // Mostrar panel si estaba oculto
        infoPanel.style.display = 'block';
        
        // Actualizar información
        toothNumberElement.textContent = toothNum;
        toothNameElement.textContent = toothNames[toothNum] || "Desconocido";
        
        if (procedure === 'sano') {
            toothStateElement.textContent = "Sano";
            toothStateElement.className = "text-success";
        } else if (procedure === 'caries') {
            toothStateElement.textContent = "Con caries";
            toothStateElement.className = "text-danger";
        } else if (procedure === 'restauracion') {
            toothStateElement.textContent = "Restaurado";
            toothStateElement.className = "text-warning";
        }
        
        toothProcedureElement.textContent = procedureNames[procedure] || procedure;
    }

    // Actualizar estado de un diente
    function updateToothState(toothNum) {
        if (state.currentProcedure === 'sano') {
            // Eliminar el procedimiento si está marcado como sano
            delete state.teeth[toothNum];
        } else {
            // Aplicar el procedimiento seleccionado
            state.teeth[toothNum] = state.currentProcedure;
        }
        
        // Volver a renderizar y actualizar info
        renderTeeth();
        showToothInfo(toothNum);
    }

    // Guardar odontograma
    function saveOdontograma() {
        if (!window.idPaciente) {
            alert('Seleccione un paciente primero');
            return;
        }

        fetch('/odontograma/controlador/OdontogramaController.php?action=guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id_paciente: window.idPaciente,
                odontograma: state.teeth
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Odontograma guardado correctamente');
            } else {
                alert('Error al guardar: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        });
    }

    // Limpiar odontograma
    function resetOdontograma() {
        if (confirm('¿Está seguro de limpiar todo el odontograma?')) {
            state.teeth = {};
            state.selectedTooth = null;
            document.getElementById('tooth-info').style.display = 'none';
            renderTeeth();
        }
    }

    // Iniciar la aplicación
    initOdontograma();
});