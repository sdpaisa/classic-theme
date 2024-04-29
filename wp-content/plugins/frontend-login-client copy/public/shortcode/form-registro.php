<?php

//Registrar script
function plz_script_registro()
{

  if (has_shortcode(get_post()->post_content, 'plz_registro')) {   // solo carga este script donde se usa el shortcode


    wp_register_script("plz-registro", plugins_url("../assets/js/registro.js", __FILE__));
    wp_enqueue_script("plz-registro");

    wp_localize_script("plz-registro", "plz", array(
      "rest_url" => rest_url("plz"),
    ));
  }
}

add_action("wp_enqueue_scripts", "plz_script_registro");

function plz_add_register_form()
{
  wp_enqueue_script("plz-registro");
  $response = '
    <div class="signin">
        <div class="signin__container col-12 col-md-8 col-lg-6 col-xl-5">

        <div class="card shadow-2-strong" style="border-radius: 1rem;">
        <div class="card-body p-5 ">

            <h3 class="sigin__titulo">Registro clientes</h3>
            <form class="signin__form" id="signup">
                <div class="signin__name name--campo form-group">
                    <label for="Name" >Name</label>
                    <input class="form-control" name="name" type="text" id="Name">
                </div>
                <div class="signin__email name--campo form-group">
                    <label for="email">Email</label>
                    <input class="form-control" name="email" type="email" id="email">
                </div>
                <div class="signin__pass name--campo form-group">
                    <label for="password">Password</label>
                    <input class="form-control" name="password" type="password" id="password">
                </div>
                <div class="signin__submit mt-2">
                    <input class="btn btn-primary" type="submit" value="Create">
                </div>
                <div class="signin_create-link mt-2">
                    <a href="' . home_url("sing-in") . '">Ya esta registrado?</a>
                </div>
                <div class="msg"></div>
            </form>
        </div>
        </div>
        </div>
    </div>
    ';

  return $response;
}

add_shortcode("plz_registro", "plz_add_register_form");
