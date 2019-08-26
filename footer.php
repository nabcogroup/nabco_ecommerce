<?php
/**
 * Footer
 * The template for displaying the footer
 *
 */

?>

<?php if(!is_front_page()) : ?> 
  </div> <!-- closing container -->
<?php endif ?>

</main>



<!-- footer -->
<footer id="footer-full" class="footer-wrapper">
  <?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ) ?>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 nb-footer-text-wrapper">
          <small class="text-light align-middle p-0 m-0">&copy; All Rights Reserved 2018</small>
        </div>
        <div class="col-md-6 col-sm-12">
          <?php echo nabcofurnitures_do_shortcode('bizpack-social-link',array()); ?>
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
  * @hooked: nabco_furniture_pre_loading_script - 10
  * @hooked: nabco_furniture_youtube_script - 20
  ************************************/
  do_action('nabco_furniture_after_content'); 

  
?>

</body>
</html>