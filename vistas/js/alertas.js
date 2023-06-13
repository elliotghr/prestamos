const $formAjax = document.querySelectorAll(".FormularioAjax");

function enviarFormularioAjax(e, formulario) {
  e.preventDefault();
  const formData = new FormData(formulario);
  const url = formulario.getAttribute("action");
  const tipo = formulario.getAttribute("data-form");
  const method = formulario.getAttribute("method");
  const encabezados = new Headers();

  let options = {
    method: method,
    headers: encabezados,
    body: formData,
  };

  const tipoFormulario = {
    save: "Los datos quedarán guardados en el sistema",
    delete: "Los datos serán eliminados del sistema",
    update: "Los datos del sistema serán actualizados",
    search:
      "Se eliminará el término de busqueda y tendrás que escribir uno nuevo",
    loans:
      "Desea remover los datos seleccionados para prestamos o reservaciones",
    "": "Quieres realizar la operación solicitada?",
  };
  let textoAlerta = tipoFormulario[tipo];

  Swal.fire({
    title: "¿Estás seguro?",
    text: textoAlerta,
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(url, options)
        .then((res) => res.json())
        .then((json) => alertasAjax(json))
        .catch();
    }
  });
}

$formAjax.forEach((formulario) => {
  formulario.addEventListener("submit", (e) => {
    enviarFormularioAjax(e, formulario);
  });
});

const alertasAjax = (alerta) => {
  if (alerta.Alerta === "simple") {
    Swal.fire({
      icon: alerta.Tipo,
      title: alerta.Titulo,
      text: alerta.Texto,
      confirmButtonText: "Aceptar",
    });
  } else if (alerta.Alerta === "recargar") {
    Swal.fire({
      title: alerta.Titulo,
      text: alerta.Texto,
      icon: alerta.Tipo,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        location.reload();
      }
    });
  } else if (alerta.Alerta === "limpiar") {
    Swal.fire({
      title: alerta.Titulo,
      text: alerta.Texto,
      icon: alerta.Tipo,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        // https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/reset
        document.querySelector(".FormularioAjax").reset();
      }
    });
  } else if (alerta.Alerta === "redireccionar") {
    location.href = alerta.URL;
  }

  //   const tipoFormulario = {
  //     simple: Swal.fire({
  //       icon: alerta.Tipo,
  //       title: alerta.Titulo,
  //       text: alerta.Texto,
  //       confirmButtonText: "Aceptar",
  //     }),
  //     recargar: Swal.fire({
  //       title: alerta.Titulo,
  //       text: alerta.Texto,
  //       icon: alerta.Tipo,
  //       showCancelButton: true,
  //       confirmButtonColor: "#3085d6",
  //       cancelButtonColor: "#d33",
  //       confirmButtonText: "Confirmar",
  //       cancelButtonText: "Cancelar",
  //     }).then((result) => {
  //       if (result.isConfirmed) {
  //         location.reload();
  //       }
  //     }),
  //     limpiar: Swal.fire({
  //       title: alerta.Titulo,
  //       text: alerta.Texto,
  //       icon: alerta.Tipo,
  //       showCancelButton: true,
  //       confirmButtonColor: "#3085d6",
  //       cancelButtonColor: "#d33",
  //       confirmButtonText: "Confirmar",
  //       cancelButtonText: "Cancelar",
  //     }).then((result) => {
  //       if (result.isConfirmed) {
  //         // https://developer.mozilla.org/en-US/docs/Web/API/HTMLFormElement/reset
  //         document.querySelector(".FormularioAjax").reset();
  //       }
  //     }),
  //     redireccionar: (location.href = alerta.URL),
  //   };
  //   tipoFormulario[alerta];
};
