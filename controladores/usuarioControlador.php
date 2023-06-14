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
    //-------- Controlador para agregar usuario --------
    public function agregar_usuario_controlador()
    {
        // Guardamos los datos del formulario
        $usuario_dni_reg = mainModel::limpiar_cadena($_POST['usuario_dni_reg']);
        $usuario_nombre_reg = mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
        $usuario_apellido_reg = mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
        $usuario_telefono_re = mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
        $usuario_direccion_reg = mainModel::limpiar_cadena($_POST['usuario_direccion_reg']);

        $usuario_usuario_reg = mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
        $usuario_email_reg = mainModel::limpiar_cadena($_POST['usuario_email_reg']);
        $usuario_clave_1_reg = mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
        $usuario_clave_2_reg = mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);

        $usuario_privilegio_reg = mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);

        //-------- Comprobamos los campos vacios que son requeridos--------
        if ($usuario_dni_reg == "" || $usuario_nombre_reg == "" || $usuario_apellido_reg == "" || $usuario_usuario_reg == "" || $usuario_clave_1_reg == "" || $usuario_clave_2_reg == "") {
            // Generamos una array asociativo con los datos necesarios para nuestro fetch js
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No has llenado todos los campos obligatorios",
                "Tipo" => "error",
            ];
            // Convertimos a json
            echo json_encode($alerta);
            exit();
        }
    }
}
