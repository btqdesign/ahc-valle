
    <div class="col-md-7 no-padding gallery_left">
      <?php
        $image_gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
        $client = get_post_meta(get_the_ID(), 'client', true);
        $services = get_post_meta(get_the_ID(), 'services', true);
      ?>  
        <div class="image_list var2">
          <ul>
            <?php
              $viewport = '';
              $index = 0;
              if($image_gallery){
              foreach ($image_gallery as $key => $value) :
                  $image_large = wp_get_attachment_image_src($value, 'full');
                  if (isset($image_large[0])) {
                      $image = wp_get_attachment_image_src($value, 'solaz_gallery_single');
                      $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                      $viewport .= '<li><img src="' . $image[0] . '" alt="' . $alt . '"/></li>';
                      $index++;
                  }
              endforeach;
            }
              $viewport .= '';
              echo wp_kses($viewport,array(
                  'li' => array(),
                  'img' =>  array(
                    'width' => array(),
                    'height'  => array(),
                    'src' => array(),
                    'class' => array(),
                    'alt' => array(),
                    'id' => array(),
                    )
                ));            
              ?>
          </ul>
        </div>

    </div>
    <div class="col-md-4 col-sm-offset-1 no-padding gallery_right">
      
        <div class="mad_bottom3">
        
            <div class="solaz-heading  text-left">
              <p><?php echo get_the_term_list($post->ID,'gallery_cat', '', ', ' ); ?></p>
              <h3><?php the_title(); ?></h3>
            </div>
            <div class="gallery_desciption">
                <?php echo wpautop(get_the_content());?>
            </div>
            <div class="vertical_list">
                <ul>
                  <?php if(get_post_meta(get_the_ID(),'status',true) != ""):?>
                    <li>
                      <span><?php echo esc_html__( 'Status:', 'solaz' ); ?></span> <?php echo esc_html(get_post_meta(get_the_ID(),'status',true));?>
                    </li>
                  <?php endif;?>
                    <li>
                      <span><?php echo esc_html__( 'Date:', 'solaz' ); ?></span> <?php echo get_the_date('dS, M. Y');?>
                    </li>

                    <li>
                        <span><?php echo esc_html__( 'Share:', 'solaz' ); ?></span> 
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="https://plus.google.com/share?url=<?php echo urlencode(get_the_permalink()); ?>" target="_blank">
                            <i class="fa fa-google-plus"></i>
                        </a>
                        <a href="http://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_the_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_the_permalink()); ?>&media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id() )); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>                        
                    </li>
                </ul>
            </div>

        </div>
        <div class="clearfix">
              <div class="gallery_paginations text-center">
                <?php 
                    $previous = ( is_attachment() ) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
                    $next = get_adjacent_post(false, '', false);
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                <ul>
                    <?php
                    if($prev_post){
                    previous_post_link('<li class="arrow_left"><a href="'.get_permalink( $prev_post->ID ).'"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>', '');
                    } ?>
                    <li class="divider">/</li>
                    <?php
                    if($next_post){
                    next_post_link('<li class="arrow_right"><a href="'.get_permalink( $next_post->ID ).'"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>', '');
                    } ?>            
                </ul>
              </div>
        </div>

    </div>
    <?php 
    $gallery_related = get_post_meta(get_the_ID(), 'related_entries', true);
    ?>
    <?php if (is_array($gallery_related)) : ?>
        <?php if (count($gallery_related) > 0) : ?>
            <div class="gallery_related">
                <div class="solaz-heading  text-left ">
                    <h4><?php echo esc_html__('Other Works','solaz' );?> </h4>
                </div>
                <div class="tabs_sort">
                    <div class="gallery-entries-wrap isotope clearfix gallery-style2">  
                        <?php foreach ($gallery_related as $key => $entry) : ?>
                            <div class="item ">
                                <figure>
                                  <div class="gallery_zoom_effect">
                                    <div class="img_onhover">
                                      <?php if (has_post_thumbnail($entry)) : ?>                                   
                                        <?php $image = get_the_post_thumbnail($entry, 'solaz_gallery_square'); 
                                        $attachment_url = wp_get_attachment_url(get_post_thumbnail_id($entry)); 
                                        ?>
                                        <?php echo wp_kses($image,array(
                                          'img' =>  array(
                                            'width' => array(),
                                            'height'  => array(),
                                            'src' => array(),
                                            'class' => array(),
                                            'alt' => array(),
                                            'id' => array(),
                                            )
                                        )); ?>
                                      </div>     
                                  </div>                               
                                <?php endif; ?>
                                     <figcaption>
                                        <div class="caption_block">
                                          <div class="item_desc">
                                            <a href="<?php the_permalink($entry); ?>" class="project_title"><h4><?php echo get_the_title($entry);?></h4></a>
                                            <?php echo get_the_term_list($entry,'gallery_cat', '', ', ' ); ?>               
                                          </div>
                                        </div>
                                    </figcaption>  
                                </figure>                             
                              </div>
                        <?php endforeach; ?>
                    </div>
                </div>   
            </div>
        <?php endif; ?>
    <?php endif; ?>
