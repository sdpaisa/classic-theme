<?php
/*
Plugin Name: Frontend login Client API
Plugin URI: daniuribe.com
Description: <Descripción breve del plugin y sus funcionalidades>
Version:<Versión del plugin>
Author: Daniel Uribe
Author URI:daniuribe.com
License:<Licencia con la que se distribuye el plugin. La más frecuente es GPL>
Text domain: <nombre-del-plugin (para agrupar los textos traducibles del plugin)>
*/


define("PLZ_PATH", plugin_dir_path(__File__));


//API REST
require_once PLZ_PATH . "/includes/API/api-registro.php";
require_once PLZ_PATH . "/includes/API/api-login.php";

//Shortcodes
require_once PLZ_PATH . "/public/shortcode/form-registro.php";
require_once PLZ_PATH . "/public/shortcode/form-login.php";


function plz_plugin_activar()
{
  //read_post es el permiso básico (Leer documentación)
  add_role('cliente', "cliente", "read_post");
}

function plz_plugin_desactivar()
{
  remove_role('cliente');
}

register_activation_hook(__FILE__, "plz_plugin_activar");
register_deactivation_hook(__FILE__, "plz_plugin_desactivar");



// tabla para ver los clientes
// tabla para ver los clientes
// tabla para ver los clientes
// tabla para ver los clientes

//  ESTOS ESTILOS FUNCIONAN DESDE EL THEMA
//  ESTOS ESTILOS FUNCIONAN DESDE EL THEMA
//  ESTOS ESTILOS FUNCIONAN DESDE EL THEMA
function enqueue_custom_admin_styles()
{
  wp_enqueue_style('sd-admin-styles', get_template_directory_uri() . '/assets/css/sd-admin-styles.css');
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_styles');
//  ESTOS ESTILOS FUNCIONAN DESDE EL THEMA
//  ESTOS ESTILOS FUNCIONAN DESDE EL THEMA





function tablad_clientes_post_type()
{
  register_post_type('tabla_clientes', [
    'labels' => [
      'name' => __('Clientes'),
      'singular_name' => __('Cliente')
    ],
    'public' => false,
    'show_ui' => false,
  ]);
}
add_action('init', 'tablad_clientes_post_type');

// como menu principal
// function add_tabla_clientes_menu()
// {
//     add_menu_page(
//         __('Tabla de clientes', 'textdomain'),
//         'Clientes',
//         'manage_options',
//         'clientes',
//         'display_tabla_clientes',
//         'dashicons-groups',
//         6
//     );
// }
// add_action('admin_menu', 'add_tabla_clientes_menu');

// Como Submenu de user
function add_tabla_clientes_menu()
{
  add_submenu_page(
    'users.php',
    'Clientes',
    'Clientes',
    'manage_options',
    'tabla_clientes',
    'display_tabla_clientes'
  );
}
add_action('admin_menu', 'add_tabla_clientes_menu');




// Tabla de clientes
function display_tabla_clientes()
{
  $role = 'cliente';

  $args = array(
    'role' => $role,
  );

  $users = get_users($args);

  if (!empty($users)) {
    echo '<div class="wrap daniel_table">';
    // echo '<h1>Clientes: ' . $role . '</h1>';
    echo '<h1 class="wp-heading-inline" >Clientes</h1>';
    echo '<a href="' . esc_url(admin_url('user-new.php?role=cliente')) . '" class="page-title-action">Agregar Nuevo Cliente</a>';
    echo '<hr class="wp-header-end">';
    echo '<table class="wp-list-table widefat fixed striped table-view-list users">';

    echo '<thead>';
    echo '<tr>';
    echo '<th class="manage-column column-name" >Cliente</th>';
    echo '<th class="manage-column column-email" >Email</th>';
    echo '<th class="manage-column column-role" >Role</th>';
    echo '</tr>';
    echo '</thead>';

    echo '</tbody>';

    foreach ($users as $user) {
      echo '<tr>';
      echo '<td><a href="' . esc_url(get_edit_user_link($user->ID)) . '">' . esc_html($user->display_name) . '</a></td>';

      echo '<td>' . $user->user_email . '</td>';
      echo '<td>' . $user->roles[0] . '</td>';
      echo '</tr>';
    }
    echo '</tbody>';



    echo '</table>';
    echo '</div>';
  } else {
    echo 'No se encontraron clientes ' . $role;
  }
}
