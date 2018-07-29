<?php 

get_header();

$under_con = get_theme_mod('nb_underconstruction','')
?>


 <!-- video section-->
 <section class="nb-section p-0 m-0">    
            <script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '100%',
			'height', '400',
			'src', 'imgs/MAIN', 
			'quality', 'high',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'window',
			'devicefont', 'false',
			'id', 'Untitled-1',
			'bgcolor', '#ffffff',
			'name', 'MAIN',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'movie', '<?php echo get_template_directory_uri() ?>/imgs/MAIN',
			'salign', ''
			); //end AC code
	}
</script>
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="550" height="400" id="Untitled-1" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="<?php  echo get_template_directory() ?>/imgs/MAIN.swf ?>" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" />	
	<embed src="<?php echo get_template_directory() ?>/imgs/MAIN.swf" quality="high" bgcolor="#ffffff" width="1903" height="733" name="MAIN.swf" align="middle" 
	allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" 
	pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>

    <!-- <div class="video-section">
            <iframe class="video" src="https://www.youtube.com/embed/DPbnxTQpuBU?rel=0&amp;" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div> -->

    <?php get_template_part( 'template-parts/menu/menu', 'main' ) ?>
                
</section>
<?php if($under_con == 'development') : ?>

    <?php get_template_part( 'template-parts/content-loop/content', 'under-construction' ) ?>
<?php endif; ?>

<?php get_footer(); ?>