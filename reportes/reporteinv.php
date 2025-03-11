<?php
include("../BD/conexion.php");
// require("/xampp/htdocs/CRUD2/fpdf186/fpdf.php");
require("../fpdf186/fpdf.php");

$pdf = new FPDF(); // Clase nueva de FPDF

// Eliminar márgenes de la página
$pdf->SetMargins(0, 0, 0); // Eliminar márgenes
$pdf->AddPage();    // Orientación, tamaño, rotación

$pdf->SetFont('Arial', 'B', 24); // Fuentes estilo y tamaño

// Título
$pdf->Cell(0, 10, 'Reporte de inventarios', 0, 1, "C"); // Título centrado
$pdf->Ln(10); // Agregar un poco de espacio después del título

// Imagen
$pdf->Image("../Front/ogani/img/logo rm qs.png", 140, 20, 60, 18, 'png'); // Logo
$pdf->Ln(10); // Agregar espacio después de la imagen

$pdf->SetFont('Arial', 'B', 12); // Fuentes estilo y tamaño
$pdf->Ln();

// Definir el ancho de las columnas
$width = 210; // Ancho total de la página en mm (A4)
$col1_width = 30;  // Ancho para la columna ID del inventario
$col2_width = 70;  // Ancho para la columna Producto
$col3_width = 50;  // Ancho para la columna Existencia
$col4_width = 60;  // Ancho para la columna Sucursal

// Cabecera de la tabla (centrado)
$pdf->Cell($col1_width, 10, "ID INVENTARIO", 1, 0, 'C'); // Cabecera de columna ID Inventario
$pdf->Cell($col2_width, 10, "PRODUCTO", 1, 0, 'C'); // Cabecera de columna Producto
$pdf->Cell($col3_width, 10, "EXISTENCIA", 1, 0, 'C'); // Cabecera de columna Existencia
$pdf->Cell($col4_width, 10, "SUCURSAL", 1, 0, 'C'); // Cabecera de columna Sucursal
$pdf->Ln(); // Nueva línea para los datos

$pdf->SetFont('Arial', '', 12); // Cambiar a fuente normal para los datos

// Consulta para obtener los inventarios
$sql = "SELECT inv_id, productos.pro_Producto, inv_existencia, sucursal.suc_nombre 
        FROM inventario 
        INNER JOIN sucursal ON sucursal.suc_id = inventario.suc_id 
        INNER JOIN productos ON productos.pro_id = inventario.pro_id 
        ORDER BY inv_id";

$productos = $conn->query($sql);

while ($row_productos = $productos->fetch_assoc()) { 
    // Imprimir los datos en formato tabla
    $pdf->Cell($col1_width, 10, $row_productos['inv_id'], 1, 0, 'C'); // ID del inventario
    $pdf->Cell($col2_width, 10, $row_productos['pro_Producto'], 1, 0, 'L'); // Producto
    $pdf->Cell($col3_width, 10, $row_productos['inv_existencia'], 1, 0, 'C'); // Existencia
    $pdf->Cell($col4_width, 10, $row_productos['suc_nombre'], 1, 0, 'C'); // Sucursal
    $pdf->Ln(); // Nueva línea después de cada inventario
}

$pdf->Output(); // Salida de PDF
?>
