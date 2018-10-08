<?php



/***
Product Navigation to get product
@Param: $args parameter  
**/
function nabcofurnitures_product_navigations($args) {
	$theProducts = new WP_Query($args);
	$productArgs = [];

	if($theProducts->have_posts()) {
		while($theProducts->have_posts()) {
			$theProducts->the_post();
			$productArg = array(
				'permalink' =>  get_the_permalink(),
				'title'     =>  get_the_title()
			);
			array_push($productArgs,$productArg);   //get the product information
		}
	}

	wp_reset_postdata();

	return $productArgs;
}

function nabcofurnitures_slider_scripts() {
	if(!is_front_page()) return;

?>
	<script>
		jQuery(document).ready(function($) {
			console.log('mini-slider');
			var frontView = $(".front-view");
			frontView.find(".owl-carousel").owlCarousel({
				dots: true,
				responsive: {
					1024: {items:4,},
					768: {items: 2,},
					0: {items: 1}
				}
			});
		});
	</script>
<?php
}

function nabcofurnitures_pre_loading_scripts() {
	if(is_customize_preview()) { return false; }
	?>
		<script>
			jQuery(document).ready(function($) {
				setTimeout(function(){
					$('body').addClass('nb-loaded');
				}, 150);
			})
		</script>
	<?php 	
}

function nabcofurnitures_pre_loading_style() {
	
	if(is_customize_preview()) { return false; }

	?>
	<style>
			#nb-loader-wrapper {
				position: fixed;
				width: 100%;
				height: 100%;
				z-index: 99999999;
				display: block;
				background: #ccc;
			}

			.nb-loaded #nb-loader-wrapper {
				display:none !important;

			}

			#nb-loader {
				width: 100%;
				width: 100%;
				height: 100%;
				background: #ccc;
			}
	
	</style>
	<?php
}

function nabcofurnitures_pre_loading() {
	if(is_customize_preview()) { return false; }
    ?>
    
        <div id="nb-loader-wrapper">
            <div id="nb-loader"></div>
        </div>
    <?php
}


function nabcofurnitures_collection_navigation() {

	$nbMainNavigation = Nab_MainNavigation::createInstance(array('location' => 'collection')); 
	$renders = array();
    if($nbMainNavigation->haveItems()) {
        foreach($nbMainNavigation->items as $item) {
			$classes = $item->classes;
			$thumbnail_id = get_woocommerce_term_meta($item->object_id,'thumbnail_id',true); 
            $img_src = wp_get_attachment_image_src( $thumbnail_id,'full' );
			
			$attr = array(
                'img' => $img_src[0],
                'class' => implode(' ',$classes), 
                'title' => $item->title,
                'permalink' => $item->url);
            
            if(in_array('collection_top', $classes)) {
                $renders['top'] = $attr;
            }
            else if(in_array('collection_side',$classes)) {
                $renders['side'] = $attr;
			}
			else if(in_array('collection_top_mini', $classes)) {
                $renders['mini_top'][] =   $attr;
            }
			else if(in_array('collection_footer',$classes)) {

			}
            else {
                $renders['mini'][] =   $attr;
            }
        }   
	}

	$nbMainNavigation = null;

	?>

	<div class="col-md-8">
		<div class="row">
			<div class="col-md-12">
				<a href="<?php echo $renders['top']['permalink']; ?>" class="nb-anchor-wrapper">
					<div class='<?php echo $renders['top']['class'] ?> card-product-thumbnail wow bounceInUp'>
						<div class="shadow"></div>
						<img src="<?php echo $renders['top']['img']; ?>" class="card-img-top"/>
						<h3 class="card-title"><?php echo $renders['top']['title']; ?></h3>
					</div>
				</a>
			</div>
			<?php foreach($renders['mini_top'] as $render) : ?>
			<div class="col-md-6  mb-3">
					<a href="<?php echo $render['permalink']; ?>" class="nb-anchor-wrapper">
					<div class='<?php  echo   $render['class']; ?> card-product-thumbnail wow bounceInUp'>
						<div class="shadow"></div>
						<img src="<?php echo $render['img']; ?>" class="card-img-top"/>
						<h3 class="card-title"><?php echo $render['title']; ?></h3>
					</div>
					</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- side -->
	<div class="col-md-4 mb-3">
		<a href="<?php echo $renders['side']['permalink']; ?>" class="nb-anchor-wrapper">
		<div class='<?php echo $renders['side']['class'] ?> card-product-thumbnail wow bounceInRight'>
			<div class="shadow"></div>
			<img src="<?php echo $renders['side']['img']; ?>" class="card-img-top"/>
			<h3 class="card-title"><?php echo $renders['side']['title']; ?></h3>
		</div>
		</a>
	</div>
	<!-- bottom -->
	<?php if(isset($renders['mini'])) : ?>
	<div class="col-md-12">
		<div class="row">
			<?php foreach($renders['mini'] as $render) : ?>
				<div class="col-md-4 mb-3">
					<a href="<?php echo $render['permalink']; ?>" class="nb-anchor-wrapper">
					<div class='<?php  echo   $render['class']; ?> card-product-thumbnail wow bounceInUp'>
						<div class="shadow"></div>
						<img src="<?php echo $render['img']; ?>" class="card-img-top"/>
						<h3 class="card-title"><?php echo $render['title']; ?></h3>
					</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

	<?php
}




class Nab_ThemeFunction {

    public function __construct() {

        add_action( 'wp_head', array($this,'pingbackHeader') );
        add_filter( 'body_class', array($this,'bodyClasses') );

    }

    /**
    * Adds custom classes to the array of body classes.
    *
    * @param array $classes Classes for the body element.
    * @return array
    */
    public function bodyClasses( $classes ) {
        // Adds a class of hfeed to non-singular pages.
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }

        // Adds a class of no-sidebar when there is no sidebar present.
        if ( ! is_active_sidebar( 'sidebar-1' ) ) {
            $classes[] = 'no-sidebar';
        }

        return $classes;
    }

    
    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     */
    public function pingbackHeader() {
        if ( is_singular() && pings_open() ) {
            echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
        }
    }




}

return new Nab_ThemeFunction();