<?php
// Add bloque de Gutenberg
// forma 1
// function pgEjemploBlock()
// {
//   $assets_file = include_once SD_PATH . "/blocks/two_fields/build/index.asset.php";



//   wp_register_script(
//     'pg-block',
//     plugins_url('./build/index.js', __FILE__),
//     $assets_file['dependencies'],
//     $assets_file['version'],
//   );

//   register_block_type(
//     'pg/basic',
//     array(
//       'editor_script' => 'pg-block',
//       'render_callback' => 'pgRenderDynamicBlock'
//     )
//   );
// }
// function pgRenderDynamicBlock($attributes, $content)
// {
//   return '<h2>' . $attributes['content'] . '</h2>';
// }
// add_action('init', 'pgEjemploBlock');


// forma 2
function sd_recetas_block()
{
  // Tomamos el archivo PHP generado en el Build
  // $assets = include_once get_template_directory() . '/blocks/build/index.asset.php';
  $assets_file = include_once SD_PATH . "/blocks/two_fields/build/index.asset.php";

  wp_register_script(
    'recetas-block', // Handle del Script
    plugins_url('./build/index.js', __FILE__), // Usamos 
    $assets_file['dependencies'], // Array de dependencias generado en el Build
    $assets_file['version'], // Cada Build cambia la versión para no tener conflictos de caché
  );

  register_block_type(
    'recetas/basic', // Nombre del bloque
    array(
      'editor_script' => 'recetas-block', // Handler del Script que registramos arriba
      'attributes'      => array( // Repetimos los atributos del bloque, pero cambiamos los objetos por arrays
        'content' => array(
          'type'    => 'string',
          'default' => '00 min'
        ),
        'content2' => array(
          'type'    => 'string',
          'default' => '0-0 Personas'
        )
      ),
      'render_callback' => 'sd_recetas_block_dynamic' // Función de callback para generar el SSR (Server Side Render)
    )
  );
}

function sd_recetas_block_dynamic($attributes)
{
  return '<div class="icn_time"><i></i>' . $attributes['content'] . ' / ' . $attributes['content2'] . '</div>';
}

// Asignación de la función de registro del bloque al Hook "init"
add_action('init', 'sd_recetas_block');
