<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The Widget functionality for this plugin.
 * widget provide Most visited page.
 *
 */
class Page_Visit_Counter_Admin_Widget extends WP_Widget {

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */

    public function __construct() {
        parent::__construct(
            'pvcp_widget', // Base ID of your widget
            __( 'Recent Visit page', PVCP_TEXT_DOMAIN ), // Widget name will appear in UI
            array( 'description' => __( 'Most Visited Pages', PVCP_TEXT_DOMAIN ), ) // Widget description
        );
    }
    /**
     * Creating widget front-end
     *
     * @since    1.0.0
     *
     * @param $args
     * @param $instance
     */
    function widget($args, $instance) {
        global $wpdb;

        $title = empty($instance['title']) ? __( 'Recent Visit page', PVCP_TEXT_DOMAIN ) : apply_filters('widget_title', $instance['title']);
        $html = '';
        $html .= $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
        $count_visit_limit = '5';
        $count_visit = $wpdb->get_results($wpdb->prepare("SELECT distinct page_id FROM {$wpdb->prefix}page_visit_history ORDER BY id DESC LIMIT %d",$count_visit_limit)); //db call ok; no-cache ok
        if($count_visit){
            $html .= '<ul>';
            foreach ($count_visit as $visit_page) {
                $page = get_post($visit_page->page_id);
                $html .= '<li><a href="'.get_post_permalink( $visit_page->page_id ).'">' . $page->post_title . '</a></li>';
            }
            $html .= '</ul>';
        }
        $html .= $args['after_widget'];
        echo $html;

    }
    /**
     * Widget Backend
     *
     * @since    1.0.0
     *
     * @param $instance
     */
    public function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = $instance['title'];
        $html = '';
        $html .= '<p> <label for="' . esc_attr($this->get_field_id("title")) . '">Title:
       		   <input class="widefat" id="' . esc_attr($this->get_field_id("title")) . '"
               name="' . esc_attr($this->get_field_name("title")) . '" type="text"
               value="' . esc_attr($title) . '" /></label></p>';
        echo $html;
    }

    /**
     * Updating widget replacing old instances with new
     *
     * @since    1.0.0
     *
     * @param $new_instance
     * @param $old_instance
     *
     * @return array
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];

        return $instance;
    }

}