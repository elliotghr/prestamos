<?php
// Si alguien intenta editar un usuario que no es el suyo...
// Esto lo validamos con el id de la URL y el id de la sesión de la persona que quiere editar
if ($instancia_login->encryption($_SESSION["id_spm"]) != $pagina[1]) {
	// Si esta persona no tiene los privilegios...
	if ($_SESSION["privilegio_spm"] != 1) {
		// Lo sacamos del sistema
		echo $instancia_login->forzar_cierre_sesion_controlador();
		exit();
	}
}
// Si alguien desea editar su propio usuario puede continuar
?>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR USUARIO
	</h3>
	<p class="text-justify">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
	</p>
</div>
<!-- Estas opciones solo se mortrarán a los usuarios con privilegio 1 -->
<?php
if ($_SESSION["privilegio_spm"] == 1) {
?>
	<div class="container-fluid">
		<ul class="full-box list-unstyled page-nav-tabs">
			<li>
				<a href="user-new.html"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
			</li>
			<li>
				<a href="user-list.html"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
			</li>
			<li>
				<a href="user-search.html"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
			</li>
		</ul>
	</div>
<?php
}
?>

<div class="container-fluid">
	<?php
	require_once "./controladores/usuarioControlador.php";

	$instancia_usuario = new usuarioControlador();

	$datos_usuario = $instancia_usuario->obtener_datos_usuario_controlador("Unico", $pagina[1]);
	if ($datos_usuario->rowCount() > 0) {
		$datos_usuario = $datos_usuario->fetch();
	?>

		<form class="form-neon FormularioAjax" action="<?php echo SERVERURL ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off">
			<fieldset>
				<input type="hidden" name="usuario_id_up" value="<?php echo ($pagina[1]) ?>">
				<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_dni" class="bmd-label-floating">DNI</label>
								<input type="text" pattern="[0-9-]{1,20}" class="form-control" name="usuario_dni_up" id="usuario_dni" value="<?php echo $datos_usuario["usuario_dni"] ?>" maxlength="20">
							</div>
						</div>

						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
								<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_nombre_up" value="<?php echo $datos_usuario["usuario_nombre"] ?>" id="usuario_nombre" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-4">
							<div class="form-group">
								<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
								<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}" class="form-control" name="usuario_apellido_up" value="<?php echo $datos_usuario["usuario_apellido"] ?>" id="usuario_apellido" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_telefono" class="bmd-label-floating">Teléfono</label>
								<input type="text" pattern="[0-9()+]{8,20}" class="form-control" name="usuario_telefono_up" id="usuario_telefono" value="<?php echo $datos_usuario["usuario_telefono"] ?>" maxlength="20">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_direccion" class="bmd-label-floating">Dirección</label>
								<input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}" class="form-control" name="usuario_direccion_up" value="<?php echo $datos_usuario["usuario_direccion"] ?>" id="usuario_direccion" maxlength="190">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<br><br><br>
			<fieldset>
				<legend><i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario</label>
								<input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_usuario_up" id="usuario_usuario" value="<?php echo $datos_usuario["usuario_usuario"] ?>" maxlength="35">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_email" class="bmd-label-floating">Email</label>
								<input type="email" class="form-control" name="usuario_email_up" id="usuario_email" value="<?php echo $datos_usuario["usuario_email"] ?>" maxlength="70">
							</div>
						</div>
						<?php
						// Validamos el privilegio 1
						// Solo el privilegio 1 podrá hacer uso de esta función, ya que si no lo validamos, cualquier usuario que quiera modificar su cuenta propia podrá deshabilitar su cuenta por error
						if ($_SESSION["privilegio_spm"] == 1 && $datos_usuario["usuario_id"] != 1) {
						?>
							<div class="col-12">
								<div class="form-group">
									<?php
									$html_activa = '
									<span>Estado de la cuenta &nbsp; <span class="badge badge-info">Activa</span></span>
									<select class="form-control" name="usuario_estado_up">
										<option value="Activa" selected="">Activa</option>
										<option value="Deshabilitada">Deshabilitada</option>
									</select>
									';
									$html_desactivado = '
									<span>Estado de la cuenta &nbsp; <span class="badge badge-danger">Deshabilitada</span></span>
									<select class="form-control" name="usuario_estado_up">
										<option value="Activa">Activa</option>
										<option value="Deshabilitada" selected="">Deshabilitada</option>
									</select>
									';

									echo $render_html = $datos_usuario["usuario_estado"] == "Activa" ? $html_activa : $html_desactivado;
									?>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</fieldset>
			<br><br><br>
			<fieldset>
				<legend style="margin-top: 40px;"><i class="fas fa-lock"></i> &nbsp; Nueva contraseña</legend>
				<p>Para actualizar la contraseña de esta cuenta ingrese una nueva y vuelva a escribirla. En caso que no desee actualizarla debe dejar vacíos los dos campos de las contraseñas.</p>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_clave_nueva_1" class="bmd-label-floating">Contraseña</label>
								<input type="password" class="form-control" name="usuario_clave_nueva_1" id="usuario_clave_nueva_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_clave_nueva_2" class="bmd-label-floating">Repetir contraseña</label>
								<input type="password" class="form-control" name="usuario_clave_nueva_2" id="usuario_clave_nueva_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<?php
			// Validamos el privilegio 1
			// Solo el privilegio 1 podrá hacer uso de esta función, ya que si no lo validamos, cualquier usuario que quiera modificar su cuenta propia podrá deshabilitar su cuenta por error
			if ($_SESSION["privilegio_spm"] == 1 && $datos_usuario["usuario_id"] != 1) {
			?>
				<br><br><br>
				<fieldset>
					<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<p><span class="badge badge-info">Control total</span> Permisos para registrar, actualizar y eliminar</p>
								<p><span class="badge badge-success">Edición</span> Permisos para registrar y actualizar</p>
								<p><span class="badge badge-dark">Registrar</span> Solo permisos para registrar</p>
								<div class="form-group">
									<select class="form-control" name="usuario_privilegio_up">
										<!-- <option value="" selected="" disabled="">Seleccione una opción</option> -->
										<?php
										$privilegio_total = '
										<option value="1" selected="">Control total (Actual)</option>
										<option value="2">Edición</option>
										<option value="3">Registrar</option>
										';
										$privilegio_edicion = '
										<option value="1">Control total</option>
										<option value="2" selected="">Edición (Actual)</option>
										<option value="3">Registrar</option>
										';
										$privilegio_registrar = '
										<option value="1">Control total</option>
										<option value="2">Edición</option>
										<option value="3" selected="">Registrar (Actual)</option>
										';
										echo $render_html = ($datos_usuario["usuario_privilegio"] == 1) ? $privilegio_total : (($datos_usuario["usuario_privilegio"] == 2) ? $privilegio_edicion : $privilegio_registrar);

										?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				<br><br><br>
			<?php
			}
			?>
			<fieldset>
				<p class="text-center">Para poder guardar los cambios en esta cuenta debe de ingresar su nombre de usuario y contraseña</p>
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="usuario_admin" class="bmd-label-floating">Nombre de usuario</label>
								<input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario_admin" id="usuario_admin" maxlength="35" required="">
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="clave_admin" class="bmd-label-floating">Contraseña</label>
								<input type="password" class="form-control" name="clave_admin" id="clave_admin" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="">
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<?php
			if ($instancia_login->encryption($_SESSION["id_spm"]) != $pagina[1]) {
				echo '<input type="hidden" name="tipo_cuenta" value="impropia">';
			} else {
				echo '<input type="hidden" name="tipo_cuenta" value="propia">';
			}
			?>
			<p class="text-center" style="margin-top: 40px;">
				<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
			</p>
		</form>
	<?php
	} else {
	?>
		<div class="alert alert-danger text-center" role="alert">
			<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
			<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
			<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
		</div>
	<?php
	}
	?>

</div>