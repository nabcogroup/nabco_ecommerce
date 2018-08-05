<?php  

/**
 * Template Name: Nabco Sub Page
 *
 * Template for displaying a sub page if page consist of subpage.
 *
 * @package understrap
 */



get_header();

$under_con = get_theme_mod( 'nb_underconstruction', '' );

?>


<?php if($under_con != 'development') : ?>

<article class="container page-wrapper">

    <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            
            <nav class="nb-page-nav">
                <?php echo nabco_furniture_list_child_pages(); ?>
            </nav>

            <?php the_title('<h1>','</h1>') ?>

            <div class="body-content">
                <?php the_content(); ?>
            </div>

        <?php endwhile; ?>
    <?php endif; ?>
</article>
<?php else : ?>
    <?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>
<?php endif ?>

<?php get_footer(); ?>