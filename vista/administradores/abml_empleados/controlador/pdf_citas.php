<?php
ob_start(); // evita salida antes del PDF

require_once(__DIR__ . '/../../../../fpdf186/fpdf.php');
require_once(__DIR__ . '/../conexion.php');

class PDF extends FPDF {
    function Header() {
        // Logo o título
        $this->SetFont('Arial','B',16);
        $this->SetTextColor(26, 75, 140); // Color primario DentalSmile
        $this->Cell(0,10,'DentalSmile - Reporte de Citas',0,1,'C');
        
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(0, 212, 170); // Color acento
        $this->Cell(0,8,'Listado Completo de Citas Programadas',0,1,'C');
        
        $this->Ln(3);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0,6,'Generado el: ' . date('d/m/Y H:i:s'),0,1,'C');
        $this->Ln(8);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0,10,'Página ' . $this->PageNo() . '/{nb}',0,0,'C');
    }
    
    function ImprovedTable($header, $data) {
        // Anchuras de las columnas optimizadas
        $w = array(28, 28, 18, 25, 25, 18, 18, 40);
        
        // Cabecera
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(26, 75, 140);
        $this->SetTextColor(255);
        $this->SetDrawColor(200, 200, 200);
        $this->SetLineWidth(.3);
        
        for($i=0; $i<count($header); $i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        
        // Restaurar colores y fuente
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial','',7);
        
        // Datos
        $fill = false;
        foreach($data as $row) {
            // Verificar si necesitamos nueva página
            if($this->GetY() > 250) {
                $this->AddPage();
                // Redibujar cabecera
                $this->SetFont('Arial','B',8);
                $this->SetFillColor(26, 75, 140);
                $this->SetTextColor(255);
                for($i=0; $i<count($header); $i++)
                    $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
                $this->Ln();
                $this->SetFillColor(224, 235, 255);
                $this->SetTextColor(0);
                $this->SetFont('Arial','',7);
            }
            
            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
            $this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
            $this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
            $this->Cell($w[5],6,$row[5],'LR',0,'C',$fill);
            $this->Cell($w[6],6,$row[6],'LR',0,'C',$fill);
            $this->Cell($w[7],6,$row[7],'LR',0,'L',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

$pdf = new PDF('L'); // Orientación horizontal para más espacio
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);

// Consulta SQL para obtener todas las citas
$query = "
SELECT 
    c.id_cita,
    c.fecha_inicio,
    c.fecha_fin,
    c.estado,
    c.tipo,
    c.observaciones,
    p_pac.nombre as nombre_paciente,
    p_pac.apellido as apellido_paciente,
    p_emp.nombre as nombre_empleado,
    p_emp.apellido as apellido_empleado,
    s.nombre as nombre_sillon
FROM citas c
LEFT JOIN pacientes pac ON c.id_paciente = pac.id_paciente
LEFT JOIN personas p_pac ON pac.id_persona = p_pac.id_persona
LEFT JOIN empleados emp ON c.id_empleado = emp.id_empleado
LEFT JOIN personas p_emp ON emp.id_persona = p_emp.id_persona
LEFT JOIN sillones s ON c.id_sillon = s.id_sillon
ORDER BY c.fecha_inicio DESC
";

$result = $enlace->query($query);

if(!$result){
    die("Error en la consulta: " . $enlace->error);
}

// Preparar datos para la tabla
$data = array();
$totalCitas = 0;
$estados = array();

while($row = $result->fetch_assoc()){
    $totalCitas++;
    
    // Contar por estado
    $estado = $row['estado'];
    if(!isset($estados[$estado])) {
        $estados[$estado] = 0;
    }
    $estados[$estado]++;
    
    // Formatear datos para la tabla
    $paciente = utf8_decode(substr($row['nombre_paciente'] . " " . $row['apellido_paciente'], 0, 20));
    $profesional = utf8_decode(substr($row['nombre_empleado'] . " " . $row['apellido_empleado'], 0, 20));
    $sillon = utf8_decode(substr($row['nombre_sillon'] ?? 'N/A', 0, 12));
    $fecha_inicio = date('d/m/y H:i', strtotime($row['fecha_inicio']));
    $fecha_fin = date('d/m/y H:i', strtotime($row['fecha_fin']));
    $estado = utf8_decode(ucfirst($row['estado']));
    $tipo = utf8_decode(ucfirst($row['tipo']));
    $observaciones = utf8_decode(substr($row['observaciones'] ?? '', 0, 35));
    
    $data[] = array($paciente, $profesional, $sillon, $fecha_inicio, $fecha_fin, $estado, $tipo, $observaciones);
}

// Cabecera de la tabla
$header = array('Paciente', 'Profesional', 'Sillon', 'Inicio', 'Fin', 'Estado', 'Tipo', 'Observaciones');

// Crear tabla
$pdf->ImprovedTable($header, $data);

// Información del reporte
$pdf->Ln(10);
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(26, 75, 140);
$pdf->Cell(0,8,'RESUMEN ESTADISTICO',0,1,'L');
$pdf->SetDrawColor(0, 212, 170);
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 40, $pdf->GetY());
$pdf->Ln(5);

$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0, 0, 0);

// Estadísticas
$pdf->Cell(0,6,'Total de citas registradas: ' . $totalCitas,0,1,'L');

foreach($estados as $estado => $cantidad) {
    $porcentaje = round(($cantidad / $totalCitas) * 100, 1);
    $pdf->Cell(0,6,ucfirst($estado) . ': ' . $cantidad . ' citas (' . $porcentaje . '%)',0,1,'L');
}

$pdf->Ln(5);
$pdf->SetFont('Arial','I',8);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(0,5,'* Formato de fecha: DD/MM/AA HH:MM',0,1,'L');
$pdf->Cell(0,5,'* Los textos largos se truncaron para mejor visualizacion',0,1,'L');

$pdf->Ln(8);
$pdf->SetFont('Arial','',7);
$pdf->SetTextColor(150, 150, 150);
$pdf->Cell(0,4,'Sistema DentalSmile - ' . date('d/m/Y H:i:s'),0,1,'C');

if(ob_get_length()) ob_clean();
$pdf->Output('I', 'Reporte_Citas_Completo_' . date('Y-m-d') . '.pdf');
ob_end_flush();
?>