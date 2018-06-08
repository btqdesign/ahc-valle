<?php
$solaz_gallery = get_post_meta(get_the_ID(), 'images_gallery', true);
$solaz_video = get_post_meta(get_the_ID(), 'video_code', true);
?>
<div class="blog post-single <?php if(has_post_thumbnail() || $solaz_video!= '' || $solaz_gallery!= ''){echo 'has_thumnail';} ?>">
    <div class="blog-content">
		<div class="blog-item">
			<?php solaz_get_post_media(); ?>
			<div class="blog-post-info">
				<div class="blog-post-title">
					<div class="blog-info">
						<?php $author_id= $post->post_author;?>
						<div class="info">
							<span><i class="pe-7s-users"></i> <?php echo get_the_author_meta( 'nickname' , $author_id ); ?></span>
						</div>
						<div class="blog-date">
							<p class="date"><i class="pe-7s-clock"></i> <?php echo get_the_date(); ?></p>
						</div>
						<div class="info info-comment"> 
							<i class="pe-7s-comment"></i> <?php comments_popup_link(esc_html__('0 Comment', 'solaz'), esc_html__('1 Comment', 'solaz'), esc_html__('% Comments', 'solaz')); ?>
						</div>
					</div>
				</div>				
			</div>	
			<div class="blog_post_desc">					
				<?php the_content();?>
					<?php 
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'solaz' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'solaz' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
					?>							
			</div>	
			<div class="share-links">
				<div class="addthis_sharing_toolbox">
					<span class="lab"><?php echo esc_html__('Share this: ', 'solaz');?></span>
					<div class="f-social">

						<ul>
							<li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>	                    
							<li>
								<a href="https://plus.google.com/share?url=<?php echo urlencode(get_the_permalink()); ?>" target="_blank">
									<i class="fa fa-google-plus"></i>
								</a>
							<li><a href="http://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_the_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
			</div>	
		</div>
	</div>
	
	<?php solaz_author_box();?>
    <div class="post-comments">
        <?php comments_template('', true); ?>  
    </div>  
</div>
