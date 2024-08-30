<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['role'] != 'admin') {
    header('Location: ingresar.php');
    exit();
}

require_once '../config/db/db.php';

$query = "SELECT id, name, email, role FROM usuarios ORDER BY id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="../">Inicio</a></li>
                <li><a href="logout.php">Cerrar Sesion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Listado de Usuarios</h2>

            <?php if ($result->num_rows > 0): ?>
                <table id="usuarios-table">
                    <thead>
                        <tr>
                            <th>ID Usuario</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td>
                                    <a class="btn btn-view-invoices" href="ver_facturas.php?user_id=<?php echo $row['id']; ?>">Ver Facturas</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron usuarios.</p>
            <?php endif; ?>

        </section>
    </main>

    <footer>
        &copy; 2024 Orgánico CR. Todos los derechos reservados.
    </footer>
</body>
</html>







