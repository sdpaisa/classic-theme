<?php

function sd_init_template()
{
  add_theme_support('post-thumbnails');
  add_theme_support('title-tag');
  register_nav_menus([
    'top_menu' => 'Menú Principal',
  ]);
}
add_action('after_setup_theme', 'sd_init_template');





// Agremgamos los assets js, css y inicializamos las URL de ajax y API
function sd_assets()
{
  wp_register_style(
    'boostrap',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    '',
    '5.3.3',
    'all'
  );
  wp_register_style(
    'montserrat',
    'https://fonts.googleapis.com/css2?family=Montserrat&display=swap',
    '',
    '1.0',
    'all'
  );

  wp_enqueue_style(
    'estilos',
    get_stylesheet_uri(),
    ['boostrap', 'montserrat'],
    '1.0',
    'all'
  );

  wp_register_script(
    'popper',
    'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js',
    '',
    '2.11.8',
    true
  );
  wp_enqueue_script(
    'boostraps',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js',
    ['jquery', 'popper'],
    '5.3.3',
    true
  );

  wp_enqueue_script(
    'custom',
    get_template_directory_uri() . '/assets/js/custom.js',
    '',
    '1.0',
    true
  );

  wp_localize_script('custom', 'pg', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'apiurl' => home_url('/wp-json/pg/v1/')
  ));
}
add_action('wp_enqueue_scripts', 'sd_assets');





// Registramos el widget para el tema
function sidebar()
{
  register_sidebar([
    'name' => 'Pie de página',
    'id' => 'footer',
    'description' => 'Zona de Widgets para pie de página',
    'before_title' => '<p>',
    'after_title' => '</p>',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
  ]);
}
add_action('widgets_init', 'sidebar');






// Creamos un CPT llamado recetas
function sd_recetas_type()
{
  $labels = [
    'name' => 'Recetas',
    'singular_name' => 'singular_name-receta',
    'manu_name' => 'manu_name-receta',
  ];

  $args = [
    'label' => 'label-recetas',
    'description' => 'Recetas de la pagina',
    'labels' => $labels,
    'supports' => ['title', 'custom-fields', 'editor', 'thumbnail', 'revisions'],
    'public' => true,
    'can_export' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-list-view',
    'taxonomies' => array('categoria-receta'),
    'can_export' => true,
    'publicly_queryable' => true,
    'rewrite' => true,
    'show_in_rest' => true,
    'template' => array( // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-templates/
      array('recetas/basic'),
      array('core/post-title', array(
        'level' => 1
      )),
      array('core/paragraph', array( //https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/post-title/block.json
        'placeholder' => 'Agregar descripcion de la receta....',
        'lock' => array(
          'move'   => true,
          'remove' => true,
        ),
      )),
    ),

  ];
  register_post_type('receta', $args);
}
add_action('init', 'sd_recetas_type');

