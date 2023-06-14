<?php
// Los controladores se van a usar en la carpeta ajax en su respectivo archivo cuando hagamos una petición AJAX y en index.php cuando no hagamos uso de la misma
// $peticionAjax se encuentra en el index y tiene el valor de false
if ($peticionAjax) {
    // Si es true es porque estoy en ajax/archivoEspecifico
    require_once "../modelos/loginModelo.php";
} else {
    // Si es false es porque estoy en el index
    require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo
{
    //-------- Controlador iniciar sesión --------
    // Los controladores deben ser publicos y no estaticos
    protected static function iniciar_sesion_controlador()
    {
    }
}
