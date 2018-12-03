<?php  

/**
 * Template Name: Nabco Sub Page
 *
 * Template for displaying a sub page if page consist of subpage.
 *
 * @package understrap
 */



get_header();

$page_sidebar = get_theme_mod('nabcofurniture_theme_page_layout', '' );

?>

<!-- Section: Page Header -->
<?php if(!is_front_page()) : ?>
<article class="page-wrapper">
	<div class="row">
		<?php if ($page_sidebar == 'sidebar') : ?>
			<div class="col-md-9">
		<?php else : ?>
			<div class="col-md-12">
		<?php endif; ?>
		
		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
				
				<div class="row">
					<!-- post child page -->
					<nav class="nb-page-nav col-md-6 ml-auto">
						<?php 
							echo nabcofurniture_list_child_pages(); 
						?>
					</nav>
				</div>

				<div class="row">
					<div class="col-md-12">
						<?php the_title('<h1 class="entry-title blog-post-title to-upper">','</h1>') ?>
					</div>
				</div>
				
				<div class="row">
					<div class="body-content col-md-12">
						<?php if(get_option('wc_disabled_shop_cart','yes') == 'yes') : ?>
							<?php if(is_page('cart') || is_page('my-account')) :?>
								<?php echo apply_filters('nabcofurniture_page_disabled', '<p class="woocommerce-info">This page is disabled</p>' ) ?>
							<?php else : ?>
								<?php the_content(); ?>
							<?php endif; ?>
						<?php else : ?>
							<?php the_content(); ?>
						<?php endif; ?>	
					</div>
				</div>

			<?php endwhile; ?>
		</div>
		<?php endif; ?>

		<?php //enable sidebar ?>		
		<?php if ($page_sidebar == 'sidebar') : ?>
			<div class="col-md-3">
				<?php  get_sidebar(); ?>
			</div>
		<?php endif; ?>
	</div>
</article>
<?php endif; ?>
<?php get_footer(); ?>