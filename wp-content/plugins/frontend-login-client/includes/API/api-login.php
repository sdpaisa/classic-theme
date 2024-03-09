<?php

function plz_api_login()
{
  register_rest_route(
    "plz",
    "login",
    array(
      "methods" => "POST",
      "callback" => "plz_login_callback"
    )
  );
}


// function plz_login_callback($request)
// {
//   $cred = array(
//     "user_login" => $request["email"],
//     "user_password" => $request["password"],
//     "remember"  => true
//   );

//   $user = wp_signon($cred);

//   if ($user->get_error_code()) {
//     return array("msg" => "error revisa email o contraseña");
//   } else {
//     return array("msg" => "Login Exitoso");
//   }

//   // return $user->get_error_message();
// }


function plz_login_callback($request)
{
  $parameters = $request->get_params();

  // Validar los campos requeridos
  if (empty($parameters['email']) || empty($parameters['password'])) {
    return new WP_Error('missing_fields', 'Por favor, proporciona un email y una contraseña.', array('status' => 400));
  }

  // Sanear datos
  $email = sanitize_email($parameters['email']);
  $password = sanitize_text_field($parameters['password']);

  // Intentar iniciar sesión
  $user = wp_authenticate($email, $password);

  if (is_wp_error($user)) {
    return new WP_Error('login_error', 'Email o contraseña incorrectos.', array('status' => 401));
  } else {
    // Inicio de sesión exitoso
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID);
    return array("msg" => "Se ha loggeado correctamente 😎");
  }
}




add_action("rest_api_init", "plz_api_login");
