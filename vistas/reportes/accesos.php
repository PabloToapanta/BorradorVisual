<?php

require_once __DIR__ . '/../../lib/fpdf19/fpdf.php';

// FPDF no usa UTF-8, por eso se convierten los textos con tildes.
function textoPdf(string $texto): string
{
    return iconv('UTF-8', 'windows-1252//TRANSLIT', $texto);
}

$pdf = new FPDF();
$pdf->AddPage();

// Título y filtros usados.
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, textoPdf('Reporte de accesos'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 7, textoPdf('Estudiante: ' . $nombreEstudiante), 0, 1);
$pdf->Cell(0, 7, textoPdf('Desde: ' . ($fechaInicio !== '' ? $fechaInicio : 'Inicio')
    . '   Hasta: ' . ($fechaFin !== '' ? $fechaFin : 'Hoy')), 0, 1);
$pdf->Ln(4);

// Encabezado de la tabla.
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 8, textoPdf('Fecha y hora'), 1);
$pdf->Cell(40, 8, textoPdf('Código leído'), 1);
$pdf->Cell(70, 8, textoPdf('Estudiante'), 1);
$pdf->Cell(35, 8, textoPdf('Resultado'), 1);
$pdf->Ln();

// Una fila por cada acceso.
$pdf->SetFont('Arial', '', 10);
foreach ($accesos as $fila) {
    $pdf->Cell(45, 8, textoPdf($fila['fecha_hora']), 1);
    $pdf->Cell(40, 8, textoPdf($fila['codigo_leido']), 1);
    $pdf->Cell(70, 8, textoPdf($fila['estudiante'] ?? 'No registrado'), 1);
    $pdf->Cell(35, 8, textoPdf($fila['resultado']), 1);
    $pdf->Ln();
}

$pdf->Ln(4);
$pdf->Cell(0, 7, textoPdf('Total de accesos: ' . count($accesos)), 0, 1);

// 'I' muestra el PDF en el navegador.
$pdf->Output('I', 'reporte_accesos.pdf');
