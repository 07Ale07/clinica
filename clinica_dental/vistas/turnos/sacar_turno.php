<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sacar Turno - Clínica Dental</title>
</head>
<body>
    <h1>Sacar Turno</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="post" action="index.php?accion=procesar_turno">
        <h2>Datos Personales</h2>
        
        <div>
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" required>
        </div>
        
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div>
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>
        
        <div>
            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" required>
        </div>
        
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>
        </div>
        
        <div>
            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
                <option value="O">Otro</option>
            </select>
        </div>
        
        <div>
            <label for="id_obra_social">Obra Social:</label>
            <select id="id_obra_social" name="id_obra_social" required>
                <option value="">Seleccione una obra social</option>
                <?php while ($row = $obrasSociales->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $row['id_obra_social']; ?>">
                        <?php echo $row['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div>
            <label for="nro_afiliado">Número de Afiliado:</label>
            <input type="text" id="nro_afiliado" name="nro_afiliado">
        </div>
        
        <h2>Datos del Turno</h2>
        
        <div>
            <label for="id_profesional">Odontólogo:</label>
            <select id="id_profesional" name="id_profesional" required>
                <option value="">Seleccione un odontólogo</option>
                <?php while ($row = $odontologos->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $row['id_profesional']; ?>">
                        <?php echo $row['nombre'] . ' ' . $row['apellido'] . ' (' . $row['matricula'] . ')'; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div>
            <label for="id_sillon">Sillón:</label>
            <select id="id_sillon" name="id_sillon" required>
                <option value="">Seleccione un sillón</option>
                <?php while ($row = $sillones->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo $row['id_sillon']; ?>">
                        <?php echo $row['nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div>
            <label for="fecha_turno">Fecha del Turno:</label>
            <input type="date" id="fecha_turno" name="fecha_turno" required>
        </div>
        
        <div>
            <label for="hora_inicio">Hora de Inicio:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" required>
        </div>
        
        <div>
            <label for="observaciones">Observaciones:</label>
            <textarea id="observaciones" name="observaciones"></textarea>
        </div>
        
        <button type="submit">Solicitar Turno</button>
    </form>
</body>
</html>