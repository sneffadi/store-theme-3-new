<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */

get_header(); ?>

<div class="row medium-collapse">
  <div id="content" class="small-24 columns" role="main">

  <?php do_action( 'before_page_content' ); ?>

  <?php while ( have_posts() ) : the_post(); ?>
    
        <article <?php post_class() ?> id="post-<?php the_ID(); ?>">

    <?php if ( is_front_page() ) {  
      do_action( 'homepage_banner' );
    }
      ?>      

            <?php do_action( 'page_before_entry_content' ); ?>      

      <?php the_content(); ?>

            <?php do_action( 'page_after_entry_content'); ?>


    </article>
  
    <?php endwhile;?>

  <?php do_action( 'after_page_content' ); ?>
  </div><!--/.columns-->
</div><!--/.row-->
<?php get_footer(); ?>