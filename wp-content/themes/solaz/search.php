<?php get_header(); ?>  
<?php 
    $solaz_class = '';
    if ($solaz_sidebar_left && $solaz_sidebar_right && is_active_sidebar($solaz_sidebar_left) && is_active_sidebar($solaz_sidebar_right)){
        $solaz_class .= 'col-md-6 col-sm-12 col-xs-12 main-sidebar'; 
    }elseif($solaz_sidebar_left && (!$solaz_sidebar_right|| $solaz_sidebar_right=="none") && is_active_sidebar($solaz_sidebar_left)){
        $solaz_class .= 'f-right col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
    }elseif((!$solaz_sidebar_left || $solaz_sidebar_left=="none") && $solaz_sidebar_right && is_active_sidebar($solaz_sidebar_right)){
        $solaz_class .= 'col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
    }else {
        $solaz_class .= 'content-primary'; 
        if($solaz_layout == 'fullwidth'){
            $solaz_class .= ' col-md-12';
        }
    }
?>
<?php get_sidebar('left'); ?> 
    <div class="<?php echo esc_attr($solaz_class);?>">      
        <div id="primary" class="content-area">
            <?php if ( have_posts() ) :?>  
                <div class="search-content">
                    <?php get_template_part('templates/content', 'search-result'); ?> 
                </div>                                    
            <?php else: ?> 
                <article id="post-0" class="post no-results not-found">
                    <div class="container">
                        <header class="entry-header">
                            <h1 class="entry-title"><?php echo esc_html__('Nothing Found', 'solaz'); ?></h1>
                        </header>
                        <div class="row">
                            <div class="entry-content">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <p><?php echo esc_html__('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'solaz'); ?></p>
                                    <div class="widget widget_search">
                                    <?php get_search_form(); ?>
                                    </div>
                                </div>
                            </div><!-- .entry-content -->
                        </div>
                    </div>
                </article><!-- #post-0 -->
            <?php endif; ?>
        </div>
    </div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?>