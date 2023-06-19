<?php
if ($_SESSION["privilegio_spm"] != 1) {
	$instancia_login->forzar_cierre_sesion_controlador();
	exit();
}
?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO
	</h3>
	<p class="text-justify">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a class="active" href="<?php echo SERVERURL ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>
</div>
<!-- Si no existe parametro de busqueda... -->
<?php if (!isset($_SESSION["busqueda_usuario"]) && empty($_SESSION["busqueda_usuario"])) {
?>
	<div class="container-fluid">
		<!-- Agregamos la calss, el action, el method y nuestro data-form -->
		<form class="form-neon FormularioAjax" action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
			<input type="hidden" name="modulo" value="usuario">
			<div class="container-fluid">
				<div class="row justify-content-md-center">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="inputSearch" class="bmd-label-floating">¿Qué usuario estas buscando?</label>
							<input type="text" class="form-control" name="busqueda-inicial" id="inputSearch" maxlength="30">
						</div>
					</div>
					<div class="col-12">
						<p class="text-center" style="margin-top: 40px;">
							<button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php
} else {
?>
	<!-- En caso de que ya tengamos una variable de busqueda definida... -->
	<div class="container-fluid">
		<!-- Definimos la casle, el action, el metodo y el data-form si deseamos eliminar nuestra busqueda -->
		<form class="form-neon FormularioAjax" action="<?php echo SERVERURL ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
			<!-- Agregamos el input modulo -->
			<input type="hidden" name="modulo" value="usuario">
			<input type="hidden" name="eliminar-busqueda" value="eliminar">
			<div class="container-fluid">
				<div class="row justify-content-md-center">
					<div class="col-12 col-md-6">
						<p class="text-center" style="font-size: 20px;">
							<!-- Imprimimos nuestro resultado -->
							Resultados de la busqueda <strong>“<?php echo $_SESSION["busqueda_usuario"]; ?>”</strong>
						</p>
					</div>
					<div class="col-12">
						<p class="text-center" style="margin-top: 20px;">
							<button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="container-fluid">
		<?php
		// Con el término de busqueda hecho renderizamos los resultados haciendo uso de nuestro método del controlador ya programado
		require_once "./controladores/usuarioControlador.php";

		$instancia_usuario = new usuarioControlador();
		// Solo pasamos el termino de busqueda
		echo $instancia_usuario->paginador_usuario_controlador($pagina[1], $registros, $_SESSION["privilegio_spm"], $_SESSION["id_spm"], $pagina[0], $_SESSION["busqueda_usuario"]);
		?>
	</div>
<?php
}
?>