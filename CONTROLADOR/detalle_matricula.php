<?php
session_start();

if (!isset($_SESSION['id'])) {
  echo "<p>No has iniciado sesión.</p>";
  exit();
}

$conexion = new mysqli("localhost", "root", "", "plataforma_capacitacion");

if ($conexion->connect_error) {
  echo "<p>Error de conexión a la base de datos.</p>";
  exit();
}

$id_alumno = $_SESSION['id'];

// Obtener cursos matriculados
$sql = "SELECT c.id AS curso_id, c.nombre, c.dias, c.fecha_inicio, c.horario, m.desea_certificado
        FROM matriculas m
        INNER JOIN cursos c ON m.id_curso = c.id
        WHERE m.id_alumno = ?
        ORDER BY c.nombre ASC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
  echo "<p>No tienes cursos matriculados.</p>";
  exit();
}

// Tabla de resultados
echo "<table class='tabla-confirmacion'>
        <thead>
          <tr>
            <th>Curso</th>
            <th>Realizar pago</th>
            <th>Días</th>
            <th>Fecha de inicio</th>
            <th>Horario</th>
            <th>Certificado</th>
          </tr>
        </thead>
        <tbody>";

while ($fila = $resultado->fetch_assoc()) {
  echo "<tr>
          <td>" . htmlspecialchars($fila['nombre']) . "</td>
          <td><a href='pago.php?curso_id=" . urlencode($fila['curso_id']) . "' class='btn-pagar' target='_blank'>pagar</a></td>
          <td>" . htmlspecialchars($fila['dias']) . "</td>
          <td>" . htmlspecialchars($fila['fecha_inicio']) . "</td>
          <td>" . htmlspecialchars($fila['horario']) . "</td>
          <td>" . ($fila['desea_certificado'] ? 'Sí' : 'No') . "</td>
        </tr>";
}

echo "</tbody></table>";

$stmt->close();
$conexion->close();
?>

