<?php
get_header();
$custom_field_value = get_post_meta(get_the_ID(), 'custom_field', true);
?>
<h6>TEMPLATE RECETA</h6>



<main class='container my-3'>
  <?php if (have_posts()) {
    while (have_posts()) {
      the_post();
  ?>

      <p class='my-3'>Se renderiza si o si el campo personalizado: <strong> <?php echo $custom_field_value ?></strong></p>
      <?php
      if (!empty($custom_field_value)) { // Verificar si el campo personalizado tiene contenido
        echo '<p>Contenido del campo personalizado: <strong>' . $custom_field_value . '</strong></p>';  // Mostrar el contenido del campo personalizado
      } else {
        echo '<p>Este campo personalizado está vacío.</p>';  // Mostrar un mensaje si el campo personalizado está vacío
      }
      ?>



      <h1 class='my-5'><?php the_title() ?></h1>
      <div class="row">
        <div class="col-12">
          <?php the_content(); ?>
          <?php the_post_thumbnail('large'); ?>
        </div>
      </div>

      <?php get_template_part('template-parts/post', 'navigation') ?>

  <?php
    }
  } ?>

</main>
<?php get_footer(); ?>