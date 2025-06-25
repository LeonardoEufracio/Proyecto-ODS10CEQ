<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Alumnos</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <header class="registro-header">
  <img src="media/registro.jpg" alt="Logo de registro" class="registro-logo">
  <span class="registro-titulo">Capacitat! - Universidad Continental</span>
  </header>
  <div class="form-box">
    <h2>Registro de Alumnos</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger datos y sanitizarlos
        $dni = trim($_POST['dni']);
        $nombres = trim($_POST['nombres']);
        $apellido_paterno = trim($_POST['apellido_paterno']);
        $apellido_materno = trim($_POST['apellido_materno']);
        $provincia = $_POST['provincia'];
        $correo = trim($_POST['correo']);
        $celular = trim($_POST['celular']);
        $password = $_POST['password'];
        $confirmar = $_POST['confirmar'];

        // Validar que las contraseñas coincidan
        if ($password !== $confirmar) {
            echo "<p style='color:red;'>Las contraseñas no coinciden.</p>";
        } else {
            // Hashear la contraseña
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Datos de conexión MySQL - cámbialos según tu configuración
            $servername = "localhost";
            $username = "root";         // por defecto en XAMPP es root
            $passwordDB = "";           // usualmente vacío en XAMPP
            $dbname = "plataforma_capacitacion";  // cambia por el nombre real

            // Crear conexión
            $conn = new mysqli($servername, $username, $passwordDB, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("<p style='color:red;'>Error de conexión: " . $conn->connect_error . "</p>");
            }

            // Preparar la consulta para evitar inyección SQL
            $stmt = $conn->prepare("INSERT INTO alumnos (dni, nombres, apellido_paterno, apellido_materno, provincia, correo, celular, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $dni, $nombres, $apellido_paterno, $apellido_materno, $provincia, $correo, $celular, $password_hashed);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Registro exitoso para $nombres $apellido_paterno.</p>";
            } else {
                echo "<p style='color:red;'>Error al registrar: " . $stmt->error . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
    }
    ?>

    <form action="registro.php" method="POST" id="registroForm">
      <label for="dni">DNI:</label>
      <input type="text" id="dni" name="dni" required>
    
      <label for="nombres">Nombres:</label>
      <input type="text" id="nombres" name="nombres" required>
    
      <label for="apellido_paterno">Apellido Paterno:</label>
      <input type="text" id="apellido_paterno" name="apellido_paterno" required>
    
      <label for="apellido_materno">Apellido Materno:</label>
      <input type="text" id="apellido_materno" name="apellido_materno">
    
      <label for="provincia">Selecciona la provincia donde te encuentras:</label>
      <select id="provincia" name="provincia" required>
        <option disabled selected value="">Selecciona la provincia</option>
        <option>AMAZONAS</option>
        <option>ANCASH</option>
        <option>APURÍMAC</option>
        <option>AREQUIPA</option>
        <option>AYACUCHO</option>
        <option>CAJAMARCA</option>
        <option>CALLAO</option>
        <option>CUSCO</option>
        <option>HUANCAVELICA</option>
        <option>HUÁNUCO</option>
        <option>ICA</option>
        <option>JUNÍN</option>
        <option>LA LIBERTAD</option>
        <option>LAMBAYEQUE</option>
        <option>LIMA</option>
        <option>LORETO</option>
        <option>MADRE DE DIOS</option>
        <option>MOQUEGUA</option>
        <option>PASCO</option>
        <option>PIURA</option>
        <option>PUNO</option>
        <option>SAN MARTÍN</option>
        <option>TACNA</option>
        <option>TUMBES</option>
        <option>UCAYALI</option>
      </select>
    
      <label for="correo">Correo electrónico personal:</label>
      <input type="email" id="correo" name="correo" placeholder="Ejemplo: nombre@gmail.com" required>
    
      <label for="celular">Celular:</label>
      <input type="tel" id="celular" name="celular" placeholder="(Ej. 999999999)" required>
    
      <label for="password">Contraseña:</label>
      <input type="password" id="password" name="password" required>
    
      <label for="confirmar">Repetir contraseña:</label>
      <input type="password" id="confirmar" name="confirmar" required>
    
      <button type="submit">Registrar</button>
    </form>
  </div>

  <script>
    document.getElementById("registroForm").addEventListener("submit", function(e) {
      const password = document.getElementById("password").value;
      const confirmar = document.getElementById("confirmar").value;
    
      if (password !== confirmar) {
        e.preventDefault();
        alert("Las contraseñas no coinciden.");
      }
    });
  </script>
</body>
</html>


