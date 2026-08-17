<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$apiUrl = "http://localhost/joy-crm/api/get-inquiries.php";

$jsonResponse = file_get_contents($apiUrl);

$response = json_decode($jsonResponse, true);

$inquiries = $response["data"] ?? [];

$serviceNames = [
    "website-upgrade" => "Página Web Upgrade",
    "automation" => "Automatización",
    "ai-commercial" => "Publicidad | Reel con IA",
    "starter-website" => "Página Web Inicial para Emprendedores",
    "meta-ads" => "Meta | Publicidad Digital",
    "content-creation" => "Creación de contenido",
    "other" => "Otro"
];

$totalInquiries = count($inquiries);
$newInquiries = 0;
$clientInquiries = 0;

foreach ($inquiries as $inquiry) {
    if ($inquiry["status"] === "new") {
        $newInquiries++;
    }

    if ($inquiry["status"] === "client") {
        $clientInquiries++;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel de consultas | Joy CRM</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>

    <header>
        <h1>Panel de consultas</h1>
        <p>Administra las consultas recibidas en Joy Digital.</p>

        <p>
            Sesión iniciada como
            <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>
        </p>

        <a href="logout.php">Cerrar sesión</a>
    </header>

    <main>
        <section class="dashboard-summary">

            <div class="summary-card">
                <span>Total</span>
                <strong><?php echo $totalInquiries; ?></strong>
            </div>

            <div class="summary-card">
                <span>Nuevas</span>
                <strong><?php echo $newInquiries; ?></strong>
            </div>

            <div class="summary-card">
                <span>Clientes</span>
                <strong><?php echo $clientInquiries; ?></strong>
            </div>

        </section>

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
                        <?php
                        echo htmlspecialchars(
                            $serviceNames[$inquiry["service"]] ?? $inquiry["service"]
                        );
                        ?>
                    </p>
                    <label for="status-<?php echo $inquiry["id"]; ?>">
                        Estado:
                    </label>

                    <select class="status-select" id="status-<?php echo $inquiry["id"]; ?>"
                        data-inquiry-id="<?php echo $inquiry["id"]; ?>">
                        <option value="new" <?php echo $inquiry["status"] === "new" ? "selected" : ""; ?>>
                            Nueva
                        </option>

                        <option value="contacted" <?php echo $inquiry["status"] === "contacted" ? "selected" : ""; ?>>
                            Contactada
                        </option>

                        <option value="quoted" <?php echo $inquiry["status"] === "quoted" ? "selected" : ""; ?>>
                            Presupuesto enviado
                        </option>

                        <option value="client" <?php echo $inquiry["status"] === "client" ? "selected" : ""; ?>>
                            Cliente
                        </option>

                        <option value="discarded" <?php echo $inquiry["status"] === "discarded" ? "selected" : ""; ?>>
                            No avanzó
                        </option>
                    </select>

                    <p>
                        Fecha:
                        <?php
                        $createdAt = new DateTime($inquiry["created_at"]);

                        echo $createdAt->format("d/m/Y H:i");
                        ?>
                    </p>
                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>
    <script>
        const statusSelectors = document.querySelectorAll(".status-select");

        statusSelectors.forEach((selector) => {
            selector.addEventListener("change", async () => {
                const formData = new FormData();

                formData.append("id", selector.dataset.inquiryId);
                formData.append("status", selector.value);

                const response = await fetch(
                    "../api/update-status.php",
                    {
                        method: "POST",
                        body: formData
                    }
                );

                const result = await response.json();

                if (result.success) {
                    alert("Estado actualizado correctamente");
                } else {
                    alert("No se pudo actualizar el estado");
                }
            });
        });
    </script>
</body>

</html>