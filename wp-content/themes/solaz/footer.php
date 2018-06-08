<?php $solaz_settings = solaz_check_theme_options();
$footer_type = solaz_get_footer_type();
$solaz_layout = solaz_get_layout();
$solaz_hide_footernewsletter = solaz_get_meta_value('hide_footernewsletter', true);
$solaz_hide_f_info = solaz_get_meta_value('hide_f_info', true);
?> 

<?php if($solaz_layout == 'fullwidth') :?>
	</div>
</div>
<?php endif;?>
	</div> <!-- End main-->
<?php if(is_singular('post')) :?>
		<?php echo solaz_get_banner_block();?>
	<?php endif;?>
<?php if (solaz_get_meta_value('show_footer', true)) : ?>
<footer id="colophon" class="footer <?php if(!$solaz_hide_f_info){echo 'remove_f_info';}?>">
    <div class="footer-v<?php echo esc_attr($footer_type); ?>">      
        <?php get_template_part('footers/footer_' . $footer_type); ?>
    </div> <!-- End footer -->
</footer> <!-- End colophon -->
<?php endif;?>
<div id="closeNav" class="overlay3"></div>
</div> <!-- End page-->

<?php wp_footer(); ?>


</body>
</html>