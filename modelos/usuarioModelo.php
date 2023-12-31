<?php

require_once "mainModel.php";

class usuarioModelo extends mainModel
{
    //-------- Modelo agregar usuario --------
    protected static function agregar_usuario_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO usuario (usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio) VALUES (:dni,:nombre,:apellido,:telefono,:direccion,:email,:usuario,:clave,:estado,:privilegio)");

        $sql->bindParam(":dni", $datos['DNI']);
        $sql->bindParam(":nombre", $datos['Nombre']);
        $sql->bindParam(":apellido", $datos['Apellido']);
        $sql->bindParam(":telefono", $datos['Telefono']);
        $sql->bindParam(":direccion", $datos['Direccion']);
        $sql->bindParam(":email", $datos['Email']);
        $sql->bindParam(":usuario", $datos['Usuario']);
        $sql->bindParam(":clave", $datos['Clave']);
        $sql->bindParam(":estado", $datos['Estado']);
        $sql->bindParam(":privilegio", $datos['Privilegio']);

        $sql->execute();

        return $sql;
    }

    //-------- Modelo eliminar usuario --------
    protected static function eliminar_usuario_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM usuario WHERE usuario_id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        return $sql;
    }
    //-------- Modelo obtener datos del usuario --------
    // Este método realizará dos tipos de acciones
    // Traer todos los datos de un usuario para su actualización en la vista user.update
    // Traer la cantidad de usuarios para mostrarlo en el dashboard
    protected static function obtener_datos_usuario_modelo($tipo, $id)
    {
        // Si necesitamos los datos para actualizar un usuario
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario_id = :id");
            $sql->bindParam(":id", $id);
            $sql->execute();
            return $sql;
        } else if ($tipo == "Conteo") {
            // Si necesitamos los datos para el dashboard
            $sql = mainModel::ejecutar_consulta_simple("SELECT COUNT(*) FROM usuario WHERE usuario_id != 1");
            // Retornamos el valor
            return $sql;
        }
    }
    //-------- Modelo actualizar datos del usuario --------
    protected static function actualizar_usuario_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE usuario SET 
                usuario_dni =:usuario_dni,
                usuario_nombre =:usuario_nombre,
                usuario_apellido =:usuario_apellido,
                usuario_telefono =:usuario_telefono,
                usuario_direccion =:usuario_direccion,
                usuario_email =:usuario_email,
                usuario_usuario =:usuario_usuario,
                usuario_clave =:usuario_clave,
                usuario_estado =:usuario_estado,
                usuario_privilegio =:usuario_privilegio WHERE usuario_id = :usuario_id");

        $sql->bindParam(":usuario_id", $datos["usuario_id"]);
        $sql->bindParam(":usuario_dni", $datos["usuario_dni"]);
        $sql->bindParam(":usuario_nombre", $datos["usuario_nombre"]);
        $sql->bindParam(":usuario_apellido", $datos["usuario_apellido"]);
        $sql->bindParam(":usuario_telefono", $datos["usuario_telefono"]);
        $sql->bindParam(":usuario_direccion", $datos["usuario_direccion"]);
        $sql->bindParam(":usuario_email", $datos["usuario_email"]);
        $sql->bindParam(":usuario_usuario", $datos["usuario_usuario"]);
        $sql->bindParam(":usuario_clave", $datos["usuario_clave"]);
        $sql->bindParam(":usuario_estado", $datos["usuario_estado"]);
        $sql->bindParam(":usuario_privilegio", $datos["usuario_privilegio"]);

        $sql->execute();

        return $sql;
    }
}
