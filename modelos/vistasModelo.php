<?php

class vistasModelo
{
    //-------- Modelo para obtener las vistas --------
    // Este modelo interactua con las vistas, no con la DB

    // Lo generamos estatico para poder acceder a él desde la clase, no desde una instancia
    protected static function obtener_vistas_modelo($vistas)
    {
        // Generamos una lista blanca de palabras que sí se podrán escribir como vistas
        $lista_blanca = [];
        // Comprobaciones para obtener el archivo
        // Si el valor $vista (que viene en la url), está en nuestro array...
        if (in_array($vistas, $lista_blanca)) {
            // Si encuentra el archivo lo devolvemos 
            if (is_file("./vistas/contenidos/" . $vistas . "-view.php")) {
                $contenido = "./vistas/contenidos/" . $vistas . "-view.php";
            } else {
                // Si no lo encuentra devolvemos un 404
                $contenido = "404";
            }
        } elseif ($vistas == "login" || $vistas == "index") {
            // Si el valor es login o index devolvemos la vista login
            $contenido = "login";
        } else {
            // Si el valor no coincide devolvemos la vista 404
            $contenido = "404";
        }
        return $contenido;
    }
}
