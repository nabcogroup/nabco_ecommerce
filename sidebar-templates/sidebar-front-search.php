<?php 

/*
    Sidebar - Front Page Sidebar

*/

if(!is_active_sidebar( 'topheader-search-sidebar' ))  {
    return false;

}


?>

<?php dynamic_sidebar('topheader-search-sidebar') ?>
