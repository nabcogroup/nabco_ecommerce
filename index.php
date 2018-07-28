<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','')
?>

<?php if($under_con == 'development') : ?>

    <?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>
<?php endif; ?>

<?php get_footer(); ?>