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
    // Link de funciones de encriptación -> https://github.com/Carlos007007/SED/blob/master/SED.php
    //-------- Función para encriptar cadenas --------
    public function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    //-------- Función para desencriptar cadenas --------
    protected static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    //-------- Función para generar códigos aleatorios --------
    // P879-3 -> ejemplo de número de prestamo
    protected static function generar_codigo_aleatorio($letra, $longitud, $numero)
    {
        for ($i = 1; $i <= $longitud; $i++) {
            $aleatorio = rand(0, 9);
            $letra .= $aleatorio;
        }
        return $letra . '-' . $numero;
    }
    //-------- Función para limpiar cadenas --------
    // Evitar inyección SQL
    protected static function limpiar_cadena($cadena)
    {
        $palabrasProhibidas = array(
            "<script>",
            "</script>",
            "<script src",
            "<script type=",
            "SELECT * FROM",
            "DELETE FROM",
            "INSERT INTO",
            "DROP TABLE",
            "DROP DATABASE",
            "TRUNCATE TABLE",
            "SHOW TABLES",
            "SHOW DATABASE",
            "<?php",
            "?>",
            "--",
            ">",
            "<",
            "[",
            "]",
            "^",
            "==",
            ";",
            "::"
        );

        $cadena = str_ireplace($palabrasProhibidas, "", $cadena);
        $cadena = stripslashes($cadena);
        $cadena = trim($cadena);

        return $cadena;
    }
}
