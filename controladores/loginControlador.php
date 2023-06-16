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
    public function iniciar_sesion_controlador()
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
            exit();
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
            exit();
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
            exit();
        }

        //-------- Verificamos la integridad de los datos --------
        $clave = mainModel::encryption($clave_log);

        // Enviamos los datos al modelo
        $datos_login = [
            "Usuario" => $usuario_log,
            "Clave" => $clave
        ];

        // Obtenemos los datos
        $datos_usuario = loginModelo::iniciar_sesion_modelo($datos_login);

        // Si trae los datos del usuario...
        if ($datos_usuario->rowCount() > 0) {
            $row = $datos_usuario->fetch();
            // Creamos variables de sesión
            // Inciamos la session y le asignamos un nombre
            session_start(["name" => "PRESTAMOS"]);
            // Creamos variables que nos servirán para mostrar sus datos
            $_SESSION["id_spm"] =  $row["usuario_id"];
            $_SESSION["nombre_spm"] =  $row["usuario_nombre"];
            $_SESSION["apellido_spm"] =  $row["usuario_apellido"];
            $_SESSION["usuario_spm"] =  $row["usuario_usuario"];
            $_SESSION["privilegio_spm"] =  $row["usuario_privilegio"];
            // Creamos un token para cerrar su sesión de manera segura
            $_SESSION["token_spm"] =  md5(uniqid(mt_rand(), true));

            return header("Location: " . SERVERURL . "home/");
        } else {
            // Si no trae los datos del usuario le enviamos el mensaje de error
            echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Ocurrió un error",
                    text: "Credenciales incorrectas, intente de nuevo",
                    confirmButtonText: "Aceptar",
                });
            </script>';
            exit();
        }
    }
    //-------- Controlador forzar cierre de session --------
    // cuando un usuario intente entrar a nuestro sistema y no tenga los permisos para eso
    public function forzar_cierre_sesion_controlador()
    {
        // destruimos la session
        session_unset();
        session_destroy();
        // Verificamos si se envían encabezados con php, si se envían no podemos ocupar el método header)=
        if (headers_sent()) {
            // redirección con js 
            return "<script> location.href='" . SERVERURL . "login/';</script>";
        } else {
            // redirección con php
            return header("Location: " . SERVERURL . "login/");
        }
    }
    //-------- Controlador cerrar sesión --------
    public function cerrar_session_controlador()
    {
        // Reanudamos la sesión
        session_start(['name' => 'PRESTAMOS']);
        // Creamos estas dos variables ya que el botón de cerrar enviará el token y el usuario
        $token = mainModel::decryption($_POST['token']);
        $usuario = mainModel::decryption($_POST['usuario']);
        // Antes de cerrar la sesión
        // Comprobamos que los valores sean identicos a las variables de sesión
        if ($token == $_SESSION["token_spm"] && $usuario == $_SESSION["usuario_spm"]) {
            // Destruimos la sesión si es identico
            session_unset();
            session_destroy();
            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVERURL . "login/",
            ];
            echo json_encode($alerta);
            exit();
        } else {
            // Mandamos un error si no se pudo cerrar la sesión
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No pudimos cerrar tu sesión",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
    }
}
