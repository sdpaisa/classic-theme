<?php
function sd_register_blocks()
{
  $assets_file = include_once SD_PATH . "/blocks/register/build/index.asset.php";

  wp_register_script(
    'sd-register-block',
    plugins_url('./build/index.js', __FILE__),
    $assets_file['dependencies'],
    $assets_file['version']
  );

  wp_register_style(
    'sd-register-block',
    plugins_url('./build/index.css', __FILE__),
    array(),
    $assets_file['version']
  );

  register_block_type(
    'sd/register',
    array(
      'editor_script' => 'sd-register-block',
      'script'        => 'sd-registro',
      'style' => 'sd-register-block',
    )
  );
}
add_action('init', 'sd_register_blocks');
