<?php

// Detectamos si tenemos una petición Ajax, si la hay partimos desde la carpeta ajax, por eso la ruta comienza con ../
if ($peticionAjax) {
    require_once "../config/SERVER.php";
} else {
    // Si el valor es false significa que estamos en el index, por tanto partimos de ahi con ./
    require_once "./config/SERVER.php";
}

class mainModel
{
    //-------- Función para conectar a la DB --------
    protected static function conectar()
    {
        // Generamos la conexión y consiguramos el juego de caracteres
        $conexion = new PDO(SGBD, USER, PASSWORD);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    }

    //-------- Función para ejecutar consultas simples --------
    protected static function ejecutar_consulta_simple($consulta)
    {
        // Haciendo uso del método conectar preparamos la consulta
        $sql = self::conectar()->prepare($consulta);
        // Ejecutamos
        $sql = $sql->execute();
        // retornamos el resultado
        return $sql;
    }
}
