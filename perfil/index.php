<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ingresar.php");
    exit();
}

$email_usuario = $_SESSION['usuario'];

require_once '../config/db/db.php';

$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("s", $email_usuario);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: ../ingresar.php");
    exit();
}

$id_usuario = $user['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas</title>
    <link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="../"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="../logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</header>
<div class="container">
    <section>
        <h2>Mi Perfil</h2>
        <div id="perfil-container">
            <?php
                $sql = "SELECT * FROM usuarios WHERE id=?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    die("Error obteniendo informacion del usuario: " . $conn->error);
                }

                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                if (!$result) {
                    die("Error al obtener las facturas: " . $stmt->error);
                }
                while($row = $result->fetch_assoc()):
            ?>
            <span><b>Nombre Completo: </b><span><?php echo htmlspecialchars($row['name']); ?></span></span>
            <span><b>Correo Electrónico: </b><span><?php echo htmlspecialchars($row['email']); ?></span></span>
            <span><b>Rol: </b><span><?php echo htmlspecialchars($row['role']); ?></span></span>
            <?php endwhile;?>
        </div>
        <h2>Mis Facturas</h2>
        <?php
            $sql = "SELECT * FROM facturas WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error en la preparación de la consulta de facturas: " . $conn->error);
            }
            
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                die("Error al obtener las facturas: " . $stmt->error);
            }
            if ($result->num_rows > 0):
        ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tarjeta</th>
                        <th>Dirección</th>
                        <th>Detalles</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['tarjeta']); ?></td>
                            <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                            <td><?php echo $row['detalles']; ?></td>
                            <td><?php echo htmlspecialchars($row['total']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h4>No se encontraron facturas.</h4>
        <?php endif; ?>
    </section>
</div>
</body>
</html>


