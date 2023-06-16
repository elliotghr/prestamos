<nav class="full-box navbar-info">
    <a href="#" class="float-left show-nav-lateral">
        <i class="fas fa-exchange-alt"></i>
    </a>
    <!-- Configuramos la URL para acceder a los datos de la cuenta -->
    <a href="<?php echo SERVERURL . "user-update/" . $instancia_login->encryption($_SESSION["id_spm"]) . "/" ?>">
        <i class="fas fa-user-cog"></i>
    </a>
    <a href="#" class="btn-exit-system">
        <i class="fas fa-power-off"></i>
    </a>
</nav>