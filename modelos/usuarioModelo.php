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
}
