<?php

// Incluimos nuestro archivo por las variables globales
require_once "./config/App.php";
// Incluimos nuestro controlador que trae las vistas
require_once "./controladores/vistasControlador.php";

// Generamos la instancia
$plantilla = new vistasControlador();

// Llamamos al método que trae la plantilla
$plantilla->obtener_plantilla_controlador();

// $plantilla->obtener_vistas_controlador();