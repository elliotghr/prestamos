<?php
// Los controladores se van a usar en la carpeta ajax en su respectivo arhivo cuando hagamos una petición AJAX y en index.php cuando no hagamos uso de la misma
// $peticionAjax se encuentra en el index y tiene el valor de false
if ($peticionAjax) {
    // Si es true es porque estoy en ajax/archivoEspecifico
    require_once "../modelos/usuarioModelo.php";
} else {
    // Si es false es porque estoy en el index
    require_once "./modelos/usuarioModelo.php";
}

class usuarioControlador extends usuarioModelo 
{
    
}
