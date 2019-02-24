<?php

    
$visible = get_theme_mod('nb_prodcol_visible','show');
$title = get_theme_mod('nb_prodcol_title', '');
$bg_color = get_theme_mod('nb_prodcol_bgcolor');
    
    
if($visible == 'hide') return false;

//top link
$top = array(
    'slug' => get_theme_mod('nb_prodcol_toplink',''), 
    'imgsrc' => get_theme_mod('nb_prodcol_topimg','') );

if($top['slug'] != 'none') {
    $category = get_term_by('slug', $top['slug'],'product_cat');
    $top['permalink'] = get_category_link($category);
    $top['name'] = $category->name;
}

//side
$side = array(
    'slug' => get_theme_mod('nb_prodcol_sidelink',''), 
    'imgsrc' => get_theme_mod('nb_prodcol_sideimg','') );
if($side['slug'] != 'none') {
    $category = get_term_by('slug', $side['slug'],'product_cat');
    $side['permalink'] = get_category_link($category);
    $side['name'] = $category->name;
}
    

//footer
$footer = array(
    'slug' => get_theme_mod('nb_prodcol_footerlink',''), 
    'imgsrc' => get_theme_mod('nb_prodcol_footerimg','') );
if($footer['slug'] != 'none') {
    $category = get_term_by('slug', $footer['slug'],'product_cat');
    $footer['permalink'] = get_category_link($category);
    $footer['name'] = $category->name;
}
    

    
//mini thumbnail 1
$mini_thumbnails = array(
    'top_1' =>  array(
                'slug' => get_theme_mod('nb_prodcol_thumb1link',''), 
                'imgsrc' => get_theme_mod('nb_prodcol_thumb1img',''),
    ),
    'top_2' =>  array(
        'slug' => get_theme_mod('nb_prodcol_thumb2link',''), 
        'imgsrc' => get_theme_mod('nb_prodcol_thumb2img',''),
    ),
);


if($mini_thumbnails['top_1']['slug'] != 'none') {
    $category = get_term_by('slug', $mini_thumbnails['top_1']['slug'],'product_cat');
    $mini_thumbnails['top_1']['permalink'] = get_category_link($category);
    $mini_thumbnails['top_1']['name'] = $category->name;
}

if($mini_thumbnails['top_2']['slug'] != 'none') {
    $category = get_term_by('slug', $mini_thumbnails['top_2']['slug'],'product_cat');
    $mini_thumbnails['top_2']['permalink'] = get_category_link($category);
    $mini_thumbnails['top_2']['name'] = $category->name;
}

//mini thumbnail 3
$mini_thumbnail_3 = array(
    'slug' => get_theme_mod('nb_prodcol_thumb3link',''), 
    'imgsrc' => get_theme_mod('nb_prodcol_thumb3img','') );
if($mini_thumbnail_3['slug'] != 'none') {
    $category = get_term_by('slug', $mini_thumbnail_3['slug'],'product_cat');
    $mini_thumbnail_3['permalink'] = get_category_link($category);
    $mini_thumbnail_3['name'] = $category->name;
}

?>

<!-- product collection section -->
<section class="site-wide-section site-white" style="<?php echo $bg_color; ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="site-section-header-2"><span><?php echo wp_kses_post($title); ?></span></h3>
            </div>
            <!-- top side -->
            <div class="col-md-8">
                <div class="row">
                    <?php if(isset($top['permalink'])) : ?>
                    <div class="col-md-12">
                        <a href="<?php echo $top['permalink']; ?>" class="nb-anchor-wrapper">
                            <div class='collection_top card-product-thumbnail wow bounceInUp'>
                                <div class="shadow"></div>
                                <img src="<?php echo $top['imgsrc']; ?>" class="card-img-top"/>
                                <h3 class="card-title"><?php echo $top['name']; ?></h3>
                            </div>
                        </a>
                    </div>
                    <?php endif ?>

                    <?php foreach($mini_thumbnails as $mini_thumbnail) : ?>
                    <div class="col-md-6  mb-3">
                            <a href="<?php echo $mini_thumbnail['permalink']; ?>" class="nb-anchor-wrapper">
                                <div class='mini-thumbnail card-product-thumbnail wow bounceInUp'>
                                    <div class="shadow"></div>
                                    <img src="<?php echo $mini_thumbnail['imgsrc']; ?>" class="card-img-top"/>
                                    <h3 class="card-title"><?php echo $mini_thumbnail['name']; ?></h3>
                                </div>
                            </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- side -->
            <div class="col-md-4 mb-3">
                <a href="<?php echo $side['permalink']; ?>" class="nb-anchor-wrapper">
                <div class='collection_side card-product-thumbnail wow bounceInRight'>
                    <div class="shadow"></div>
                    <img src="<?php echo $side['imgsrc']; ?>" class="card-img-top"/>
                    <h3 class="card-title"><?php echo $side['name']; ?></h3>
                </div>
                </a>
            </div>

            <!-- bottom -->
            <?php if(isset($footer['permalink']) && isset($mini_thumbnail_3['permalink'])) : ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <a href="<?php echo $footer['permalink']; ?>" class="nb-anchor-wrapper">
                            <div class='collection_footer card-product-thumbnail wow bounceInUp'>
                                <div class="shadow"></div>
                                <img src="<?php echo $footer['imgsrc']; ?>" class="card-img-top"/>
                                <h3 class="card-title"><?php echo $footer['name']; ?></h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="<?php echo $mini_thumbnail_3['permalink']; ?>" class="nb-anchor-wrapper">
                            <div class='mini-thumbnail card-product-thumbnail wow bounceInUp'>
                                <div class="shadow"></div>
                                <img src="<?php echo $mini_thumbnail_3['imgsrc']; ?>" class="card-img-top"/>
                                <h3 class="card-title"><?php echo $mini_thumbnail_3['name']; ?></h3>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
		</div>
	</div>
</section>