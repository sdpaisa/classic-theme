<?php

function sd_script_login()
{
    wp_register_script("sd-login", plugins_url("../assets/js/login.js", __FILE__));
    wp_localize_script("sd-login", "sd", array(
        "rest_url" => rest_url("sd"),
        "home_url" => home_url()
    ));
}

add_action("wp_enqueue_scripts", "sd_script_login");

function sd_add_login_form()
{
    wp_enqueue_script("sd-login");
    $response = '
    <main class="signin">
        <div class="signin__container">
            <form class="signin__form" id="signin">
                <div class="signin__email name--campo">
                    <label for="email">Email address</label>
                    <input name="email" type="email" id="email">
                </div>
                <div class="signin__pass name--campo">
                    <label for="password">Password</label>
                    <input name="password" type="password" id="password">
                </div>
                <div class="signin__submit">
                    <input type="submit" value="Log in">
                </div>
                <div class="signin_create-link">
                    <a href="' . home_url("sign-up") . '">Sign up</a>
                </div>
                <div class="msg"></div>
            </form>
        </div>
    </main>
    ';

    return $response;
}

add_shortcode("sd_login", "sd_add_login_form");
