<?php  

/**
 * The template for displaying category product pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package nabcofurn_us
 */


get_header();

$under_con = get_theme_mod( 'nb_underconstruction', '' )
?>


<article class="container page-wrapper">
<?php if($under_con != 'development') : ?>
    
    <?php if(have_posts()) : ?>
        
        <?php while(have_posts()) : the_post(); ?>
            
            <nav class="nb-page-nav">
                <ul>
                    <li><a href="#"> About Us</a></li>
                    <li><a href="#">Our Commitment</a></li>
                </ul>
            </nav>

            <?php the_title('<h1>','</h1>') ?>

            <div class="body-content">
                <?php the_content(); ?>
            </div>

        <?php endwhile; ?>

    <?php endif; ?>

<?php else : ?>

    <?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>
    
<?php endif ?>
</article>

<?php get_footer(); ?>