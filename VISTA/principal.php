<?php
session_start();

// Validar sesión usando tabla "alumnos"
if (!isset($_SESSION['id']) || !isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit();
}

// Datos del alumno
$nombreCompleto = $_SESSION['nombres'] . ' ' . $_SESSION['apellido_paterno'] . ' ' . $_SESSION['apellido_materno'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Capacitat! - Plataforma de Matrícula</title>
  <link rel="stylesheet" href="principal.css">
</head>
<!-- 👇 Se agrega data-nombre al body para acceso desde JavaScript -->
<body class="principal" data-nombre="<?= htmlspecialchars($nombreCompleto) ?>">

  <!-- Navbar -->
  <header class="navbar">
    <div class="navbar-container">
      <div class="navbar-logo">Capacitat!</div>

      <div class="navbar-right">
        <nav class="navbar-links">
          <a href="#" onclick="mostrarInicio()">Página Principal</a>
          <a href="#" onclick="iniciarFlujoMatricula()">Matrícula</a>
          <a href="#" onclick="mostrarResumen()">Mis cursos</a>
        </nav>

        <div class="navbar-icons">
          <span class="icon">🔔<sup>11</sup></span>
          <span class="icon">💬</span>
          <div class="user-dropdown" onclick="toggleMenu()">
            <div class="user-avatar"></div>
            <span class="arrow">▼</span>
            <div id="dropdown-menu" class="dropdown-content">
              <a href="#">👤 Gestionar perfil</a>
              <a href="cerrar_sesion.php">🔓 Cerrar sesión</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Contenido central dinámico -->
  <main id="contenido-principal">
    <div style="grid-column: 1 / -1; text-align: center;">
      <h2>Bienvenido(a), <?= htmlspecialchars($nombreCompleto) ?> 👋</h2>
      <p>Selecciona <strong>"Matrícula"</strong> en el menú para comenzar tu inscripción.</p>
    </div>
  </main>

  <!-- Scripts -->
  <script src="flujo_matricula.js"></script>
  <script>
    function toggleMenu() {
      document.getElementById("dropdown-menu").classList.toggle("show");
    }

    function mostrarInicio() {
      document.getElementById('contenido-principal').innerHTML = `
        <div style="grid-column: 1 / -1; text-align: center;">
          <h2>Bienvenido(a), <?= htmlspecialchars($nombreCompleto) ?> 👋</h2>
          <p>Selecciona <strong>\"Matrícula\"</strong> en el menú para comenzar tu inscripción.</p>
        </div>
      `;
    }
  </script>
</body>
</html>



