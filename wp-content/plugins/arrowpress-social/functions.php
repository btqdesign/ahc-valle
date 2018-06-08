<?php 
/*
  Plugin Name: ArrowPress Social
  Plugin URI:
  Description: ArrowPress Social for ArrowPress Theme.
  Version: 1.0.0
  Author: ArrowPress
  Author URI:
 */
  // Block direct requests
	if ( !defined('ABSPATH') )
	    die('-1');
	require_once dirname(__FILE__) . '/twitter/settings.php';
	require_once dirname(__FILE__) . '/twitter/api/Abraham/TwitterOAuth/TwitterOAuth.php';
	require_once dirname(__FILE__) . '/twitter/widget.php';    
	require_once dirname(__FILE__) . '/instagram/settings.php';    

	/**
	 * Adds arrowpress_instagram_feed widget.
	 */

	class arrowpress_social extends WP_Widget {
		/**
	     * Register widget with WordPress.
	     */
	    function __construct() {
	        parent::__construct(
	            'arrowpress_instagram_feed', // Base ID
	            __('Arrowpress Instagram Feed', 'arrowpress'), // Name
	            array( 'description' => __( 'Arrowpress Instagram Feed', 'arrowpress' ), ) // Args
	        );
	        add_shortcode('arrowpress_instagram_feed', array($this, 'arrowpress_shortcode_instagram'));
	    }
	    function loadJs() {
	        wp_enqueue_script('arrowpress_instagram', plugin_dir_url(__FILE__) . '/js/instagramfeed.js', array(), false, false);
	    }
	    public function get_tweets($number_tweets) {
	        # Define constants
	        $options = get_option('arrowpress_latest_tweet');
	        $username = $options['username'];
	        $consumer_key = $options['consumer_key'];
	        $consumer_secret = $options['consumer_secret'];
	        $access_token = $options['access_token'];
	        $access_token_secret = $options['access_token_secret'];
	        if(empty($username) || empty($consumer_key) || empty($consumer_secret) 
	                || empty($access_token) || empty($access_token_secret)) {
	            return false;
	        }
	        # Create the connection
	        $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	        # Migrate over to SSL/TLS
	        $twitter->ssl_verifypeer = false;
	        # Load the Tweets
	        try {
	            $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $username, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => $number_tweets));
	            # Example output
	            //echo '<pre>';print_r($tweets);die();
	            if (!empty($tweets)) {
	                echo '<div class="latest-tweets"><ul>';
	                foreach($tweets as $_tweet) {
	                    $user = $_tweet->user;
	                    $handle = $user->screen_name;
	                    $id_str = $_tweet->id_str;
	                    $link = esc_html( 'http://twitter.com/'.$handle.'/status/'.$id_str);
	                    $date = DateTime::createFromFormat('D M d H:i:s O Y', $_tweet->created_at );
	                    $output ='<li>';
	                    $output .= '<div class="twitter-tweet"><i class="fa fa-twitter"></i><div class ="tweet-text">'. esc_attr($_tweet->text).'<p class="my-date">'.esc_attr($date->format('g:i A - j M Y')).'</p></div>';
	                    $output .= '</div></li>';
	                    echo $output;
	                }
	                echo '</ul></div>';
	            }
	        } catch (Exception $exc) {
	            echo esc_html__('Something wrong, please check the connection or the api config!');
	        }

	        return null;
	    }
	    // load plugin text domain
	    function loadTextDomain() {
	        load_plugin_textdomain('arrowpress', false, dirname(__FILE__) . '/languages/');
	    }
	    /**
	     * Front-end display of widget.
	     *
	     * @see WP_Widget::widget()
	     *
	     * @param array $args     Widget arguments.
	     * @param array $instance Saved values from database.
	     */	    
	    public function widget( $args, $instance ) {
	        $options = get_option('arrowpress_instagram');
	        $access_token = $options['access_token'];
	        $user_id = $options['user_id'];
	        
	        extract( $args );
	        $tag = ( ! empty( $instance['tag'] ) ) ? strip_tags( $instance['tag'] ) : '';
	        $title = apply_filters( 'widget_title', $instance['title'] );
	        $i=0;
	        echo $before_widget;
	        ?>

	        <?php if ($access_token != '' && $user_id != ''): ?>
	            <?php
	            $url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token;
	            $all_result = $this->process_url($url);

	            $decoded_results = json_decode($all_result, true);
	        ?>
	            <h3 class="widget-title widget-title-border"><span><?php echo $title; ?></span></h3>
	            <div class="instagram-container">
	                <?php if (count($decoded_results) & isset($decoded_results['data'])) : ?>
	                    <?php if($instance['number'] <=9):?>
	            
	                            <ul class="instagram-gallery">
	                            <?php if($tag != ""):?>
	                              <?php foreach (array_slice($decoded_results['data'], 0) as $value): ?>
	                                <?php if( isset($value['tags'][0])):?>
	                                  <?php if (in_array($tag, $value['tags'])):?>
	                                  <?php  $i ++;?>
	                                    <?php if($i <= $instance['number']):?>
	                                      <li>
	                                          <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
	                                            <img width="85" height="85" src="<?php echo $value['images']['thumbnail']['url'] ?>" alt="<?php echo $value['caption']['text'] ?>" />
	                                          </a>
	                                      </li>
	                                    <?php endif;?>
	                                  <?php endif;?>
	                                <?php endif;?>
	                              <?php endforeach; ?>   
	                            <?php else:?>
	                              <?php foreach (array_slice($decoded_results['data'], 0, $instance['number']) as $value): ?>
	                                  <li>
	                                      <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
	                                        <img width="85" height="85" src="<?php echo $value['images']['thumbnail']['url'] ?>" alt="<?php echo $value['caption']['text'] ?>" />
	                                      </a>
	                                  </li>
	                                <?php endforeach; ?>
	                            <?php endif;?>                             
	                            </ul>
	                    <?php else:?>
	                                <ul class="instagram-gallery">
	                                  <?php foreach (array_slice($decoded_results['data'], 0, 8) as $value): ?>
	                                    <li>
	                                        <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
	                                          <img width="85" height="85" src="<?php echo $value['images']['thumbnail']['url'] ?>" alt="<?php echo $value['caption']['text'] ?>" />
	                                        </a>
	                                    </li>
	                                  <?php endforeach; ?>
	                                </ul>
	                    <?php endif;?>
	                        
	                <?php else: ?>
	                    <p> <?php echo esc_html__("Access token is not valid.","arrowpress");?></p>
	                <?php endif;?>
	            </div>
	        <?php endif; ?>
	        <?php
	        echo $after_widget;
	    }
	    /**
	     * Back-end widget form.
	     *
	     * @see WP_Widget::form()
	     *
	     * @param array $instance Previously saved values from database.
	     */
	    public function form( $instance ) {
	        $defaults = array( 
	            'title' => 'Instagram', 
	            'number' => 9,
	            'tag' =>"",
	            );
	        $instance = wp_parse_args( (array) $instance, $defaults );
	        ?>
	        <p>
	            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
	            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" type="text" name="<?php echo $this->get_field_name('title'); ?>'" value="<?php echo $instance['title']; ?>" />
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of photos to display (Less than or equal to 9):'); ?></label>
	            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
	        </p>
	        <p>
	            <label for="<?php echo $this->get_field_id('tag'); ?>">Hashtag:</label>
	            <input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" type="text" name="<?php echo $this->get_field_name('tag'); ?>'" value="<?php echo $instance['tag']; ?>" />
	        </p>
	       
	       
	        <?php 
	    }
	    /**
	     * Sanitize widget form values as they are saved.
	     *
	     * @see WP_Widget::update()
	     *
	     * @param array $new_instance Values just sent to be saved.
	     * @param array $old_instance Previously saved values from database.
	     *
	     * @return array Updated safe values to be saved.
	     */
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	        $instance['tag'] = ( ! empty( $new_instance['tag'] ) ) ? strip_tags( $new_instance['tag'] ) : '';
	        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
	        return $instance;
	    }
	    function arrowpress_shortcode_instagram($atts, $content = null) {
	        $options = get_option('arrowpress_instagram');
	        $access_token = $options['access_token'];
	        $user_id = $options['user_id'];

	        $limit = 20;
	        $output = $title = $el_class = '';
	        $per_page = 9;
	        extract(shortcode_atts(array(
	            'per_page' => '',
	            'el_class' => ''
	        ), $atts));

	        $el_class = arrowpress_shortcode_extract_class($el_class);
	        $output = '<div class="arrowpress-animation ' . $el_class . '"';
	        $output .= '>';
	        ob_start();
	        ?>
	        <?php echo $output; ?>
	        <?php if ($access_token != '' && $user_id != ''): ?>
	            <?php
	            $url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . $access_token;
	            $link_url = 'https://instagram.com/' . $user_id;
	            $all_result = $this->process_url($url);

	            $decoded_results = json_decode($all_result, true);
	            ?>
	            <div class="instagram-container instagram-gallery">
					      <?php if (count($decoded_results) && $decoded_results['data'] ) : ?>
	                      <ul class="footer-gallery">
	                        <?php foreach (array_slice($decoded_results['data'], 0, $per_page) as $value): ?>
	                          <li>
	                              <a title="<?php echo $value['caption']['text'] ?>" target="_blank" href="<?php echo $value['link'] ?>">
	                                <img width="150" height="150" src="<?php echo $value['images']['thumbnail']['url'] ?>" alt="<?php echo $value['caption']['text'] ?>" />
	                              </a>
	                          </li>
	                        <?php endforeach; ?>                                
	                      </ul>
	                <?php endif; ?>
	            </div>
	        <?php else: ?>
	            <div class="row">
	                <?php echo __('Instagram Plugin error: Plugin not fully configured', 'arrowpress') ?>
	            </div>
	        <?php endif; ?>
	            
	        </div>
	        <?php
	        return ob_get_clean();
	    }
	    function process_url($url) {
	        $ch = curl_init();
	        curl_setopt_array($ch, array(
	            CURLOPT_URL => $url,
	            CURLOPT_RETURNTRANSFER => true,
	            CURLOPT_SSL_VERIFYPEER => false,
	            CURLOPT_SSL_VERIFYHOST => 2
	        ));

	        $result = curl_exec($ch);
	        curl_close($ch);
	        return $result;
	    }
	}
	add_action( 'widgets_init', function(){
     register_widget( 'arrowpress_social' );
	});
?>