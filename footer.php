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
        <div class="col-md-6 col-sm-12">
          <p class="align-middle p-0 m-0">&copy; All Rights Reserved 2018</p>
        </div>
      </div>
    </div>
  </div>
	
 </footer>
 <!-- ADDITIONAL JS HERE -->
 <?php wp_footer(); ?>

</body>

</html>
