<?php
/*
Plugin Name: Chicago Speech Therapy: Video Landing Page
Description: A custom post type view for Video Landing Pages
Version: 0.0.1
*/
add_filter('single_template', function($single) {
  global $wp_query, $post;
  if($post->post_type == 'landing') {
    add_action('wp_head', function() {
      wp_enqueue_style('bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css');
      wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css?family=Raleway:400,400i,700');
      wp_enqueue_style('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
      wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js', ['jquery']);
      wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js', ['jquery', 'popper']);
      wp_enqueue_style('cst_video_landing_page_css', plugin_dir_url(__FILE__) . 'video_landing_page.css', ['bootstrap_css', 'google_fonts']);
    });
    if(file_exists(plugin_dir_path(__FILE__) . 'video_landing_page.php')) {
      return plugin_dir_path(__FILE__) . 'video_landing_page.php';
    }

  }
});

add_action('init', function() {
  register_nav_menu('landing-page-menu', __('Landing Page Menu'));
  add_filter('nav_menu_css_class', function($classes, $item) {
    $classes[] = 'nav-item';
    return $classes;
  }, 10, 2);
});

/**
 * Create a nav menu with very basic markup.
 *
 * @author Thomas Scholz http://toscho.de
 * @version 1.0
 */
class T5_Nav_Menu_Walker_Simple extends Walker_Nav_Menu
{
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth, $args )
	{
		$output     .= '<li class="nav-item">';
		$attributes  = '';

		! empty ( $item->attr_title )
			// Avoid redundant titles
			and $item->attr_title !== $item->title
			and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

		! empty ( $item->url )
			and $attributes .= ' href="' . esc_attr( $item->url ) .'"';

		$attributes  = trim( $attributes );
		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output = "$args->before<a $attributes class='nav-link'>$args->link_before$title</a>"
						. "$args->link_after$args->after";

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
			,   $item_output
			,   $item
			,   $depth
			,   $args
		);
	}

	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function start_lvl( &$output )
	{
		$output .= '<ul class="sub-menu">';
	}

	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output )
	{
		$output .= '</ul>';
	}

	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output )
	{
		$output .= '</li>';
	}
}
