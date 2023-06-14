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
        $usuario_telefono_reg = mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
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

        //-------- Comprobamos los patterns --------
        // Comprobamos directamente el pattern si es un input requerido
        // Si no, validamos que el input tenga valor, después verificamos su pattern
        if (mainModel::verificar_datos("[0-9-]{1,20}", $usuario_dni_reg)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El dni no coincide con el formato solicitado",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $usuario_nombre_reg)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Nombre no coincide con el formato solicitado",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $usuario_apellido_reg)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Apellido no coincide con el formato solicitado",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        // Verificamos el pattern del telefono si el input tiene valor 
        if ($usuario_telefono_reg != "") {
            if (mainModel::verificar_datos("[0-9()+]{8,20}", $usuario_telefono_reg)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Apellido no coincide con el formato solicitado",
                    "Tipo" => "error",
                ];
                echo json_encode($alerta);
                exit();
            }
        }
        // Verificamos el pattern de la dirección si el input tiene valor 
        if ($usuario_direccion_reg != "") {
            if (mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}", $usuario_direccion_reg)) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Apellido no coincide con el formato solicitado",
                    "Tipo" => "error",
                ];
                echo json_encode($alerta);
                exit();
            }
        }
        if (mainModel::verificar_datos("[a-zA-Z0-9]{1,35}", $usuario_usuario_reg)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Usuario no coincide con el formato solicitado",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $usuario_clave_1_reg) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $usuario_clave_2_reg)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Las claves no coinciden con el formato solicitado",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        //-------- Comprobamos los campos unicos --------
        // Validamos la exitencia del DNI
        $check_dni = mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM usuario WHERE usuario_dni = $usuario_dni_reg");

        if ($check_dni->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El DNI ya exite, ingrese otro, por favor",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }

        // Validamos la exitencia del telefono
        $check_telefono = mainModel::ejecutar_consulta_simple("SELECT usuario_telefono FROM usuario WHERE usuario_telefono = $usuario_telefono_reg");

        if ($check_telefono->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Telefono ya exite, ingrese otro, por favor",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }

        // Validamos la exitencia del usuario
        $check_usuario = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = $usuario_usuario_reg");

        if ($check_usuario->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Nombre de Usuario ya exite, ingrese otro, por favor",
                "Tipo" => "error",
            ];
            echo json_encode($alerta);
            exit();
        }
        // Primero validamos que venga el email (ya que no es requerido)
        if ($usuario_email_reg != "") {
            // Validamos si el formato del email es valido
            if (filter_var($usuario_email_reg, FILTER_VALIDATE_EMAIL)) {
                // Verificamos la existencia del email
                $check_email = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_usuario = $usuario_email_reg");

                if ($check_email->rowCount() > 0) {
                    // Si el email existe, entonces, mandamos el error personalizado
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrió un error inesperado",
                        "Texto" => "El Email ya exite, ingrese otro, por favor",
                        "Tipo" => "error",
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            } else {
                // Si no es valido retornamos el error correspondiente
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El Email no coincide con el formato solicitado",
                    "Tipo" => "error",
                ];
                echo json_encode($alerta);
                exit();
            }
        }
    }
}
