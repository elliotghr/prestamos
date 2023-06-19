<?php
// Este archivo se dedicará a definir o asignar los valores a la variable de sesión para la busqueda
session_start(["name" => "PRESTAMOS"]);
// 
require_once "../config/APP.php";
if (isset($_POST["busqueda-inicial"]) || isset($_POST["eliminar-busqueda"]) || isset($_POST["fecha-inicio"]) || isset($_POST["fecha-final"])) {

    $data_url = [
        "usuario" => "user-search",
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
} else {
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
}
