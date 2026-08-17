<?php

session_start();

require_once __DIR__ . "/../config/database.php";

$errorMessage = "";

if (isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $sql = "
        SELECT
            id,
            username,
            password_hash
        FROM admins
        WHERE username = :username
        LIMIT 1
    ";

    $statement = $connection->prepare($sql);

    $statement->execute([
        "username" => $username
    ]);

    $admin = $statement->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin["password_hash"])) {
        session_regenerate_id(true);

        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_username"] = $admin["username"];

        header("Location: index.php");
        exit;
    }

    $errorMessage = "Usuario o contraseña incorrectos.";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ingresar | Joy CRM</title>

    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>

    <header>
        <h1>Joy CRM</h1>
        <p>Ingresá para administrar tus consultas.</p>
    </header>

    <main>
        <form method="POST">

            <label for="username">Usuario</label>
            <input
                type="text"
                id="username"
                name="username"
                required
            >

            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >

            <button type="submit">Ingresar</button>

            <?php if ($errorMessage !== ""): ?>
                <p class="error-message">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </p>
            <?php endif; ?>

        </form>
    </main>

</body>

</html>