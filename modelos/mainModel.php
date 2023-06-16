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
        $sql->execute();
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

    //-------- Función para verificar datos (patterns) --------
    public static function verificar_datos($pattern, $string)
    {
        if (preg_match('/^' . $pattern . '$/', $string)) {
            return false;
        } else {
            return true;
        }
    }

    //-------- Función para verificar fechas --------
    protected static function verificar_fecha($date)
    {
        $new_date = explode($date, "-");
        // https://www.php.net/manual/es/function.checkdate.php
        $fecha = checkdate($new_date[1], $new_date[2], $new_date[0]);
        if (count($new_date) == 3 && $fecha) {
            return false;
        } else {
            return true;
        }
    }
    //-------- Función para la paginación --------
    // Esta función genera el paginador dependiendo de las paginas y # de paginas
    protected static function paginacion($pagina_actual, $n_paginas, $url, $botones)
    {
        // Abrimos la estructura del nav
        $tabla = '
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
            ';

        // Generamos los botones para regresar a la primera página y regresar una pagina
        // si estamos en la pag 1 deshabilitamos el botón de retroceso a la primera página, no renderizamos el botón de página anterior
        if ($pagina_actual == 1) {
            $tabla .= '
                <li class="page-item disabled">
                    <a class="page-link" ><i class="fa-solid fa-angles-left"></i></a>
                </li>
                ';
        } else {
            // si no estamos en la pag 1 habilitamos el botón de retroceso a la primera página, pasamos la url y renderizamos el botón de página anterior
            $tabla .= '
                <li class="page-item">
                    <a class="page-link" href="' . $url . '1/" ><i class="fa-solid fa-angles-left"><<<</i></a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="' . $url . ($pagina_actual - 1) . '/" >Anterior</i></a>
                </li>
                ';
        }

        // Generamos los botones de las páginas
        $contador = 0;

        for ($i = $pagina_actual; $i <= $n_paginas; $i++) {
            // Condicional si queremos controlar el # de botones a mostrar
            if ($contador >= $botones) {
                break;
            }
            // Condición para detectar si estamos en la págona actual y darle estilos diferentes
            if ($pagina_actual == $i) {
                $tabla .= '
                    <li class="page-item"><a class="page-link active" href="' . $url . $i . '">' . $i . '</a></li>
                    ';
            } else {
                $tabla .= '
                <li class="page-item"><a class="page-link" href="' . $url . $i . '">' . $i . '</a></li>
                ';
            }
            $contador++;
        }


        // Generamos los botones para ir a la ultima página y adelantar una pagina
        // si estamos en la ultima pag deshabilitamos el botón de adelantar a la ultima página, no renderizamos el botón de página siguiente
        if ($pagina_actual == $n_paginas) {
            $tabla .= '
                <li class="page-item disabled">
                    <a class="page-link" ><i class="fa-solid fa-angles-right"></i></a>
                </li>
                ';
        } else {
            // si no estamos en la ultima página habilitamos el botón de ir a la ultima página, pasamos la url y renderizamos el botón de página siguiente
            $tabla .= '
            <li class="page-item">
                <a class="page-link" href="' . $url . ($pagina_actual + 1) . '/" >Siguiente</i></a>
            </li>
                <li class="page-item">
                    <a class="page-link" href="' . $url . $n_paginas . '/" >>>><i class="fa-solid fa-angles-right"></i></a>
                </li>
                ';
        }

        // Cerramos la estructura del nav
        $tabla .= '
                </ul>
            </nav>
            ';

        return $tabla;
    }
}
