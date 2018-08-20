<?php 

/*
    Sidebar - Front Page Sidebar

*/

if(!is_active_sidebar( 'topheader-search-sidebar' ))  {
    return false;

}


?>
<div>
    <?php dynamic_sidebar('topheader-search-sidebar') ?>
</div>