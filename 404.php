<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package nabcofurn_us
 */

get_header();

?>

<section class="error-404 not-found">
	<header class="page-header my-3">
		<h1 class="page-title text-center"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'nabco-furnitures' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content my-3">
		<p class="text-center"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'nabco-furnitures' ); ?></p>
	</div><!-- .page-content -->
</section><!-- .error-404 -->

<?php
get_footer();
