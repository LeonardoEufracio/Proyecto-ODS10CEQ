<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(["estado" => "error", "mensaje" => "No autorizado"]);
    exit();
}

$alumno_id = $_SESSION['id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    echo json_encode(["estado" => "error", "mensaje" => "Datos inválidos"]);
    exit();
}

$conexion = new mysqli("localhost", "root", "", "plataforma_capacitacion");
if ($conexion->connect_error) {
    echo json_encode(["estado" => "error", "mensaje" => "Conexión fallida"]);
    exit();
}

$stmt = $conexion->prepare("INSERT INTO matriculas (id_alumno, id_curso, desea_certificado, fecha_matricula) VALUES (?, ?, ?, NOW())");

foreach ($data as $curso) {
    $curso_id = $curso["id"];
    $certificado = isset($curso["certificado"]) && $curso["certificado"] ? 1 : 0;

    // Verificar si ya está matriculado
    $verifica = $conexion->prepare("SELECT id FROM matriculas WHERE id_alumno = ? AND id_curso = ?");
    $verifica->bind_param("ii", $alumno_id, $curso_id);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows === 0) {
        $stmt->bind_param("iii", $alumno_id, $curso_id, $certificado);
        $stmt->execute();
    }

    $verifica->close();
}

$stmt->close();
$conexion->close();

echo json_encode(["estado" => "ok"]);
?>
