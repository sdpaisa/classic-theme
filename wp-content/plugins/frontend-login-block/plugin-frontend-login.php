<?php

/**
 * Plugin Name:       Frontend login Blocks 
 * Plugin URI:        https://github.com/ramitaenlarma
 * Description:       Formularios de login y registro
 * Version:           1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Daniel Uribe
 * Author URI:        https://daniuribe.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       classic-theme
 */

define("SD_PATH", plugin_dir_path(__FILE__));

//API REST
require_once SD_PATH . "/includes/API/api-registro.php";
require_once SD_PATH . "/includes/API/api-login.php";

//Shortcodes
require_once SD_PATH . "/public/shortcode/form-registro.php";
require_once SD_PATH . "/public/shortcode/form-login.php";

//Blocks
require_once SD_PATH . "/blocks/register/index.php";
require_once SD_PATH . "/blocks/news/index.php";
require_once SD_PATH . "/blocks/two_fields/index.php";



function sd_plugin_activar()
{
    add_role('userex', "Userex", "read_post");
}
register_activation_hook(__FILE__, "sd_plugin_activar");

function sd_plugin_desactivar()
{
    remove_role("userex");
}
register_deactivation_hook(__FILE__, "sd_plugin_desactivar");
