<?php
session_start();
if (!isset($_SESSION['id']) || !isset($_GET['curso_id'])) {
  echo "<p>No se encontró la matrícula.</p>";
  exit();
}

$conexion = new mysqli("localhost", "root", "", "plataforma_capacitacion");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

$curso_id = intval($_GET['curso_id']);
$alumno_id = $_SESSION['id'];

$sql = "SELECT a.nombres, a.apellido_paterno, a.apellido_materno, a.dni, a.correo, 
               c.nombre AS curso_nombre
        FROM alumnos a
        JOIN matriculas m ON a.id = m.id_alumno
        JOIN cursos c ON c.id = m.id_curso
        WHERE a.id = ? AND c.id = ?
        LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $alumno_id, $curso_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
  echo "<p>No se encontró la matrícula.</p>";
  exit();
}

$fila = $resultado->fetch_assoc();
$nombre_completo = "{$fila['nombres']} {$fila['apellido_paterno']} {$fila['apellido_materno']}";
$dni = $fila['dni'];
$correo = $fila['correo'];
$curso_nombre = $fila['curso_nombre'];
$orden = rand(1000000, 9999999);
$cliente = rand(7000000, 7999999);
$total = 40.00;

$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pagar matrícula</title>
  <link rel="stylesheet" href="pago.css">
</head>
<body>
  <div class="pago-container">
    <div class="encabezado-pago">
      <img src="media/logo_continental.jpg" alt="Logo" class="logo">
      <h1>UNIVERSIDAD CONTINENTAL - CAPACITAT!</h1>
    </div>

    <p class="mensaje-importante">POR FAVOR COMPRUEBE SU PEDIDO ANTES DEL PAGO</p>

    <table class="tabla-datos">
      <tr><th>Cliente:</th><td><?= htmlspecialchars($nombre_completo) ?></td></tr>
      <tr><th>Tipo cliente:</th><td>DNI</td></tr>
      <tr><th>Código de Orden:</th><td><?= $orden ?></td></tr>
      <tr><th>Código de Cliente:</th><td><?= $cliente ?></td></tr>
      <tr><th>Descripción de la orden:</th><td><?= htmlspecialchars($curso_nombre) ?> - Capacitación 2025</td></tr>
      <tr><th>Correo:</th><td><?= htmlspecialchars($correo) ?></td></tr>
      <tr><th>Subtotal:</th><td><?= number_format($total, 2) ?></td></tr>
      <tr><th>IGV:</th><td>0.00</td></tr>
      <tr><th>Total:</th><td><strong><?= number_format($total, 2) ?></strong></td></tr>
    </table>

    <label class="terminos">
      <input type="checkbox" id="acepto" checked>
      Acepto los <a href="#">Términos de Servicio</a> y <a href="#">Términos de Revocación</a>
    </label>
    <p class="advertencia">Por favor, no cierres esta ventana hasta que el proceso de pago haya finalizado por completo.</p>

    <button class="btn-pagar" onclick="mostrarModal()">Pagar Aquí</button>
  </div>

  <!-- Modal de selección de método -->
  <div class="modal" id="modalPago">
    <div class="modal-contenido">
      <span class="cerrar" onclick="cerrarModal()">×</span>
      <h3>Capacitat!</h3>

      <label><input type="radio" name="metodo_pago"> Tarjeta de crédito y débito</label>
      <div class="logos"><img src="media/visa_mastercard.jpg" alt="Tarjetas"></div>

      <label><input type="radio" name="metodo_pago"> Código QR usando tu billetera electrónica</label>
      <div class="logos"><img src="media/qr_wallets.jpg" alt="QR Wallets"></div>

      <label><input type="radio" name="metodo_pago"> Pago con Yape</label>
      <div class="logos"><img src="media/yape_grande.jpg" alt="Yape grande"></div>

      <button class="continuar" onclick="mostrarQR()">Continuar</button>
    </div>
  </div>

  <!-- Modal QR -->
  <div class="modal" id="modalQR">
    <div class="modal-qr">
      <span class="cerrar" onclick="cerrarQR()">×</span>
      <img src="media/logo_continental1.jpg" alt="Logo" class="logo">
      <h2>UNIVERSIDAD CONTINENTAL - CAPACITAT!</h2>
      <p><strong>Paga más rápido y fácil!</strong></p>
      <p><small>Recuerda activar las <strong>compras por internet</strong><br>con tu banco</small></p>
      <img src="media/qr_example.jpg" alt="Código QR" class="qr-imagen">
      <p class="descripcion-qr">Escanea el código QR usando<br>la e-wallet de tu banco</p>
      <p><strong>Si ya realizaste el pago en tu billetera, haz clic en Consultar Pago</strong></p>
      <button class="consultar-pago">Consultar Pago</button>
    </div>
  </div>

  <script>
    function mostrarModal() {
      if (!document.getElementById('acepto').checked) {
        alert('Debe aceptar los términos para continuar.');
        return;
      }
      document.getElementById('modalPago').style.display = 'block';
    }

    function cerrarModal() {
      document.getElementById('modalPago').style.display = 'none';
    }

    function mostrarQR() {
      document.getElementById('modalPago').style.display = 'none';
      document.getElementById('modalQR').style.display = 'block';
    }

    function cerrarQR() {
      document.getElementById('modalQR').style.display = 'none';
    }
  </script>
</body>
</html>







