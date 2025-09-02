// landing/public/js/editor.js
$(document).ready(function() {
    // Función para guardar cambios
    window.saveChanges = function() {
        var formData = $('#editForm').serializeArray();
        formData.push({ name: 'action', value: 'save' });

        $.ajax({
            url: '../modelo/modelo_edit_index.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                if (response.success) {
                    location.reload(); // Recargar para actualizar la lista de pendientes
                }
            },
            error: function(xhr, status, error) {
                alert('Error al guardar los cambios: ' + error);
            }
        });
    };

    // Función para aplicar cambios
    window.applyChanges = function(id) {
        if (confirm('¿Estás seguro de que deseas aplicar esta configuración?')) {
            $.ajax({
                url: '../modelo/modelo_edit_index.php',
                type: 'POST',
                data: { action: 'apply', id: id },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error al aplicar los cambios: ' + error);
                }
            });
        }
    };
});