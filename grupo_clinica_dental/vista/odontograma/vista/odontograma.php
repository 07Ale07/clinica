<?php
// vista/odontograma.php
$id_paciente = $_GET['id_paciente'] ?? null;

if(!$id_paciente) {
    header("Location: /odontograma/index.php");
    exit;
}

require_once __DIR__ . '/../modelo/Odontograma.php';
require_once __DIR__ . '/../modelo/Paciente.php';

$odontogramaModel = new Odontograma();
$pacienteModel = new Paciente();

$paciente = $pacienteModel->getPacienteById($id_paciente);
$odontograma = $odontogramaModel->obtenerOdontograma($id_paciente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Odontograma - <?= "{$paciente['nombre']} {$paciente['apellido']}" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/odontograma/public/css/odontograma.css">
    <style>
        .tooth {
            position: relative;
            width: 50px;
            height: 80px;
            margin: 5px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .tooth:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .tooth-number {
            position: absolute;
            top: 5px;
            font-weight: bold;
        }
        .tooth.sano { background-color: #ffffff; }
        .tooth.caries { background-color: #ff6b6b; }
        .tooth.restauracion { background-color: #ffd166; }
        .odontograma-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .dental-arch {
            margin-bottom: 20px;
        }
        #tooth-info {
            max-width: 300px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <a href="/odontograma/index.php" class="btn btn-secondary mb-3">← Volver</a>
        
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Odontograma de <?= "{$paciente['nombre']} {$paciente['apellido']}" ?></h2>
            </div>
            <div class="card-body">
                <div id="dental-chart" class="odontograma-container"></div>
                
                <!-- Panel de información del diente -->
                <div id="tooth-info" class="card mt-3" style="display: none;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Información del Diente</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Diente:</strong> <span id="info-tooth-number">-</span></p>
                        <p><strong>Nombre:</strong> <span id="info-tooth-name">-</span></p>
                        <p><strong>Estado:</strong> <span id="info-tooth-state">-</span></p>
                        <p><strong>Procedimiento:</strong> <span id="info-tooth-procedure">-</span></p>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button id="btn-guardar" class="btn btn-success">Guardar</button>
                    <button id="btn-reset" class="btn btn-warning">Limpiar</button>
                </div>
                
                <div class="mt-3 btn-group procedimientos">
                    <button type="button" class="btn btn-outline-primary active" data-procedimiento="sano">Sano</button>
                    <button type="button" class="btn btn-outline-danger" data-procedimiento="caries">Caries</button>
                    <button type="button" class="btn btn-outline-warning" data-procedimiento="restauracion">Restauración</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.idPaciente = <?= $id_paciente ?>;
        window.odontogramaData = <?= json_encode($odontograma ?: []) ?>;
        
        // Mapeo de nombres de dientes
        const toothNames = {
            11: "Incisivo central superior derecho",
            12: "Incisivo lateral superior derecho",
            13: "Canino superior derecho",
            14: "Primer premolar superior derecho",
            15: "Segundo premolar superior derecho",
            16: "Primer molar superior derecho",
            17: "Segundo molar superior derecho",
            18: "Tercer molar superior derecho",
            
            21: "Incisivo central superior izquierdo",
            22: "Incisivo lateral superior izquierdo",
            23: "Canino superior izquierdo",
            24: "Primer premolar superior izquierdo",
            25: "Segundo premolar superior izquierdo",
            26: "Primer molar superior izquierdo",
            27: "Segundo molar superior izquierdo",
            28: "Tercer molar superior izquierdo",
            
            31: "Incisivo central inferior izquierdo",
            32: "Incisivo lateral inferior izquierdo",
            33: "Canino inferior izquierdo",
            34: "Primer premolar inferior izquierdo",
            35: "Segundo premolar inferior izquierdo",
            36: "Primer molar inferior izquierdo",
            37: "Segundo molar inferior izquierdo",
            38: "Tercer molar inferior izquierdo",
            
            41: "Incisivo central inferior derecho",
            42: "Incisivo lateral inferior derecho",
            43: "Canino inferior derecho",
            44: "Primer premolar inferior derecho",
            45: "Segundo premolar inferior derecho",
            46: "Primer molar inferior derecho",
            47: "Segundo molar inferior derecho",
            48: "Tercer molar inferior derecho"
        };
        
        // Mapeo de procedimientos a nombres legibles
        const procedureNames = {
            sano: "Sano (sin tratamiento)",
            caries: "Caries (necesita tratamiento)",
            restauracion: "Restauración (ya tratado)"
        };
    </script>
    <script src="/odontograma/public/js/odontograma.js"></script>
</body>
</html>