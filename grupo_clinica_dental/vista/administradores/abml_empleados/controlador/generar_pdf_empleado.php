<?php
ob_start(); // evita salida antes del PDF

require_once(__DIR__ . '/../../../../fpdf186/fpdf.php');
require_once(__DIR__ . '/../conexion.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',12);
        $this->Cell(0,8,'Reporte de Empleados',0,1,'C');
        $this->Ln(3);

        $this->SetFont('Arial','B',9);
        $this->Cell(15,8,'Legajo',1,0,'C');
        $this->Cell(35,8,'Nombre',1,0,'C');
        $this->Cell(25,8,'DNI',1,0,'C');
        $this->Cell(25,8,'Contrato',1,0,'C');
        $this->Cell(15,8,'Estado',1,0,'C');
        $this->Cell(35,8,'Cargo',1,0,'C');
        $this->Cell(25,8,'Foto',1,1,'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);

$query = "
SELECT e.numero_legajo, p.nombre, p.apellido, p.DNI, c.cargo, 
       e.tipo_contrato, e.activo, e.foto
FROM empleados e
INNER JOIN personas p ON e.id_persona = p.id_persona
LEFT JOIN cargo_empleados ce ON e.id_empleado = ce.id_empleado
LEFT JOIN cargos c ON ce.id_cargo = c.id_cargo
";
$result = $enlace->query($query);

if(!$result){
    die("Error en la consulta: " . $enlace->error);
}

while($row = $result->fetch_assoc()){
    $pdf->Cell(15,15,$row['numero_legajo'],1,0,'C');
    $pdf->Cell(35,15,utf8_decode($row['nombre']." ".$row['apellido']),1,0,'L');
    $pdf->Cell(25,15,$row['DNI'],1,0,'C');
    $pdf->Cell(25,15,$row['tipo_contrato'],1,0,'C');
    $pdf->Cell(15,15,($row['activo'] ? 'Activo' : 'Inactivo'),1,0,'C');
    $pdf->Cell(35,15,utf8_decode($row['cargo']),1,0,'L');

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $rutaFoto = __DIR__ . "/../uploads/" . $row['foto'];

    if(!empty($row['foto']) && file_exists($rutaFoto)){
        $pdf->Cell(25,15,'',1,0,'C');
        $pdf->Image($rutaFoto, $x+5, $y+2, 15, 11); // foto más chica
    } else {
        $pdf->Cell(25,15,'Sin foto',1,0,'C');
    }

    $pdf->Ln();
}

if(ob_get_length()) ob_clean(); // limpia cualquier salida previa
$pdf->Output();
ob_end_flush();
