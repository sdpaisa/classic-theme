<?php

function plz_script_login()
{
  wp_register_script("plz-login", plugins_url("../assets/js/login.js", __FILE__));
  wp_enqueue_script("plz-login");

  //esta parte crea una variable con la ubicacion de la api rest buscada por el navegador
  // al handle plz-login creado atrás, se le creará una variable (o se modificará supongo)
  // llamada plz  y el valor de esa variable es el array (y el array regresa la URL de la apirest plz)
  wp_localize_script("plz-login", "plz", array(
    "rest_url" => rest_url("plz"),
    "home_url" => home_url(),
  ));
}

add_action("wp_enqueue_scripts", "plz_script_login");

function plz_add_login_form()
{
  wp_enqueue_script("plz-login");
  $response = '
    <div class="signin">
        <div class="signin__container col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
        <div class="card-body p-5 ">

            <form class="signin__form" id="signin">
                <div class="signin__email name--campo form-group">
                    <label for="email">Email address</label>
                    <input class="form-control" name="email" type="email" id="email">
                </div>
                <div class="signin__pass name--campo form-group">
                    <label for="password">Password</label>
                    <input class="form-control" name="password" type="password" id="password">
                </div>
                <div class="signin__submit">
                    <input class="btn btn-primary mt-2" type="submit" value="Log in">
                </div>
                <div class="signin_create-link mt-2">
                    <a href="' . home_url("sing-up") . '">Sign up</a>
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

add_shortcode("plz_login", "plz_add_login_form");
