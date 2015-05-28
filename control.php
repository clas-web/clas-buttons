<?php
/**
 * ClasButtons_WidgetShortcodeControl
 * 
 * The ClasButtons_WidgetShortcodeControl class for the "CLAS Buttons" plugin.
 * 
 * Shortcode Example:
 * [clas-buttons connections="default" thinkingmatters="default" exchange="default"]
 * 
 * @package    clas-buttons
 * @author     Crystal Barton <cbarto11@uncc.edu>
 */


require_once( dirname(__FILE__).'/widget-shortcode-control.php' );


if( !class_exists('ClasButtons_WidgetShortcodeControl') ):
class ClasButtons_WidgetShortcodeControl extends WidgetShortcodeControl
{
	
	private static $CONNECTIONS = array(
		'default' => array(
			'title' => 'CLAS Connections',
			'link' => 'http://clasconnections.uncc.edu',
		),
		'mosaic' => array(
			'title' => 'Mosaic Connections',
			'link' => 'http://clas-pages.uncc.edu/projectmosaic/connections',
		),
	);
	
	private static $THINKINGMATTERS = array(
		'default' => array(
			'title' => 'Thinking Matters',
			'link' => 'http://thinkingmatters.uncc.edu',
		),
	);
	
	private static $EXCHANGE = array(
		'default' => array(
			'title' => 'Exchange Online',
			'link' => 'http://exchange.uncc.edu',
		),
		'post' => array(
			'title' => 'Post to Exchange Online',
			'link' => 'http://exchange.uncc.edu/post',
		),
	);
	
	
	/**
	 * Constructor.
	 * Setup the properties and actions.
	 */
	public function __construct()
	{
		$widget_ops = array(
			'description'	=> 'Displays the three CLAS buttons.',
		);
		
		parent::__construct( 'clas-buttons', 'CLAS Buttons', $widget_ops );
	}
	
	
	/**
	 * Enqueues the scripts or styles needed for the control in the admin backend.
	 */
	public function admin_enqueue_scripts()
	{
		wp_enqueue_style( 'clas-buttons', plugins_url( '/style.css' , __FILE__ ) );
	}
	
	
	/**
	 * Enqueues the scripts or styles needed for the control in the site frontend.
	 */
	public function enqueue_scripts()
	{
		$this->admin_enqueue_scripts();
	}
	
	
	/**
	 * Output the widget form in the admin.
	 * @param   array   $options  The current settings for the widget.
	 */
	public function print_widget_form( $options )
	{
		$options = $this->merge_options( $options );
		extract( $options );
		
		?>
		
		<p>
		<label for="<?php echo $this->get_field_id( 'connections' ); ?>"><?php _e( 'Connections:' ); ?></label>
		<br/>
		<?php
		foreach( self::$CONNECTIONS as $k => $v )
		{
			?>
			<input type="radio" name="<?php echo $this->get_field_name( 'connections' ); ?>" value="<?php echo $k; ?>" <?php checked($k, $connections); ?>>
			<?php
			$this->print_button( 'connections', $k, $v['title'] );
			?>
			<br/>
			<?php
		}
		?>		
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'thinkingmatters' ); ?>"><?php _e( 'Thinking Matters:' ); ?></label>
		<br/>
		<?php
		foreach( self::$THINKINGMATTERS as $k => $v )
		{
			?>
			<input type="radio" name="<?php echo $this->get_field_name( 'thinkingmatters' ); ?>" value="<?php echo $k; ?>" <?php checked($k, $thinkingmatters); ?>>
			<?php
			$this->print_button( 'thinkingmatters', $k, $v['title'] );
			?>
			<br/>
			<?php
		}
		?>		
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'exchange' ); ?>"><?php _e( 'Exchange Online:' ); ?></label>
		<br/>
		<?php
		foreach( self::$EXCHANGE as $k => $v )
		{
			?>
			<input type="radio" name="<?php echo $this->get_field_name( 'exchange' ); ?>" value="<?php echo $k; ?>" <?php checked($k, $exchange); ?>>
			<?php
			$this->print_button( 'exchange', $k, $v['title'] );
			?>
			<br/>
			<?php
		}
		?>		
		</p>
		
		<?php

	}
	
	
	/**
	 * Get the default settings for the widget or shortcode.
	 * @return  array  The default settings.
	 */
	public function get_default_options()
	{
		return array(
			'connections' 		=> 'default',
			'thinkingmatters' 	=> 'default',
			'exchange' 			=> 'default',
		);
	}
	
	
	/**
	 * Process options from the database or shortcode.
	 * Designed to convert options from strings or sanitize output.
	 * @param   array   $options  The current settings for the widget or shortcode.
	 * @return  array   The processed settings.
	 */
	public function process_options( $options )
	{
		if( !is_array($options) ) $options = array();
		
		foreach( $options as $k => &$v )
		{
			if( is_string($v) ) $v = trim( $v );
		}
		
		if( array_key_exists('connections', $options) && 
		   !array_key_exists($options['connections'], self::$CONNECTIONS) ) 
			unset($options['connections']);

		if( array_key_exists('thinkingmatters', $options) && 
		   !array_key_exists($options['thinkingmatters'], self::$THINKINGMATTERS) ) 
			unset($options['thinkingmatters']);

		if( array_key_exists('exchange', $options) && 
		   !array_key_exists($options['exchange'], self::$EXCHANGE) ) 
			unset($options['exchange']);
		
		return $options;
	}
	
	
	/**
	 * Echo the widget or shortcode contents.
	 * @param   array  $options  The current settings for the control.
	 * @param   array  $args     The display arguments.
	 */
	public function print_control( $options, $args = null )
	{
		$defaults = $this->get_default_options();
		
		extract( $options );
		
		echo $args['before_widget'];
		echo '<div id="clas-buttons-control-'.self::$index.'" class="wscontrol clas-buttons-control">';

		if( !array_key_exists($connections, self::$CONNECTIONS) )
			$connections = $defaults['connections'];
		$image = self::$CONNECTIONS[$connections];
		$this->print_button( 'connections', $connections, $image['title'], $image['link'] );
		
		if( !array_key_exists($thinkingmatters, self::$THINKINGMATTERS) )
			$thinkingmatters = $defaults['thinkingmatters'];
		$image = self::$THINKINGMATTERS[$thinkingmatters];
		$this->print_button( 'thinkingmatters', $thinkingmatters, $image['title'], $image['link'] );
		
		if( !array_key_exists($exchange, self::$EXCHANGE) )
			$exchange = $defaults['exchange'];
		$image = self::$EXCHANGE[$exchange];
		$this->print_button( 'exchange', $exchange, $image['title'], $image['link'] );
		
		echo '</div>';
		echo $args['after_widget'];		
	}
	
	
	/**
	 * Echo a CLAS button.
	 * @param   string  $button_key     The key for the button.
	 * @param   string  $selection_key  The selected value for the button.
	 * @param   string  $title          The title for the button.
	 * @param   string  $link           The link/anchor url.
	 */
	private function print_button( $button_key, $selection_key, $title, $link = null )
	{
		$background_path = plugins_url( "images/background-{$button_key}.png", __FILE__ );
		$button_path = plugins_url( "images/button-{$button_key}-{$selection_key}.png", __FILE__ );
		
		if( $link ):
			?><a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php
		endif;
		
		?>
		<div class="clas-button <?php echo $button_key; ?>" style="background-image:url('<?php echo $background_path; ?>')">
		<img src="<?php echo $button_path; ?>" />
		</div>
		<?php
		
		if( $link ):
			?></a><?php
		endif;
	}
	
}
endif;

