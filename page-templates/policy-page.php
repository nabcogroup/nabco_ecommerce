<?php
/**
 * Template Name: Policy Page
 *
 * Template for displaying a policy page.
 *
 * @package understrap
 */
get_header();
?>


<article class="page-wrapper">
    <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <?php  the_title('<h1 class="nb-text-title to-upper">','</h1>'); ?>
            <div class="body-content white-wrap">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</article>

<?php get_footer(); ?>