<?php
require_once(__DIR__ . '/../../../../fpdf186/fpdf.php');
require_once(__DIR__ . '/../conexion.php'); // aquí defines $enlace

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Empleado - DentalSmile', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Verificar si llega el parámetro id_empleado
if (!isset($_GET['id_empleado']) || empty($_GET['id_empleado'])) {
    die("No se especificó ningún empleado.");
}

$id_empleado = $_GET['id_empleado'];

// Consulta SQL para un solo empleado
$query = "SELECT e.numero_legajo, p.nombre, p.apellido, p.DNI, c.cargo, 
                 e.tipo_contrato, e.activo, e.foto
          FROM empleados e
          INNER JOIN personas p ON e.id_persona = p.id_persona
          LEFT JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado
          LEFT JOIN cargos c ON ce.id_cargo = c.id_cargo
          WHERE e.id_empleado = ?";

$stmt = $enlace->prepare($query);
$stmt->bind_param("i", $id_empleado);
$stmt->execute();
$result = $stmt->get_result();
$empleado = $result->fetch_assoc();

if (!$empleado) {
    die("No se encontró el empleado especificado.");
}

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

// Datos del empleado
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0, 10, 'DATOS DEL EMPLEADO', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,'Legajo:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$empleado['numero_legajo'],0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,'Nombre y Apellido:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$empleado['nombre'].' '.$empleado['apellido'],0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,'DNI:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$empleado['DNI'],0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,'Contrato:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$empleado['tipo_contrato'],0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,'Estado:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,($empleado['activo'] ? 'Activo' : 'Inactivo'),0,1);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(50,8,'Cargo:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,8,$empleado['cargo'],0,1);

// Foto del empleado
$pdf->Ln(5);
$rutaFoto = __DIR__ . "/../Uploads/" . $empleado['foto'];
if(!empty($empleado['foto']) && file_exists($rutaFoto)){
    $pdf->Cell(50,50,'',1,0,'C'); // Celda vacía
    $pdf->Image($rutaFoto, $pdf->GetX()-50+5, $pdf->GetY()+5, 40, 40); // Ajuste de imagen
} else {
    $pdf->Cell(50,10,'Sin foto',1,0,'C');
}

// Fecha de generación
$pdf->Ln(60);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,10,'Reporte generado el: '.date('d/m/Y H:i:s'),0,1,'C');

// Limpiar buffer y generar PDF
if(ob_get_length()) ob_end_clean();
$pdf->Output('I','Empleado_'.$empleado['nombre'].'_'.$empleado['apellido'].'.pdf');
exit;
