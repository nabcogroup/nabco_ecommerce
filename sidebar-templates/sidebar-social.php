<?php 

/*
    Sidebar - Sidebar Social

*/

if(!is_active_sidebar( 'social-sidebar' ))  {
    return false;
}

?>

<div id="social-nav" class="social-wrapper">
    <ul class="nb-social-icons">
        <li class="social-item">
            <a  href="#" class="social-link js-icon" data-title="Facebook" data-container="facebook-container"><span class="fab fa-facebook fa-2x"></span></a>
        </li>
        <li class="social-item">
            <a href="#" class="social-link js-icon" data-title="Twitter" data-container="twitter-container"><span class="fab fa-twitter-square fa-2x"></span></a>
        </li>
        <li class="social-item">
            <a href="#" class="social-link js-icon" data-title="Instagram" data-container="instagram-container"><span class="fab fa-instagram fa-2x"></span></a>
        </li>
        <li class="social-item">
            <a href="#" class="social-link js-icon" data-title="Youtube" data-container="youtube-container"><span class="fab fa-youtube fa-2x"></span></a>
        </li>
    </ul>
    
    <div id="social-container" class="social-container container-hide">
        <div class="social-container-wrapper">
            <header id="social-header" class="social-container-heading">
                <p id="social-title" class="social-title" style="color:#f5f5f5"><span>Youtube</span></p>                
                <div class="dark-cover"></div>
            </header>
            <div class="social-handle-container">
                <?php dynamic_sidebar( 'social-sidebar' ); ?>
            </div>    
        </div>
    </div>
</div>
