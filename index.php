<?php

$nombreProyecto = "Joy CRM";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nombreProyecto; ?></title>
</head>

<body>
    <header>
        <h1><?php echo $nombreProyecto; ?></h1>
        <p>Contanos qué necesita tu negocio 💻✨</p>
    </header>
    <main>
        <form action="api/create-inquiry.php" method="POST">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" required>
            <label for="business_name">Nombre del emprendimiento/empresa</label>
            <input type="text" id="business_name" name="business_name">

            <label for="contact">WhatsApp o Instagram</label>
            <input type="text" id="contact" name="contact" required>

            <label for="service">¿Qué servicio necesitás?</label>
            <select name="service" id="service" required>
                <option value="" selected disabled>Seleccione una opción</option>
                <option value="website-upgrade">Página Web Upgrade</option>
                <option value="automation">Automatización</option>
                <option value="ai-commercial">Publicidad/Reel con IA</option>
                <option value="starter-website">Página Web Inicial para Emprendedores</option>
                <option value="meta-ads">Publicidad Digital</option>
                <option value="content-creation">Creación de contenido</option>
                <option value="other">Otro</option>
            </select>

            <label for="message">Contame un poco más</label>
            <textarea id="message" name="message" rows="5"></textarea>

            <button type="submit">Enviar consulta</button>
        </form>
    </main>
</body>

</html>