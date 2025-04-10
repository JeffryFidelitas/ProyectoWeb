<?php
    session_start(); 
    $isLoggedIn = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órganico CR - Sobre Nosotros y Contacto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header class="header" style="background-color: #2c5f2c;">
        <nav class="navbar navbar-expand-lg" style="background-color: #2c5f2c;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../" style="color: white;">Orgánico CR</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../" style="color: white;">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index_category.php" style="color: white;">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../productos" style="color: white;">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../servicios" style="color: white;">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../nosotros#contacto" style="color: white;">Contacto</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <?php if ($isLoggedIn): ?>
                            <a class="btn btn-outline-light mx-2" href="../perfil">Perfil</a>
                            <a class="btn btn-light mx-2" href="../index_category.php">Cerrar Sesión</a>
                        <?php else: ?>
                            <a class="btn btn-outline-light mx-2" href="../index_category.php">>Iniciar Sesión</a>
                            <a class="btn btn-light mx-2" href="../registro.php">Registrarte</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="nosotros">
            <h2>Sobre Nosotros</h2>
            <div class="about-content">
                <div class="about-text">
                    <h3>Nuestra Misión</h3>
                    <p>En Órganico CR, nuestra misión es promover la agricultura sostenible y apoyar a los pequeños productores locales de Costa Rica. Buscamos ofrecer una plataforma que facilite la conexión directa entre los agricultores y los consumidores, eliminando intermediarios y garantizando productos frescos y orgánicos de alta calidad.</p>

                    <h3>Nuestra Visión</h3>
                    <p></p>

                    <h3>Valores</h3>
                    <ul>
                        <li><strong>Sostenibilidad:</strong> .</li>
                        <li><strong>Calidad:</strong> .</li>
                        <li><strong>Transparencia:</strong> </li>
                        <li><strong>Compromiso:</strong> </li>
                    </ul>

                    <h3>Conoce a Nuestro Equipo</h3>
                    <div class="team">
                        <div class="team-member">
                            <img src="../images/persona1.jpg" alt="Foto de Juan Pérez">
                            <h4>Juan Pérez</h4>
                            <p><strong>Fundador y CEO</strong><br>Jn </p>
                        </div>
                        <div class="team-member">
                            <img src="../images/persona2.jpg" alt="Foto de María López">
                            <h4>María López</h4>
                            <p><strong>Directora de Operaciones</strong><br>María asegura que todas las operaciones diarias de la plataforma funcionen sin problemas, desde la gestión de pedidos hasta la logística de entrega.</p>
                        </div>
                        <div class="team-member">
                            <img src="../images/persona3.jpg" alt="Foto de Carlos Gómez">
                            <h4>Carlos Gómez</h4>
                            <p><strong>Responsable de Marketing</strong><br>Carlos se encarga de promover la plataforma y conectar con los consumidores a través de estrategias de marketing digital innovadoras.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contacto">
            <h2>Contacto</h2>
            <p>Estamos aquí para ayudarte. Si tienes alguna pregunta o necesitas más información sobre nuestra plataforma, no dudes en ponerte en contacto con nosotros.</p>
            <form id="contactForm" action="contact.php" method="post">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
                <label for="message">Mensaje:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>

    <br>
    <br>

    <footer class="footer">
        <p>&copy; 2024 Orgánico CR. Todos los derechos reservados.</p>
    </footer>

    <script src="https://www.gstatic.com/dialogflow-console/fast/df-messenger/prod/v1/df-messenger.js"></script>
    <df-messenger
      location="us-central1"
      project-id="poised-receiver-429822-c7"
      agent-id="ac88363f-2574-4d67-83af-661102301084"
      language-code="es"
      max-query-length="-1">
      <df-messenger-chat-bubble
       chat-title="Órganico CR">
      </df-messenger-chat-bubble>
    </df-messenger>



    <script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            document.getElementById('contactForm').reset(); // paraa limpiar el formulario
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    });
    </script>
</body>
</html>





