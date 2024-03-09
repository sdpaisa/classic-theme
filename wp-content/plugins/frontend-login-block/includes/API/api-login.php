<?php

function sd_api_login()
{
    register_rest_route(
        "sd",
        "login",
        array(
            "methods" => "POST",
            "callback" => "sd_login_callback"
        )
    );
}

add_action("rest_api_init", "sd_api_login");

function sd_login_callback($request)
{
    $cred = array(
        "user_login" => $request["email"],
        "user_password" => $request["password"],
        "remember"  => true
    );

    $user = wp_signon($cred);

    return $user->get_error_message();
}