// Agregar un meta box para los campos personalizados de recetas
function add_custom_fields_meta_box()
{
  add_meta_box(
    'custom_fields_meta_box',
    'Campos Personalizados',
    'render_custom_fields_meta_box',
    'receta', // Nombre del CPT
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'add_custom_fields_meta_box');


function render_custom_fields_meta_box($post) // Renderizar el contenido del meta box
{ // Aquí puedes agregar tus campos personalizados utilizando funciones como get_post_meta()
  echo '<label for="custom_field">Campo Personalizado:</label>';
  echo '<input type="text" id="custom_field" name="custom_field" value="' . get_post_meta($post->ID, 'custom_field', true) . '" />';
}

function save_custom_fields_data($post_id) // Guardar los datos de los campos personalizados
{
  if (isset($_POST['custom_field'])) {
    update_post_meta($post_id, 'custom_field', sanitize_text_field($_POST['custom_field']));
  }
}
add_action('save_post', 'save_custom_fields_data');


// Agregar nuevo grupo taxonomico para recetas
function sd_registrar_taxonomia_categoria_receta()
{
  $labels = array(
    'name'              => 'Categorías de Recetas',
    'singular_name'     => 'Categoría de Receta',
    'menu_name'         => 'Categorías de Recetas',
    'search_items'      => 'Buscar Categorías de Recetas',
    'all_items'         => 'Todas las Categorías de Recetas',
    'edit_item'         => 'Editar Categoría de Receta',
    'update_item'       => 'Actualizar Categoría de Receta',
    'add_new_item'      => 'Agregar Nueva Categoría de Receta',
    'new_item_name'     => 'Nombre de la Nueva Categoría de Receta',
    'parent_item'       => 'Categoría de Receta Padre',
    'parent_item_colon' => 'Categoría de Receta Padre:',
    'not_found'         => 'No se encontraron categorías de recetas',
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'public'            => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array('slug' => 'categoria-receta'),
  );

  register_taxonomy('categoria-receta', 'receta', $args); // Registrar la taxonomía

  $default_category = 'Receta'; // Insertar la categoría por defecto
  $term_exists = term_exists($default_category, 'categoria-receta'); // Insertar la categoría por defecto

  if (!$term_exists) { // Insertar la categoría por defecto
    wp_insert_term($default_category, 'categoria-receta');
  }
}
add_action('init', 'sd_registrar_taxonomia_categoria_receta');

// GUARDAMOS categoria llamada RECETA cada vez que guardamos los post
function asignar_categoria_por_defecto_a_recetas($post_id)
{

  if ('receta' === get_post_type($post_id)) { // Verificar si el post es del tipo 'receta'
    if (!has_term('', 'categoria-receta', $post_id)) { // Verificar si el post no tiene ninguna categoría asignada
      $uncategorized_term = get_term_by('slug', 'receta', 'categoria-receta'); // Obtener el ID de la categoría 'Uncategorized'
      if ($uncategorized_term) { // Si se encuentra la categoría 'Uncategorized', asignarla al post
        wp_set_post_terms($post_id, array($uncategorized_term->term_id), 'categoria-receta');
      }
    }
  }
  // print_r('--------------------------> ' . $post_id);
}
add_action('save_post', 'asignar_categoria_por_defecto_a_recetas');







// Creamos un CPT llamado productos
function productos_type()
{
  $labels = [
    'name' => 'Productos',
    'singular_name' => 'Producto',
    'manu_name' => 'Productos',
  ];

  $args = [
    'label' => 'Productos',
    'description' => 'Productos de Platzi',
    'labels' => $labels,
    'supports' => ['title', 'editor', 'thumbnail', 'revisions'],
    'public' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'menu_icon' => 'dashicons-cart',
    'can_export' => true,
    'publicly_queryable' => true,
    'rewrite' => true,
    'show_in_rest' => true,
  ];
  register_post_type('producto', $args);
}
add_action('init', 'productos_type');

// Agregar nuevo grupo taxonomico para productos
function pgRegisterTax()
{
  $args = [
    'hierarchical' => true,
    'labels' => [
      'name' => 'Categorías de productos',
      'singular_name' => 'Categoría de Producto'
    ],
    'show_in_nav_menu' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'categoria-productos']
  ];

  register_taxonomy('categoria-productos', array('producto'));
  register_taxonomy('categoria-productos', array('producto'), $args);
  register_taxonomy('categoria-producto', ['producto'], $args);
}

add_action('init', 'pgRegisterTax');


// filtro de productos para el home por AJAX
function filtroProductos()
{
  $args = array(
    'post_type' => 'producto',
    'posts_per_page' => -1,
    'order'     => 'ASC',
    'orderby' => 'title',
    'tax_query' => array(
      array(
        'taxonomy' => 'categoria-productos',
        'field' => 'slug',
        'terms' => $_POST['categoria']
      )
    )
  );
  $productos = new WP_Query($args);

  $return = array();
  if ($productos->have_posts()) {
    while ($productos->have_posts()) {
      $productos->the_post();
      $return[] = array(
        'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
        'link' => get_permalink(),
        'titulo' => get_the_title()
      );
    }
  }

  wp_send_json($return);
}
add_action('wp_ajax_nopriv_filtroProductos', 'filtroProductos');
add_action('wp_ajax_filtroProductos', 'filtroProductos');


