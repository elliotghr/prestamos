<?php

require_once "mainModel.php";

class loginModelo extends mainModel
{
    //-------- Modelo iniciar sesión --------
    protected static function iniciar_sesion_modelo($datos)
    {
        // Generamos la consulta verificando que coincidan el usuario y contraseña, además de verificar que el estado del usuario es "Activa"
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario_usuario = :usuario AND usuario_clave = :clave AND usuario_estado = 'Activa'");
        $sql->bindParam(":usuario", $datos['Usuario']);
        $sql->bindParam(":clave", $datos['Clave']);
        $sql->execute();

        return $sql;
    }
}
