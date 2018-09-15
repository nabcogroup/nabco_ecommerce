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
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				z-index: 1000;
			}
	
			#nb-loader {
				display: block;
				position: relative;
				left: 50%;
				top: 50%;
				width: 150px;
				height: 150px;
				margin: -75px 0 0 -75px;
				border-radius: 50%;
				border: 3px solid transparent;
				border-top-color: #3498db;
	
				-webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
				animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
			}
			#nb-loader:before {
				content: "";
				position: absolute;
				top: 5px;
				left: 5px;
				right: 5px;
				bottom: 5px;
				border-radius: 50%;
				border: 3px solid transparent;
				border-top-color: #e74c3c;
	
				-webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
				animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
		}
	
		#nb-loader:after {
			content: "";
			position: absolute;
			top: 15px;
			left: 15px;
			right: 15px;
			bottom: 15px;
			border-radius: 50%;
			border: 3px solid transparent;
			border-top-color: #f9c922;
	
			-webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
			  animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
		}
	
	
			
		#nb-loader-wrapper .nb-loader-section {
			position: fixed;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			top: 0;
			width: 51%;
			height: 100%;
			background: #f5f5f5;
			z-index: 1000;
		}
	
		#nb-loader-wrapper .nb-loader-section.section-left {left: 0;}
		#nb-loader-wrapper .nb-loader-section.section-right {right: 0;}
		#nb-loader {
			z-index: 1001; /* anything higher than z-index: 1000 of .loader-section */
		}	
	
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-left,
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-right {
			display:none;
		}
	
	
		.nb-loaded #nb-loader {
			opacity: 0;
			-webkit-transition: all 0.3s ease-out; 
			transition: all 0.3s ease-out;
		}
	
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-right,
		.nb-loaded #nb-loader-wrapper .nb-loader-section.section-left {
			-webkit-transition: all 0.3s 0.3s ease-out; 
			transition: all 0.3s 0.3s ease-out;
		}
	
		.nb-loaded #nb-loader-wrapper {
			visibility: hidden;
		}
	
		.#nb-loader-wrapper .nb-loader-section.section-right,
		.#nb-loader-wrapper .nb-loader-section.section-left {
			-webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000); 
			transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
		}
	
		.nb-loaded #nb-loader-wrapper {
			-webkit-transform: translateY(-100%);
			-ms-transform: translateY(-100%);
			transform: translateY(-100%);
	
			-webkit-transition: all 0.3s 1s ease-out; 
			transition: all 0.3s 1s ease-out;
		}
	
	</style>
	<?php
}

function nabcofurnitures_pre_loading() {
	if(is_customize_preview()) { return false; }
    ?>
    
        <div id="nb-loader-wrapper">
            <div id="nb-loader"></div>
            <div class="nb-loader-section section-left"></div>
            <div class="nb-loader-section section-right"></div>
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
            else {
                $renders['mini'][] =   $attr;
            }
        }   
	}

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
			<?php foreach($renders['mini'] as $render) : ?>
			<div class="col-md-6">
					<a href="<?php echo $render['permalink']; ?>" class="nb-anchor-wrapper">
					<div class='<?php echo implode(' ', $render['class']); ?> card-product-thumbnail wow bounceInUp'>
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
	<div class="col-md-4">
		<div class='<?php echo $renders['side']['class'] ?> card-product-thumbnail wow bounceInRight'>
			<div class="shadow"></div>
			<img src="<?php echo $renders['side']['img']; ?>" class="card-img-top"/>
			<h3 class="card-title"><?php echo $renders['side']['title']; ?></h3>
		</div>
	</div>

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