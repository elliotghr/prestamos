<?php
// Este archivo se dedicará a definir o asignar los valores a la variable de sesión para la busqueda
session_start(["name" => "PRESTAMOS"]);
// 
require_once "../config/APP.php";
if (isset($_POST["busqueda-inicial"]) || isset($_POST["eliminar-busqueda"]) || isset($_POST["fecha-inicio"]) || isset($_POST["fecha-final"])) {

    // Creamos un array para validar que nuestras vistas solo sean estas (temas de seguridad)
    $data_url = [
        "usuario" => "user-search",
        "cliente" => "client-search",
        "item" => "item-search",
        "prestamo" => "reservation-search"
    ];

    if (isset($_POST["modulo"])) {
        $modulo = $_POST["modulo"];
        // Mandamos un error si no viene en el array
        if (!isset($data_url[$modulo])) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No podemos continuar con la busqueda debido a un error",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        // Condicón unica para el módulo de prestamo (Es el único que tiene más de 1 término de busqueda)
        if ($modulo == "prestamo") {
            // Creamos variables para posteriormente asignar los valores a nuestras variables de sesión
            $fecha_inicio = "fecha_inicio_" . $modulo;
            $fecha_final = "fecha_final_" . $modulo;

            // iniciar busqueda
            // Si vienen las fechas significa que estamos haciendo una busqueda
            if (isset($_POST["fecha-inicio"]) || isset($_POST["fecha-final"])) {
                // Si las variables no tienen valor mandamos un error
                if ($_POST["fecha-inicio"] = "" || $_POST["fecha-final"] = "") {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Por favor introduce una fecha de inicio y una fecha final",
                        "Tipo" => "error",
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                // Si las variables tienen valor creamos sus variables de sesión
                $_SESSION["fecha_inicio"] = $_POST["fecha-inicio"];
                $_SESSION["fecha_final"] = $_POST["fecha-final"];
            }
            // Eliminar busqueda
            // Si solo viene eliminar-busqueda significa que no hay fechas definidas y por ende es una eliminación
            if (isset($_POST["eliminar-busqueda"])) {
                session_unset($_SESSION["fecha_inicio"]);
                session_unset($_SESSION["fecha_final"]);
            }
        } else {
            // Para los demás modulos...
            // Creamos el texto para posteriormente crear una variable de sesión de forma dinamica
            $name_var = "busqueda_$modulo";
            if (isset($_POST["busqueda-inicial"])) {
                if ($_POST["busqueda-inicial"] == "") {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "Por favor introduce un valor en la busqueda",
                        "Tipo" => "error",
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                // Creamos la variable de sesión
                $_SESSION[$name_var] = $name_var;
            }

            //Para eliminar la busqueda
            if (isset($_POST["eliminar-busqueda"])) {
                unset($_SESSION[$name_var]);
            }
        }
    } else {
        $alerta = [
            "Alerta" => "simple",
            "Titulo" => "Ocurrió un error inesperado",
            "Texto" => "No podemos continuar con la busqueda debido a un error de configuración",
            "Tipo" => "error",
        ];
        echo json_encode($alerta);
        exit();
    }

    // Después de asignar las variables de sesión mandamos una redirección para que se carguen estos datos
    $url = SERVERURL . $data_url[$modulo] . "/";
    // Redireccionar
    $alerta = [
        "Alerta" => "redireccion",
        "URL" => $url
    ];
    echo json_encode($alerta);
} else {
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
}
