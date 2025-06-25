<?php
session_start();
if (!isset($_SESSION['id'])) {
  echo json_encode(['error' => 'No hay sesión']);
  exit();
}

$conexion = new mysqli("localhost", "root", "", "plataforma_capacitacion");
if ($conexion->connect_error) {
  echo json_encode(['error' => 'Error en conexión']);
  exit();
}

$id = $_SESSION['id'];
$sql = "SELECT COUNT(*) as total FROM matriculas WHERE id_alumno = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

echo json_encode(['total' => $resultado['total']]);
$stmt->close();
$conexion->close();
?>
