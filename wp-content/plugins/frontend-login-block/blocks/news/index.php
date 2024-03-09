<?php

function sd_news_render_callback($block_attributes, $block_content)
{

  // verificando las clases de mi bloque
  $block_classes = isset($block_attributes['className'])
    ? $block_attributes['className'] . 'wp-block-sd-news'
    : 'wp-block-sd-news';


  // usnado un query de post
  $args = array(
    'posts_per_page' => -1, // cuantos pos quiero ver de la categoria que sel (-1 TODOS)
  );

  // mostrat solo los de la categoria
  if (isset($block_attributes['category'])) {
    $args['category'] = $block_attributes['category'];
  }

  // haciendo el query
  $news   = get_posts($args);
  $render = '';

  // si hay alguna novedad
  // .= concatena
  if (0 < count($news)) {
    $render     .= '<div class="' . esc_attr($block_classes) . '">';
    $render .= '<h3>Quizás te interese leer esto:</h3>';
    $render .= '<ul className="posts">';

    // lo que hicimps en js con map aca es con foreach
    foreach ($news as $new) {
      $render     .= '<li>';
      $render .= "<a href=\"{$new->guid}\">";
      $render .= "{$new->post_title}";
      $render .= '</a>';
      $render     .= '</li>';
    }
    $render .= '</ul>';
    $render     .= '</div>';
  }

  return $render;
}

add_action('init', 'sd_news_block_init');
function sd_news_block_init()
{
  register_block_type(
    __DIR__,
    array(
      'render_callback' => 'sd_news_render_callback',
    )
  );
}
