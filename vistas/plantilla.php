<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php echo COMPANY; ?></title>
    <!-- Links -->
    <?php include "vistas/inc/Links.php"; ?>
</head>

<body>
    <?php
    $peticionAjax = false;
    require_once "./controladores/vistasControlador.php";
    // IV = Instancia a las Vistas
    $IV = new vistasControlador();
    $vistas = $IV->obtener_vistas_controlador();

    if ($vistas == "login" || $vistas == "404") {
        require_once "./vistas/contenidos/" . $vistas . "-view.php";
    } else {
        // Iniciamos sesión para uisar las variabless de sesión
        session_start(["name" => "PRESTAMOS"]);
    ?>
        <!-- Main container -->
        <main class="full-box main-container">
            <!-- Nav lateral -->
            <?php include "vistas/inc/NavLateral.php"; ?>
            <!-- Page content -->
            <section class="full-box page-content">
                <!-- Nav Bar Superior -->
                <?php include "vistas/inc/NavBar.php"; ?>
                <!-- AQUI ESTARÁ NUESTRO CONTENIDO ESPECIFICAO DE CADA VIEW -->
                <?php require_once $vistas; ?>
            </section>
        </main>
    <?php
    }
    ?>
    <!-- Include JavaScript files -->
    <?php include "vistas/inc/script.php"; ?>
</body>

</html>