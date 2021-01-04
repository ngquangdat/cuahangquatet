<?php

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.thedotstore.com/
 * @since      1.0.0
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/includes
 * @author     Thedotstore
 */
class Page_Visit_Counter
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Page_Visit_Counter_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected  $loader ;
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected  $plugin_name ;
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected  $version ;
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        
        if ( defined( 'PVCP_VERSION' ) ) {
            $this->version = PVCP_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        
        $this->plugin_name = 'page-visit-counter-pro';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $prefix = ( is_network_admin() ? 'network_admin_' : '' );
        add_filter(
            "{$prefix}plugin_action_links_" . PVCP_PLUGIN_BASENAME,
            array( $this, 'plugin_action_links' ),
            10,
            4
        );
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Page_Visit_Counter_Loader. Orchestrates the hooks of the plugin.
     * - Page_Visit_Counter_i18n. Defines internationalization functionality.
     * - Page_Visit_Counter_Admin. Defines all hooks for the admin area.
     * - Page_Visit_Counter_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-page-visit-counter-admin.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-page-visit-counter-public.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-constant.php';
        /**
         * The class responsible for defining Widget list in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-widget.php';
        /**
         * The class responsible for defining shortcode for wizard
         * side of the site.
         */
        /**
         * User review admin block
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-page-visit-counter-user-feedback.php';
        $this->loader = new Page_Visit_Counter_Loader();
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Page_Visit_Counter_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Page_Visit_Counter_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Page_Visit_Counter_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'pvcp_admin_menu' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'pvcp_welcome_screen_redirect' );
        $this->loader->add_action( 'admin_head', $plugin_admin, 'pvcp_remove_admin_submenus' );
        $post_types = get_post_types();
        foreach ( $post_types as $post_list ) {
            $this->loader->add_filter( 'manage_' . $post_list . '_posts_columns', $plugin_admin, 'pvcp_columns_head' );
            $this->loader->add_action(
                'manage_' . $post_list . '_posts_custom_column',
                $plugin_admin,
                'pvcp_columns_content',
                10,
                2
            );
        }
        $this->loader->add_action( 'wp_ajax_pvcp_dashboard_summary', $plugin_admin, 'pvcp_dashboard_summary' );
        $this->loader->add_action( 'wp_ajax_pvcp_page_summary', $plugin_admin, 'pvcp_page_summary' );
        $this->loader->add_action( 'wp_ajax_pvcp_page_summary_report', $plugin_admin, 'pvcp_page_summary_report' );
        $this->loader->add_action( 'wp_ajax_pvcp_post_summary_report', $plugin_admin, 'pvcp_post_summary_report' );
        $this->loader->add_action( 'wp_ajax_pvcp_reset_all', $plugin_admin, 'pvcp_reset_all' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'pvcp_add_custom_meta_box' );
        $this->loader->add_action( 'save_post', $plugin_admin, 'pvcp_add_custom_meta_box_save' );
        $this->loader->add_action( 'widgets_init', $plugin_admin, 'pvc_init_widget' );
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Page_Visit_Counter_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp', $plugin_public, 'insert_page_visit_counter' );
        $this->loader->add_action(
            'the_content',
            $plugin_public,
            'default_page_visit_counter',
            99
        );
        
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $this->loader->add_action(
                'woocommerce_after_shop_loop',
                $plugin_public,
                'default_page_visit_counter_for_shop',
                99
            );
            $this->loader->add_action(
                'woocommerce_single_product_summary',
                $plugin_public,
                'default_page_visit_counter',
                99
            );
        }
    
    }
    
    /**
     * Return the plugin action links.  
     * This will only be called if the plugin is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */
    public function plugin_action_links(
        $actions,
        $plugin_file,
        $plugin_data,
        $context
    )
    {
        $custom_actions = array(
            'configure' => sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=pvcp-list' ), __( 'Settings', $this->plugin_name ) ),
            'docs'      => sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'www.thedotstore.com/page-visit-counter-pro' ), __( 'Docs', $this->plugin_name ) ),
            'support'   => sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'www.thedotstore.com/support' ), __( 'Support', $this->plugin_name ) ),
        );
        // add the links to the front of the actions list
        return array_merge( $custom_actions, $actions );
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Page_Visit_Counter_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}