// Novedades por API
function novedadesAPI()
{
  register_rest_route(
    'pg/v1',
    '/novedades/(?P<cantidad>\d+)',
    array(
      'methods' => 'GET',
      'callback' => 'pedirNovedades',
    )
  );
}

function pedirNovedades($data)
{
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => $data['cantidad'],
    'order'     => 'ASC',
    'orderby' => 'title',
  );
  $novedades = new WP_Query($args);

  if ($novedades->have_posts()) {
    while ($novedades->have_posts()) {
      $novedades->the_post();
      $return[] = array(
        'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
        'link' => get_permalink(),
        'titulo' => get_the_title()
      );
    }
  }
  return $return;
}
add_action('rest_api_init', 'novedadesAPI');

// Add bloque de Gutenberg

// // FORMA 1
// function pgRegisterBlock()
// {
//   $assets = include_once get_template_directory() . '/blocks/build/index.asset.php';

//   wp_register_script(
//     'pg-block',
//     get_template_directory_uri() . '/blocks/build/index.js',
//     $assets['dependencies'],
//     $assets['version'],
//   );

//   register_block_type(
//     'pg/basic',
//     array(
//       'editor_script' => 'pg-block',
//       'render_callback' => 'pgRenderDynamicBlock'
//     )
//   );
// }
// add_action('init', 'pgRegisterBlock');

// FORMA 2
function pgRegisterBlock()
{
  // Tomamos el archivo PHP generado en el Build
  $assets = include_once get_template_directory() . '/blocks/simple/build/index.asset.php';

  wp_register_script(
    'pg-block', // Handle del Script
    get_template_directory_uri() . '/blocks/simple/build/index.js', // Usamos get_template_directory_uri() para recibir la URL del directorio y no el Path
    $assets['dependencies'], // Array de dependencias generado en el Build
    $assets['version'] // Cada Build cambia la versión para no tener conflictos de caché
  );

  register_block_type(
    'pg/basic', // Nombre del bloque
    array(
      'editor_script' => 'pg-block', // Handler del Script que registramos arriba
      'attributes'      => array( // Repetimos los atributos del bloque, pero cambiamos los objetos por arrays
        'content' => array(
          'type'    => 'string',
          'default' => 'Hello world'
        )
      ),
      'render_callback' => 'pgRenderDinamycBlock' // Función de callback para generar el SSR (Server Side Render)
    )
  );
}
function pgRenderDinamycBlock($attributes, $content) // Función de callback para generar el bloque dinamico
{
  return '<h3>' . $attributes['content'] . '</h3>';
}
add_action('init', 'pgRegisterBlock'); // Asignación de la función de registro del bloque al Hook "init"









// verificar si estoy logeado
// verificar si estoy logeado

// function plz_add_to_signin_menu()
// {
//   $current_user = wp_get_current_user();
//   $msg = is_user_logged_in() ? $current_user->user_email : "Sign in";
//   echo $msg;
// }
// add_action("plz_signin", "plz_add_to_signin_menu");


function mostrar_boton_login_logout()
{

  $current_user = wp_get_current_user();
  $msg = is_user_logged_in() ? $current_user->user_email : "Sign in";

  $redirect_url = home_url('sing-up'); // URL a la que quieres redirigir al usuario después de cerrar sesión

  $logout_url = wp_logout_url($redirect_url); // Generar la URL de cierre de sesión con el parámetro redirect


  if (is_user_logged_in()) {
    // Usuario logueado
    // echo '<a href="' . wp_logout_url() . '" class="boton-logout">Cerrar sesión</a>';
    // echo '<p>' . $msg . '<br>' . '<a href="' . home_url('sing-up') . '" class="">Cerrar sesión</a></p>';

    echo '<p>' . $msg . '<br>' . '<a href="' . esc_url($logout_url) . '" class="">Cerrar sesión</a></p>';
  } else {
    // Usuario no logueado
    echo '<a href="' . home_url('sing-in') . '" class="">Iniciar sesión</a>';
  }
}

// add_action('wp_footer', 'mostrar_boton_login_logout');
// add_action('plz_signin', 'mostrar_boton_login_logout');
