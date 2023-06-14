<?php
// Archivo que se encargará de recibir los datos de los formularios
$peticionAjax = true;

require_once "../config/App.php";

// Si enviamos los datos desde el formulario
if (false) {

    //-------- Instancia al controlador --------
    require_once "../controladores/usuarioControlador.php";
    $instancia_usuarios = new usuarioControlador();
    
} else {
    // Si alguien intenta acceder a este archivo...
    // Iniciamos session
    session_start(['name' => 'PRESTAMOS']);
    // Vaciamos la session
    session_unset();
    // La destruimos
    session_destroy();
    // Redirigimos al usuario al login
    header("Location: " . SERVERURL . "login/");
}
