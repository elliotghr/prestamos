<?php
// Incluimos nuestro modelo
require_once "./modelos/vistasModelo.php";

// Heredamos de vistasModelo par hacer uso de sus métodos
class vistasControlador extends vistasModelo
{
    //-------- Controlador para obtener las plantillas --------
    public function obtener_plantilla_controlador()
    {
        return require_once "./vistas/plantilla.php";
    }
    //-------- Controlador para obtener las vistas --------
    public function obtener_vistas_controlador()
    {
        // Obtenemos la vista por GET
        // Si existe...
        if (isset($_GET['views'])) {
            // Separamos el string en la variable ruta
            $ruta = explode("/", $_GET['views']);
            // Pasamoos ese string a nuestro método obtener_vistas_modelo, para verificar que vista se renderizará 
            $respuesta = vistasModelo::obtener_vistas_modelo($ruta[0]);
        } else {
            // Si no existe, la definimos como login
            $respuesta = "login";
        }
        return $respuesta;
    }
}
