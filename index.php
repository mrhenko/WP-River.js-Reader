<?php
/*
Plugin Name: WP River (.js) Reader
Plugin URI: http://blog.henrikcarlsson.se/tag/wp-river.js-reader/
Description: A widget that displays a "River of News". (http://scripting.com/2014/06/02/whatIsARiverOfNewsAggregator.html)
Author: MrHenko
Author URI: http://henrikcarlsson.se
*/

require_once( 'RiverReader.php' );

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');
	
	
add_action( 'widgets_init', function(){
     register_widget( 'RiverWidget' );
});	

//add_action('admin_print_styles', 'add_my_stylesheet');

/**
 * Adds RiverWidget widget.
 */
class RiverWidget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'RiverReaderJs', // Base ID
			__('RiverReaderJs', 'text_domain'), // Name
			array( 'description' => __( 'My first widget!', 'text_domain' ), ) // Args
		);
	}
	
	private function addWidgetStylesheet()  {
	
		wp_enqueue_style( 'riverReaderWidget', plugins_url( '/riverReaderStyle.css', __FILE__ ) );
	
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
	
		$this->addWidgetStylesheet();
	
		$riverReader = new RiverReader();
		
		$url = $instance[ 'riverURL' ];
	
     	echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		if ( $riverReader->fetchRiverFromURL( $url ) ) {
			echo $riverReader->displayRiver();
		} else {
			echo '<p>I\'m sorry, but a river could not be found or loaded from the specified URL.</p>
			<p><strong>URL:</strong> ' . $url . '</p>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'text_domain' );
		}
		
		if ( isset( $instance[ 'riverURL' ] ) ) {
			$riverURL = $instance[ 'riverURL' ];
		} else {
			$riverURL = __( 'River URL', 'text_domain' );
		}
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'riverURL' ); ?>"><?php _e( 'URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'riverURL' ); ?>" name="<?php echo $this->get_field_name( 'riverURL' ); ?>" type="text" value="<?php echo esc_attr( $riverURL ); ?>" />
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
		$instance['title']		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['riverURL']	= ( ! empty( $new_instance['riverURL'] ) ) ? strip_tags( $new_instance['riverURL'] ) : '';

		return $instance;
	}

} // class My_Widget