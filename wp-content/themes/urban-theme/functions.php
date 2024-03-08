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

// Creamon un CPT llamado productos
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