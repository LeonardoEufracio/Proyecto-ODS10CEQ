<?php
session_start();

// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plataforma_capacitacion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $conn->real_escape_string(trim($_POST['usuario'])); // dni
    $clave = $_POST['clave'];

    // Consultar todos los campos necesarios
    $sql = "SELECT id, dni, nombres, apellido_paterno, apellido_materno, correo, celular, password 
            FROM alumnos 
            WHERE dni = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();

        // Verificar la contraseña hasheada
        if (password_verify($clave, $fila['password'])) {
            // Asignar datos a la sesión
            $_SESSION['id'] = $fila['id'];
            $_SESSION['dni'] = $fila['dni'];
            $_SESSION['nombres'] = $fila['nombres'];
            $_SESSION['apellido_paterno'] = $fila['apellido_paterno'];
            $_SESSION['apellido_materno'] = $fila['apellido_materno'];
            $_SESSION['correo'] = $fila['correo'];
            $_SESSION['celular'] = $fila['celular'];

            // Redirigir al panel principal
            header("Location: principal.php");
            exit();
        } else {
            $mensaje = "<p style='color:red;'>❌ Contraseña incorrecta.</p>";
        }
    } else {
        $mensaje = "<p style='color:red;'>❌ Usuario no encontrado.</p>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Iniciar sesión - Capacitat</title>
  <link rel="stylesheet" href="index.css" />
</head>
<body>
  <div class="login-container">
    <img src="media/Logo_U.jpg" alt="Logo" />
    <h2>Iniciar sesión</h2>

    <form id="loginForm" action="login.php" method="POST">
      <input type="text" name="usuario" placeholder="DNI" required />
      <input type="password" name="clave" placeholder="Contraseña" required />
      <button type="submit">Acceder</button>
      <a href="#">¿Olvidó su contraseña?</a>
    </form>

    <?php echo $mensaje; ?>

    <hr />
    <div class="social-login">
      <strong>Identifíquese usando su cuenta en:</strong>
      <div class="google-btn">
        <img
        src="media/google.jpg"
        width="20"
        height="20"
        style="margin-right:10px; object-fit: contain;"
         alt="Google Logo"
        />
        Google
      </div>
    </div>
  </div>
</body>
</html>



