<?php 

/*
    Sidebar - Front Page Sidebar

*/

if(!is_active_sidebar( 'frontpage-sidebar' ))  {
    return false;
}


?>

<?php dynamic_sidebar('frontpage-sidebar') ?>