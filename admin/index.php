<?php

$apiUrl = "http://localhost/joy-crm/api/get-inquiries.php";

$jsonResponse = file_get_contents($apiUrl);

$response = json_decode($jsonResponse, true);

$inquiries = $response["data"] ?? [];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel de consultas | Joy CRM</title>
</head>

<body>

    <header>
        <h1>Panel de consultas</h1>
        <p>Administra las consultas recibidas en Joy Digital.</p>
    </header>

    <main>

        <?php if (empty($inquiries)): ?>

            <p>No hay consultas todavía.</p>

        <?php else: ?>

            <?php foreach ($inquiries as $inquiry): ?>

                <article>
                    <h2>
                        <?php echo htmlspecialchars($inquiry["name"]); ?>
                    </h2>

                    <p>
                        Emprendimiento:
                        <?php echo htmlspecialchars($inquiry["business_name"]); ?>
                    </p>

                    <p>
                        Contacto:
                        <?php echo htmlspecialchars($inquiry["contact"]); ?>
                    </p>

                    <p>
                        Servicio:
                        <?php echo htmlspecialchars($inquiry["service"]); ?>
                    </p>

                    <p>
                        Estado:
                        <?php echo htmlspecialchars($inquiry["status"]); ?>
                    </p>

                    <p>
                        Fecha:
                        <?php echo htmlspecialchars($inquiry["created_at"]); ?>
                    </p>
                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

</body>

</html>