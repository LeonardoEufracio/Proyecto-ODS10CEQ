<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ProgramaCapacitat!</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
   <header>
        <div class="container">
            <p class="logo">Capacitat!</p>
            <nav>
                <a href="#somos-proya">Quienes somos</a>
                <a href="#nuestros-programas">Nuestros Programas</a>
                <a href="#caracteristicas">Caracteristicas</a>
                <a href="login.php">Iniciar sesión</a>
                <a href="registro.php">Registrarse</a>
            </nav>
        </div>
   </header>
   <section id="hero">
        <h1>Comienza tu aprendizaje hoy, <br>gratis y certificado. </h1>
        <button>Explorar Cursos</button>
   </section>

   <section id="somos-proya">
        <div class="container">
            <div class="img-container"></div> 
            <div class="texto">
                <h2>Somos <span class="color-acento">Capacitat!</span></h2>    
                <p>Creemos que la educación es un derecho, no un privilegio.
                    Somos una comunidad de educadores, desarrolladores y entusiastas comprometidos 
                    con ofrecer acceso libre y gratuito a cursos de alta calidad para todas las personas, 
                    sin importar su ubicación o situación económica.</p>
            </div>
        </div>
   </section>

   <section id="nuestros-programas">
    <div class="container">
        <h2>Nuestros Programas</h2>
        <div class="programas">
            <div class="carta">
                <h3>Programador Front-End</h3>
                <p>Desarrolla interfaces web interactivas y responsivas usando HTML, CSS y JavaScript, 
                    enfocándose en la experiencia del usuario.</p>
                <button>+ Info</button>
            </div>
            <div class="carta">
                <h3>Programador Full-Stack</h3>
                <p>LDesarrolla tanto el frontend como el backend de aplicaciones web, 
                   integrando diseño, lógica y bases de datos en soluciones completas.</p>
                <button>+ Info</button>
            </div>
            <div class="carta">
                <h3>Programador Python</h3>
                <p>Desarrolla soluciones eficientes para web, automatización, análisis de datos e 
                    inteligencia artificial utilizando el lenguaje Python.</p>
                <button>+ Info</button>
            </div>
        </div>
    </div>
   </section>

   <section id="caracteristicas">
    <div class="container">
        <ul>
            <li>✔️ 100% online</li>
            <li>✔️ Flexibilidad de Horarios</li>
            <li>✔️ Soporte 1:1</li>
            <li>✔️ Asistencia Financiera</li>
        </ul>
    </div>
   </section>

   <section id="final">
        <h2>Listo para Empezar</h2>
        <button>APLICA YÁ</button>
   </section>

   <footer>
        <div class="container">
            <p>&copy; Capacitat <?php echo date("Y"); ?></p>
        </div>
   </footer>
</body>
</html>
