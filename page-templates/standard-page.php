<?php  

/**
 * Template Name: Nabco Standard Page
 *
 * Template for displaying a standard page.
 *
 * @package understrap
 */



get_header();

$under_con = get_theme_mod( 'nb_underconstruction', '' );

?>

<article class="page-wrapper">
    <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <div class="body-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</article>
<?php get_footer(); ?>