<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nabcofurn_us
 */

?>
  </main>

<!-- footer -->
<footer id="footer-full" class="footer-wrapper">
  
  <?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ) ?>

  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 nb-footer-text-wrapper">
          <small class="nb-text-white align-middle p-0 m-0">&copy; All Rights Reserved 2018</small>
        </div>
        <div class="col-md-6 col-sm-12">
          <?php get_template_part( 'template-parts/content', 'socialicon' ) ?>
        </div>
      </div>
    </div>
  </div>
	
 </footer>
 <!-- ADDITIONAL JS HERE -->
 <?php wp_footer(); ?>

  <?php 

  /************** 
  * Hook: nabco_furniture_after_content
  * 
  * @hooked: nabco_furniture_pre_loading_script - 10
  * @hooked: nabco_furniture_youtube_script - 20
  */

  do_action('nabco_furniture_after_content'); 
?>
</body>

</html>
