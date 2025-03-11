<?php
include("../BD/conexion.php");
// require("/xampp/htdocs/CRUD2/fpdf186/fpdf.php");
require("../fpdf186/fpdf.php");

$pdf = new FPDF(); // Clase nueva de FPDF

// Eliminar márgenes de la página
$pdf->SetMargins(0, 0, 0); // Eliminar márgenes
$pdf->AddPage();    // Orientación, tamaño, rotación

$pdf->SetFont('Arial', 'B', 24); // Fuentes estilo y tamaño

// Espacio antes del título
$pdf->Cell(0, 10, 'Reporte de productos', 0, 1, "C"); // Título centrado
$pdf->Ln(10); // Agregar un poco de espacio después del título

// Imagen
$pdf->Image("../Front/ogani/img/logo rm qs.png", 140, 20, 60, 18, 'png'); // Logo
$pdf->Ln(10); // Agregar espacio después de la imagen

$pdf->SetFont('Arial', 'B', 12); // Fuentes estilo y tamaño
$pdf->Ln();

// Definir el ancho de las columnas
$width = 210; // Ancho total de la página en mm (A4)
$col1_width = 30;  // Ancho para la columna ID
$col2_width = 70;  // Ancho para la columna Producto
$col3_width = 50;  // Ancho para la columna Precio
$col4_width = 60;  // Ancho para la columna Categoria

// Cabecera de la tabla (centrado)
$pdf->Cell($col1_width, 10, "ID", 1, 0, 'C'); // Cabecera de columna ID
$pdf->Cell($col2_width, 10, "PRODUCTO", 1, 0, 'C'); // Cabecera de columna Producto
$pdf->Cell($col3_width, 10, "PRECIO", 1, 0, 'C'); // Cabecera de columna Precio
$pdf->Cell($col4_width, 10, "CATEGORIA", 1, 0, 'C'); // Cabecera de columna Categoria
$pdf->Ln(); // Nueva línea para los datos

$pdf->SetFont('Arial', '', 12); // Cambiar a fuente normal para los datos

// Consulta para obtener los productos
$sql = "SELECT pro_id, pro_producto, pro_precio, pro_decripcion, categoria.cat_nombre from productos inner join categoria on categoria.cat_id = productos.cat_id WHERE pro_status = 1 order by pro_id";
$productos = $conn->query($sql);

while ($row_productos = $productos->fetch_assoc()) { 
    // Imprimir los datos en formato tabla
    $pdf->Cell($col1_width, 10, $row_productos['pro_id'], 1, 0, 'C'); // ID
    $pdf->Cell($col2_width, 10, $row_productos['pro_producto'], 1, 0, 'L'); // Nombre del producto
    $pdf->Cell($col3_width, 10, $row_productos['pro_precio'], 1, 0, 'C'); // Precio
    $pdf->Cell($col4_width, 10, $row_productos['cat_nombre'], 1, 0, 'C'); // Categoría
    $pdf->Ln(); // Nueva línea después de cada producto
}

$pdf->Output(); // Salida de PDF
?>
