<?php
$solaz_settings = solaz_check_theme_options();
$header_type = solaz_get_header_type();
$breadcrumbs = solaz_get_meta_value('breadcrumbs', true);
$page_title = solaz_get_meta_value('page_title', true);

if (( is_front_page() && is_home()) || is_front_page() || is_404() ) {
    $breadcrumbs = false;
    $page_title = false;
}
?>
<?php if ($page_title) : ?>
<div class="side-breadcrumb"> 
    <?php if($page_title) :?>
        <div class="page-title"><h1><?php solaz_page_title(); ?></h1></div>
    <?php endif;?>
</div>
<?php endif; ?>