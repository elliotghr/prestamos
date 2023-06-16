<script>
    // Obtenemos el botón
    let $btnSalir = document.querySelector(".btn-exit-system");

    // Asignamos el listener
    $btnSalir.addEventListener("click", e => {
        e.preventDefault();
        // Enviamos nuestro sweetalert
        Swal.fire({
            title: "¿Quieres salir del sistema?",
            text: "La sesión actual se cerrará y saldrás del sistema",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                // En caso de que quiera cerrar la sesión encriptamos los datos y generamos las variables para el fetch
                const URL = '<?php echo SERVERURL; ?>ajax/loginAjax.php';
                const token = '<?php echo $instancia_login->encryption($_SESSION["token_spm"]) ?>';
                const usuario = '<?php echo $instancia_login->encryption($_SESSION["usuario_spm"]) ?>';


                let formData = new FormData();
                formData.append("token", token);
                formData.append("usuario", usuario);
                let options = {
                    method: "POST",
                    body: formData
                }
                // Enviamos la petición y esperamos la respuesta
                fetch(URL, options).then(res => res.json()).then(json => alertasAjax(json));

            }
        });
    });
</script>