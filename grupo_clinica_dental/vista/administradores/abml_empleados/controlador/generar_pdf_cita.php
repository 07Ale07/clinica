<?php
require_once(__DIR__ . '/../../../../fpdf186/fpdf.php');
require_once(__DIR__ . '/../conexion.php'); // aquí defines $enlace

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Comprobante de Cita - DentalSmile', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Verificar si llega el parámetro id_cita
if (!isset($_GET['id_cita']) || empty($_GET['id_cita'])) {
    die("No se especificó ninguna cita.");
}

$id_cita = $_GET['id_cita'];

// Consulta SQL
$query = "SELECT c.*, 
                 p.nombre, p.apellido, p.DNI,
                 e.nombre as nombre_empleado, e.apellido as apellido_empleado,
                 s.nombre as nombre_sillon,
                 pr.descripcion as procedimiento
          FROM citas c
          LEFT JOIN pacientes pac ON c.id_paciente = pac.id_paciente
          LEFT JOIN personas p ON pac.id_persona = p.id_persona
          LEFT JOIN empleados emp ON c.id_empleado = emp.id_empleado
          LEFT JOIN personas e ON emp.id_persona = e.id_persona
          LEFT JOIN sillones s ON c.id_sillon = s.id_sillon
          LEFT JOIN procedimientos pr ON c.id_procedimiento = pr.id_procedimiento
          WHERE c.id_cita = ?";

$stmt = $enlace->prepare($query);
$stmt->bind_param("i", $id_cita);
$stmt->execute();
$result = $stmt->get_result();
$cita = $result->fetch_assoc();

if (!$cita) {
    die("No se encontró la cita especificada.");
}

// Crear el PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'COMPROBANTE DE CITA', 0, 1, 'C');
$pdf->Ln(10);

// Datos paciente
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Datos del Paciente:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, 'Nombre: ' . $cita['nombre'] . ' ' . $cita['apellido'], 0, 1);
$pdf->Cell(0, 8, 'DNI: ' . ($cita['DNI'] ?? 'No especificado'), 0, 1);
$pdf->Ln(5);

// Datos cita
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Detalles de la Cita:', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, 'Fecha y Hora: ' . date('d/m/Y H:i', strtotime($cita['fecha_inicio'])), 0, 1);
$pdf->Cell(0, 8, 'Profesional: ' . ($cita['nombre_empleado'] ?? 'No asignado') . ' ' . ($cita['apellido_empleado'] ?? ''), 0, 1);
$pdf->Cell(0, 8, 'Sillón: ' . ($cita['nombre_sillon'] ?? 'No asignado'), 0, 1);
$pdf->Cell(0, 8, 'Tipo: ' . ucfirst($cita['tipo']), 0, 1);
$pdf->Cell(0, 8, 'Estado: ' . ucfirst($cita['estado']), 0, 1);

if (!empty($cita['procedimiento'])) {
    $pdf->Cell(0, 8, 'Procedimiento: ' . $cita['procedimiento'], 0, 1);
}

if (!empty($cita['observaciones'])) {
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Observaciones:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, $cita['observaciones']);
}

$pdf->Ln(15);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Comprobante generado el: ' . date('d/m/Y H:i:s'), 0, 1, 'C');

// Limpiar el buffer antes de enviar el PDF
if (ob_get_length()) {
    ob_end_clean();
}

// Salida del PDF
$pdf->Output('I', 'Cita_' . $cita['nombre'] . '_' . $cita['apellido'] . '.pdf');
exit;
