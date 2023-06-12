<?php

class vistasModelo
{
    //-------- Modelo para obtener las vistas --------
    // Este modelo interactua con las vistas, no con la DB

    // Lo generamos estatico para poder acceder a él desde la clase, no desde una instancia
    protected static function obtener_vistas_modelo($vistas)
    {
        // Generamos una lista blanca de palabras que sí se podrán escribir como vistas
        $lista_blanca = ["client-list", "client-new", "client-search", "client-update", "company", "home", "item-list", "item-new", "item-search", "item-update", "reservation-list", "reservation-new", "reservation-pending", "reservation-search", "reservation-update", "user-list", "reservation-reservation", "user-new", "user-search", "user-update"];
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
