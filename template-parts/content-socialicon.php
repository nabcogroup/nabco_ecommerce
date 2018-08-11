<?php 

$nabco_setting_ico = apply_filters( 'nabco_setting_options_icon_path', [] );

?>

<!-- social -->
<div class="row">
<ul class="nb-social-icons  mx-auto ml-md-atuo">
    <?php if(isset($nabco_setting_ico['ico_youtube'])) : ?>
        <li class="social-item"><a class="youtube-color social-link" href="<?php echo $nabco_setting_ico['ico_youtube'] ?>" target="_blank" ><i class="fa fa-youtube  fa-fw"></i></a></li>
    <?php endif ?>

    <?php if(isset($nabco_setting_ico['ico_instagram'])) : ?>
        <li class="social-item"><a class="instagram-color social-link" href="<?php echo $nabco_setting_ico['ico_instagram']?>"  target="_blank"><i class="fa fa-instagram fa-fw"></i></a></li>
    <?php endif ?>

    <?php if(isset($nabco_setting_ico['ico_twitter'])) : ?>
        <li class="social-item"><a class="twitter-color social-link" href="<?php echo $nabco_setting_ico['ico_twitter'] ?>"  target="_blank"><i class="fa fa-twitter  fa-fw"></i></a></li>
    <?php endif; ?>

    <?php if(isset($nabco_setting_ico['ico_facebook'])) : ?>
        <li class="social-item"><a class="facebook-color social-link" href="<?php echo $nabco_setting_ico['ico_facebook'] ?>" target="_blank"><i class="fa fa-facebook-official  fa-fw" ></i></a></li>
    <?php endif; ?>
</ul>
</div>