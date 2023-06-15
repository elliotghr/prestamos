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
        $usuario_log = mainModel::limpiar_cadena($_POST['usuario_log']);
        $clave_log = mainModel::limpiar_cadena($_POST['clave_log']);

        //-------- Verificamos los datos --------
        if ($usuario_log == "" || $clave_log == "") {
            echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Ocurrió un error inesperado",
                    text: "No ha llenado todos los campos requeridos",
                    confirmButtonText: "Aceptar",
                });
            </script>';
        }
        //-------- Verificamos la integridad de los datos --------
        if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario_log)) {
            echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Ocurrió un error inesperado",
                    text: "El Usuario no coincide con el formato solicitado",
                    confirmButtonText: "Aceptar",
                });
            </script>';
        }
        if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_log)) {
            echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Ocurrió un error inesperado",
                    text: "La Clave no coincide con el formato solicitado",
                    confirmButtonText: "Aceptar",
                });
            </script>';
        }

        //-------- Verificamos la integridad de los datos --------
        $clave = mainModel::encryption($clave_log);

        $datos_login = [
            "Usuario" => $usuario_log,
            "Clave" => $clave
        ];

        $datos_usuario = loginModelo::iniciar_sesion_modelo($datos_login);

        if ($datos_usuario->rowCount() > 0) {
            $datos_usuario->fetch();
        } else {
            echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Ocurrió un error",
                    text: "Credenciales incorrectas, intente de nuevo",
                    confirmButtonText: "Aceptar",
                });
            </script>';
        }
    }
}
