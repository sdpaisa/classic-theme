<header>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-3">
        <a href="<?php echo home_url() ?>">
          <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.png" alt="logo">
        </a>
      </div>
      <div class="col-7">
        <nav>
          <?php wp_nav_menu(
            array(
              'theme_location' => 'top_menu',
              'menu_class'    => 'menu-principal',
              'container_class' => 'container-menu',
            )
          );
          ?>
        </nav>
      </div>
      <div class="col-2">




        <?php
        // Verificar si la función existe para evitar errores en caso de cambios en el tema
        if (function_exists('mostrar_boton_login_logout')) {
          mostrar_boton_login_logout();
        }
        ?>




      </div>
    </div>
  </div>
</header>