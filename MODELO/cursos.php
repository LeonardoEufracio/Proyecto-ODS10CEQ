<?php
session_start();
header('Content-Type: application/json');

// Validación de sesión
if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

$alumno_id = $_SESSION['id'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "plataforma_capacitacion");
if ($conexion->connect_error) {
    echo json_encode(["error" => "Error de conexión"]);
    exit();
}

// Obtener todos los cursos
$sql1 = "SELECT id, nombre, categoria, dias, fecha_inicio, horario FROM cursos ORDER BY categoria, nombre ASC";
$res1 = $conexion->query($sql1);
$todos = [];
while ($fila = $res1->fetch_assoc()) {
    $todos[] = $fila;
}

// Obtener cursos más demandados (máx. 15)
$sql2 = "SELECT id, nombre, categoria, dias, fecha_inicio, horario 
         FROM cursos 
         WHERE categoria = 'Top Demandados' 
         ORDER BY nombre ASC 
         LIMIT 15";
$res2 = $conexion->query($sql2);
$demandados = [];
while ($fila = $res2->fetch_assoc()) {
    $demandados[] = $fila;
}

// ✅ CORREGIDO: usar id_alumno en lugar de m.alumno_id
$sql3 = "SELECT c.id, c.nombre 
         FROM matriculas m 
         INNER JOIN cursos c ON m.id_curso = c.id 
         WHERE m.id_alumno = ?";
$stmt = $conexion->prepare($sql3);
$stmt->bind_param("i", $alumno_id);
$stmt->execute();
$res3 = $stmt->get_result();

$matriculados = [];
while ($row = $res3->fetch_assoc()) {
    $matriculados[] = $row;
}

// Respuesta final en JSON
echo json_encode([
    "todos" => $todos,
    "demandados" => $demandados,
    "matriculados" => $matriculados
]);

$conexion->close();
?>




 
