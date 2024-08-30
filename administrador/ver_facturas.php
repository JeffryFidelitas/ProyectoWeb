<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['role'] != 'admin') {
    header('Location: ingresar.php');
    exit();
}

require_once '../config/db/db.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

$query = "SELECT * FROM facturas WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$query_user = "SELECT name, email FROM usuarios WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas de <?php echo htmlspecialchars($user['name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Facturas de <?php echo htmlspecialchars($user['name']); ?></h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Volver al Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Facturas</h2>

            <?php if ($result->num_rows > 0): ?>
                <table id="facturas-table">
                    <thead>
                        <tr>
                            <th>ID Factura</th>
                            <th>Total</th>
                            <th>Tarjeta</th>
                            <th>Dirección</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['total']; ?></td>
                                <td><?php echo $row['tarjeta']; ?></td>
                                <td><?php echo $row['direccion']; ?></td>
                                <td><?php echo $row['detalles']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron facturas para este usuario.</p>
            <?php endif; ?>

        </section>
    </main>

    <footer>
        &copy; 2024 Orgánico CR. Todos los derechos reservados.
    </footer>
</body>
</html>
