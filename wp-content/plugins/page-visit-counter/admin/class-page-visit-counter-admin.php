<?php

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.thedotstore.com/
 * @since      1.0.0
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/admin
 * @author     Thedotstore <support@thedotstore.com>
 */
class Page_Visit_Counter_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles( $hook )
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Page_Visit_Counter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Page_Visit_Counter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        if ( strpos( $hook, 'dotstore-plugins_page_pvcp' ) !== false ) {
            wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/page-visit-counter-admin.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'chosen-style',
                plugin_dir_url( __FILE__ ) . 'css/chosen.css',
                array(),
                $this->version
            );
            wp_enqueue_style( 'wp-color-picker' );
        }
        
        if ( $hook === 'dotstore-plugins_page_pvcp-main-dashboard' || $hook === 'dotstore-plugins_page_pvcp-dashboard-page' || $hook === 'dotstore-plugins_page_pvcp-dashboard-post' ) {
            wp_enqueue_style(
                $this->plugin_name . 'dataTables-style',
                plugin_dir_url( __FILE__ ) . 'css/page-visit-counter-dataTables.min.css',
                array(),
                $this->version
            );
        }
    }
    
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts( $hook )
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Page_Visit_Counter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Page_Visit_Counter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        if ( false !== strpos( $hook, 'dotstore-plugins_page_pvcp' ) ) {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script(
                $this->plugin_name . 'tablesorter',
                plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.min.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'chosen-jquery',
                plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                $this->plugin_name . 'pvcp-datatable-min',
                plugin_dir_url( __FILE__ ) . 'js/page-visit-counter-dataTables.min.js',
                array(),
                $this->version,
                false
            );
            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'js/page-visit-counter-admin.js',
                array( 'jquery', 'jquery-ui-sortable' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                'iris',
                admin_url( 'js/iris.min.js' ),
                array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
                false,
                1
            );
            wp_enqueue_script(
                'wp-color-picker',
                admin_url( 'js/color-picker.min.js' ),
                array( 'iris' ),
                false,
                1
            );
            $colorpicker_l10n = array(
                'clear'         => esc_html__( 'Clear', 'page-visit-counter' ),
                'defaultString' => esc_html__( 'Default', 'page-visit-counter' ),
                'pick'          => esc_html__( 'Select Color', 'page-visit-counter' ),
            );
            
            if ( !empty($colorpicker_l10n) || $colorpicker_l10n !== "" ) {
                wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
            } else {
                wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', '' );
            }
        
        }
        
        
        if ( $hook === 'dotstore-plugins_page_pvcp-main-dashboard' || $hook === 'dotstore-plugins_page_pvcp-dashboard-page' || $hook === 'dotstore-plugins_page_pvcp-dashboard-post' ) {
            wp_enqueue_script(
                $this->plugin_name . 'pvcp-canvas-custom-free',
                plugin_dir_url( __FILE__ ) . 'js/page-visit-counter-admin-canvas.js',
                array( 'jquery' ),
                $this->version,
                false
            );
            wp_enqueue_script(
                $this->plugin_name . 'pvcp-canvasjs-min',
                plugin_dir_url( __FILE__ ) . 'js/page-visit-counter-canvasjs.min.js',
                array(),
                $this->version,
                false
            );
        }
        
        wp_localize_script( $this->plugin_name, 'adminajax', array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'ajax_icon' => esc_url( plugin_dir_url( __FILE__ ) . '/images/ajax-loader.gif' ),
        ) );
    }
    
    /**
     * Register and load the widget
     *
     * @since    1.0.0
     */
    public function pvc_init_widget()
    {
        return register_widget( 'Page_Visit_Counter_Admin_Widget' );
    }
    
    /**
     * Create settings and other pages for Page Visit Counter Pro plugin in the backend.
     *
     * @since    1.0.0
     */
    public function pvcp_admin_menu()
    {
        global  $GLOBALS ;
        if ( empty($GLOBALS['admin_page_hooks']['dots_store']) ) {
            add_menu_page(
                'DotStore Plugins',
                __( 'DotStore Plugins' ),
                'manage_option',
                'dots_store',
                array( $this, 'pvcp_wizard_list_page' ),
                PVCP_PLUGIN_URL . 'admin/images/menu-icon.png',
                25
            );
        }
        add_submenu_page(
            'dots_store',
            'Page Visit Counter',
            __( PVCP_PLUGIN_NAME ),
            'manage_options',
            'pvcp-list',
            array( $this, 'pvcp_wizard_list_page' )
        );
        add_submenu_page(
            'dots_store',
            'Get Started',
            'Get Started',
            'manage_options',
            'pvcp-get-started',
            array( $this, 'pvcp_get_started_page' )
        );
        add_submenu_page(
            'dots_store',
            'Information',
            'Information',
            'manage_options',
            'pvcp-quick-information',
            array( $this, 'pvcp_quick_info_page' )
        );
        add_submenu_page(
            'dots_store',
            'Add New',
            'Add New',
            'manage_options',
            'pvcp-add-new',
            array( $this, 'pvcp_add_new_wizard_page' )
        );
        add_submenu_page(
            'dots_store',
            'Edit Wizard',
            'Edit Wizard',
            'manage_options',
            'pvcp-edit-wizard',
            array( $this, 'pvcp_edit_wizard_page' )
        );
        add_submenu_page(
            'dots_store',
            'Wizard Setting',
            'Wizard Setting',
            'manage_options',
            'pvcp-wizard-setting',
            array( $this, 'pvcp_wizard_setting_page' )
        );
        add_submenu_page(
            'dots_store',
            'Settings',
            'Settings',
            'manage_options',
            'pvcp-settings',
            array( $this, 'pvcp_plugin_settings_page' )
        );
        add_submenu_page(
            'dots_store',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'pvcp-main-dashboard',
            array( $this, 'pvcp_plugin_dashboard' )
        );
        add_submenu_page(
            'dots_store',
            'Page Summary',
            'Page Summary',
            'manage_options',
            'pvcp-dashboard-page',
            array( $this, 'pvcp_plugin_dashboard_page' )
        );
        add_submenu_page(
            'dots_store',
            'Post Summary',
            'Post Summary',
            'manage_options',
            'pvcp-dashboard-post',
            array( $this, 'pvcp_plugin_dashboard_post' )
        );
    }
    
    /**
     * Wizard List page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_wizard_list_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-wizard-list-page.php';
    }
    
    /**
     * Get Started page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_get_started_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-get-started-page.php';
    }
    
    /**
     * Quick Information page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_quick_info_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-quick-info-page.php';
    }
    
    /**
     * Add New Wizard page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_add_new_wizard_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-add-new-page.php';
    }
    
    /**
     * Edit Wizard Page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_edit_wizard_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-add-new-page.php';
    }
    
    /**
     * Wizard Setting Page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_wizard_setting_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-wizard-setting.php';
    }
    
    /**
     * Wizard Setting Page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_plugin_settings_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-plugin-settings.php';
    }
    
    /**
     * Wizard Dashboard Setting Page in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_plugin_dashboard()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-plugin-dashboard.php';
    }
    
    /**
     * Wizard All Page List with graph in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_plugin_dashboard_page()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-plugin-dashboard-page.php';
    }
    
    /**
     * Wizard All Post List with graph in the admin area.
     *
     * @since    1.0.0
     */
    public function pvcp_plugin_dashboard_post()
    {
        require_once plugin_dir_path( __FILE__ ) . 'partials/pvcp-plugin-dashboard-post.php';
    }
    
    /**
     * Redirect to Welcome screen after plugin activation.
     *
     * @since    1.0.0
     */
    public function pvcp_welcome_screen_redirect()
    {
        ob_start();
        // if no activation redirect
        if ( !get_transient( '_welcome_screen_activation_redirect_pvcp' ) ) {
            return;
        }
        // Delete the redirect transient
        delete_transient( '_welcome_screen_activation_redirect_pvcp' );
        // if activating from network, or bulk
        $activate_multi = filter_input( INPUT_GET, 'activate-multi', FILTER_SANITIZE_STRING );
        if ( is_network_admin() || isset( $activate_multi ) ) {
            return;
        }
        // Redirect to extra cost welcome  page
        wp_safe_redirect( add_query_arg( array(
            'page' => 'pvcp-get-started',
        ), admin_url( 'admin.php' ) ) );
        exit;
    }
    
    /**
     * Remove submenus from being display in admin section.
     *
     * @since    1.0.0
     */
    public function pvcp_remove_admin_submenus()
    {
        remove_submenu_page( 'dots_store', 'pvcp-get-started' );
        remove_submenu_page( 'dots_store', 'pvcp-quick-information' );
        remove_submenu_page( 'dots_store', 'pvcp-add-new' );
        remove_submenu_page( 'dots_store', 'pvcp-edit-wizard' );
        remove_submenu_page( 'dots_store', 'pvcp-wizard-setting' );
        remove_submenu_page( 'dots_store', 'pvcp-settings' );
        remove_submenu_page( 'dots_store', 'pvcp-main-dashboard' );
        remove_submenu_page( 'dots_store', 'pvcp-dashboard-page' );
        remove_submenu_page( 'dots_store', 'pvcp-dashboard-post' );
    }
    
    /**
     * Current auto increment id for wizard table
     *
     * @since    1.0.0
     *
     * @param string $table_name Wizard table name.
     *
     * @return int
     */
    public function pvcp_get_current_auto_increment_id( $table_name )
    {
        global  $wpdb ;
        $get_current_auto_incr_rows = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s', DB_NAME, $table_name ) );
        //db call ok; no-cache ok
        $current_auto_incr_id = $get_current_auto_incr_rows->AUTO_INCREMENT;
        return $current_auto_incr_id;
    }
    
    /**
     * Generate auto shortcode for Page Visit Counter Wizard
     *
     * @since    1.0.0
     *
     * @param int $current_auto_incr_id Current auto increment wizard id.
     *
     * @return string
     */
    public function pvcp_create_wizard_shortcode( $current_auto_incr_id )
    {
        $current_shortcode = '[pvcp_' . $current_auto_incr_id . ']';
        return $current_shortcode;
    }
    
    /**
     * Save general wizard setting post data
     *
     * @since    1.0.0
     *
     * @param WP_Post $post
     * @param $extra_param extra parameter
     *
     * @return boolean $post if post not exit
     */
    public function pvcp_general_setting_save( $post, $extra_param )
    {
        if ( empty($post) ) {
            return false;
        }
        
        if ( $extra_param === 'general-setting' ) {
            if ( !is_serialized( $post ) ) {
                $general_setting_data = maybe_serialize( $post );
            }
            update_option( 'pvcp_general_settings', $general_setting_data );
        }
        
        $redirectUrl = html_entity_decode( esc_url( admin_url( '/admin.php?page=pvcp-settings' ) ) );
        wp_safe_redirect( $redirectUrl );
        exit;
    }
    
    /**
     * Save wizard shortcode data
     *
     * @since    1.0.0
     *
     * @param WP_Post $post
     * @param $extra_param extra parameter
     * @param $wizard_id id of the wizard
     *
     * @return boolean $post if post not exit
     */
    public function pvcp_wizard_save( $post, $extra_param, $wizard_id )
    {
        global  $wpdb ;
        if ( empty($post) ) {
            return false;
        }
        $pvcpwznonce = wp_create_nonce( 'pvcpwznonce' );
        
        if ( isset( $post['wizard_status'] ) && !empty($post['wizard_status']) ) {
            $wizard_status = 'on';
        } else {
            $wizard_status = 'off';
        }
        
        
        if ( $extra_param === 'add' ) {
            if ( isset( $post['wizard_title'] ) ) {
                
                if ( $wizard_id === '' ) {
                    $wpdb->query( $wpdb->prepare(
                        "INSERT INTO {$wpdb->prefix}page_visit_wizard ( name, wizard_setting, shortcode, status, created_date, updated_date ) VALUES (  %s, %s, %s, %s, %s, %s  )",
                        trim( stripslashes( sanitize_text_field( $post['wizard_title'] ) ) ),
                        '',
                        trim( sanitize_text_field( $post['wizard_shortcode'] ) ),
                        trim( $wizard_status ),
                        date( "Y-m-d H:i:s" ),
                        date( "Y-m-d H:i:s" )
                    ) );
                    //db call ok; no-cache ok
                    $last_wizard_id = $wpdb->insert_id;
                } else {
                    $check_wizard_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}page_visit_wizard  WHERE ID = %d AND shortcode = %s", intval( $wizard_id ), trim( sanitize_text_field( $post['wizard_shortcode'] ) ) ) );
                    //db call ok; no-cache ok
                    
                    if ( !empty($check_wizard_rows) ) {
                        $wpdb->query( $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}page_visit_wizard SET name = %s, wizard_setting=%s, shortcode=%s, status=%s, created_date=%s, updated_date=%s WHERE id = %d",
                            trim( stripslashes( sanitize_text_field( $post['wizard_title'] ) ) ),
                            '',
                            trim( sanitize_text_field( $post['wizard_shortcode'] ) ),
                            trim( $wizard_status ),
                            date( "Y-m-d H:i:s" ),
                            date( "Y-m-d H:i:s" ),
                            intval( $wizard_id )
                        ) );
                        //db call ok; no-cache ok
                        $last_wizard_id = intval( sanitize_text_field( wp_unslash( $wizard_id ) ) );
                    } else {
                        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}page_visit_wizard WHERE ID=%d", $wizard_id ) );
                        //db call ok; no-cache ok
                        
                        if ( !empty($get_rows) && isset( $get_rows ) ) {
                            $get_wizard_id = esc_attr( $get_rows->ID );
                            $wizard_shortcode = esc_attr( $get_rows->shortcode );
                        }
                        
                        $wpdb->query( $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}page_visit_wizard SET name = %s, shortcode=%s, status=%s, created_date=%s, updated_date=%s WHERE ID = %d",
                            trim( stripslashes( sanitize_text_field( $post['wizard_title'] ) ) ),
                            trim( sanitize_text_field( $wizard_shortcode ) ),
                            trim( $wizard_status ),
                            date( "Y-m-d H:i:s" ),
                            date( "Y-m-d H:i:s" ),
                            intval( $get_wizard_id )
                        ) );
                        //db call ok; no-cache ok
                        $last_wizard_id = intval( sanitize_text_field( wp_unslash( $wizard_id ) ) );
                    }
                
                }
            
            }
        } elseif ( $extra_param === 'general-setting' ) {
            if ( !is_serialized( $post ) ) {
                $general_setting_data = maybe_serialize( $post );
            }
            update_option( 'pvcp_general_settings', $general_setting_data );
        } else {
            if ( !is_serialized( $post ) ) {
                $wizard_setting_data = maybe_serialize( $post );
            }
            $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}page_visit_wizard SET wizard_setting=%s WHERE ID = %d", $wizard_setting_data, intval( $wizard_id ) ) );
            //db call ok; no-cache ok
            $last_wizard_id = intval( sanitize_text_field( wp_unslash( $wizard_id ) ) );
        }
        
        $latest_url = esc_url( admin_url( '/admin.php?page=pvcp-list' ) );
        $newUrl = html_entity_decode( $latest_url );
        wp_safe_redirect( $newUrl );
        exit;
    }
    
    /**
     * Reset all page count and report.
     *
     * @since    1.0.0
     */
    public function pvcp_reset_all()
    {
        global  $wpdb ;
        $reset_result_history = $wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}page_visit_history" );
        //db call ok; no-cache ok
        $reset_result_referer = $wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}wp_page_visit_referer" );
        //db call ok; no-cache ok
        
        if ( $reset_result_history === 1 && $reset_result_referer === 1 ) {
            echo  esc_html__( 'true', PVCP_TEXT_DOMAIN ) ;
            wp_die();
        }
    
    }
    
    /**
     * Generate metabox for Page Visit Counter
     *
     * @since 1.0.0
     *
     *@uses custom_meta_box_markup_page_visit()
     *
     */
    public function pvcp_add_custom_meta_box()
    {
        $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
        
        if ( isset( $general_wizard_setting['pvcp_general_post_type'] ) && !empty($general_wizard_setting['pvcp_general_post_type']) ) {
            $i = 1;
            foreach ( $general_wizard_setting['pvcp_general_post_type'] as $post_single ) {
                add_meta_box(
                    "header-meta-box-page-visit-{$i}",
                    "Page Visit Counter",
                    "custom_meta_box_markup_page_visit",
                    $post_single,
                    "side",
                    "high",
                    null
                );
                $i++;
            }
        } else {
            $i = 1;
            // Get all the registered post type
            $all_post = get_post_types();
            foreach ( $all_post as $post_single ) {
                add_meta_box(
                    "header-meta-box-page-visit-{$i}",
                    "Page Visit Counter",
                    "custom_meta_box_markup_page_visit",
                    $post_single,
                    "side",
                    "high",
                    null
                );
                $i++;
            }
        }
        
        function custom_meta_box_markup_page_visit( $object )
        {
            global  $wpdb ;
            $post_id = get_the_ID();
            $enable_page_count = get_post_meta( $post_id, "enable_page_count", true );
            $enable_page_count_day_wise = get_post_meta( $post_id, "enable_page_count_day_wise", true );
            $totalPageCount = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE page_id = %s", $post_id ) );
            //db call ok; no-cache ok
            ?>
             <input name="pageidvisit" type="hidden" value="<?php 
            echo  $post_id ;
            ?>">
             <p><?php 
            esc_html_e( 'Do you want to enable page visits count for this page?', PVCP_TEXT_DOMAIN );
            ?></p>
             <p>
                 <?php 
            
            if ( $enable_page_count == '' ) {
                ?>
                     <input type="radio" checked="checked" name="pvcp_meta_page_count" id="pvcp_meta_page_count_yes"
                            value="yes"><?php 
                esc_html_e( 'Yes', PVCP_TEXT_DOMAIN );
                ?>
                     <input type="radio" name="pvcp_meta_page_count" id="pvcp_meta_page_count_no"
                            value="no"><?php 
                esc_html_e( 'No', PVCP_TEXT_DOMAIN );
                ?>
                 <?php 
            } else {
                ?>
                     <input type="radio" <?php 
                if ( $enable_page_count == 'yes' ) {
                    ?> checked="checked" <?php 
                }
                ?>
                            name="pvcp_meta_page_count" id="pvcp_meta_page_count_yes" value="yes"> <?php 
                esc_html_e( 'Yes', PVCP_TEXT_DOMAIN );
                ?>
                     <input type="radio" <?php 
                if ( $enable_page_count == 'no' ) {
                    ?> checked="checked" <?php 
                }
                ?>
                            name="pvcp_meta_page_count" id="pvcp_meta_page_count_no" value="no"> <?php 
                esc_html_e( 'No', PVCP_TEXT_DOMAIN );
            }
            
            ?>
             </p>
             <p><?php 
            esc_html_e( 'Do you want to display today page visits count for this page?', PVCP_TEXT_DOMAIN );
            ?></p>
             <p>
                 <?php 
            
            if ( $enable_page_count_day_wise == '' ) {
                ?>
                     <input type="radio" checked="checked" name="pvcp_meta_page_count_no_for_day" id="pvcp_meta_page_count_no_for_day_yes" value="yes"><?php 
                esc_html_e( 'Yes', PVCP_TEXT_DOMAIN );
                ?>
                     <input type="radio" name="pvcp_meta_page_count_no_for_day" id="pvcp_meta_page_count_no_for_day_no" value="no"><?php 
                esc_html_e( 'No', PVCP_TEXT_DOMAIN );
                ?>
                 <?php 
            } else {
                ?>
                     <input type="radio" <?php 
                if ( $enable_page_count_day_wise == 'yes' ) {
                    ?> checked="checked" <?php 
                }
                ?>
                            name="pvcp_meta_page_count_no_for_day" id="pvcp_meta_page_count_no_for_day_yes" value="yes"> <?php 
                esc_html_e( 'Yes', PVCP_TEXT_DOMAIN );
                ?>
                     <input type="radio" <?php 
                if ( $enable_page_count_day_wise == 'no' ) {
                    ?> checked="checked" <?php 
                }
                ?>
                            name="pvcp_meta_page_count_no_for_day" id="pvcp_meta_page_count_no_for_day_no" value="no"><?php 
                esc_html_e( 'No', PVCP_TEXT_DOMAIN );
            }
            
            ?>
             </p>
             <p><?php 
            echo  esc_html__( 'Do you want to reset all visits count for this page?', PVCP_TEXT_DOMAIN ) ;
            ?></p>
             <p>
                 <input type="radio" name="pvcp_meta_page_visit_reset" id="pvcp_meta_page_visit_reset_yes"
                        value="yes"><?php 
            esc_html_e( 'Yes', PVCP_TEXT_DOMAIN );
            ?>
                 <input type="radio" checked="checked" name="pvcp_meta_page_visit_reset" id="pvcp_meta_page_visit_reset_no"
                        value="no"><?php 
            esc_html_e( 'No', PVCP_TEXT_DOMAIN );
            ?>
             </p>
             <p id="total_page_visits_after_update">
                 <?php 
            esc_html_e( 'Total visits:', PVCP_TEXT_DOMAIN );
            ?>
                 <span><?php 
            echo  esc_html( $totalPageCount ) ;
            ?></span>
             </p>
            <?php 
        }
    
    }
    
    /**
     * Save metabox value for Page Visit Counter
     *
     * @since 1.0.0
     *
     * @param $post_id
     *
     * @return boolean $post_id if user edit-post or auto save not exit
     *
     */
    public function pvcp_add_custom_meta_box_save( $post_id )
    {
        global  $wpdb ;
        if ( !current_user_can( "edit_post", $post_id ) ) {
            return $post_id;
        }
        if ( defined( "DOING_AUTOSAVE" ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        if ( isset( $_POST["pvcp_meta_page_count"] ) ) {
            update_post_meta( $post_id, "enable_page_count", $_POST["pvcp_meta_page_count"] );
        }
        if ( isset( $_POST["pvcp_meta_page_count_no_for_day"] ) ) {
            update_post_meta( $post_id, "enable_page_count_day_wise", $_POST["pvcp_meta_page_count_no_for_day"] );
        }
        
        if ( isset( $_POST["pvcp_meta_page_visit_reset"] ) && 'yes' === $_POST["pvcp_meta_page_visit_reset"] ) {
            $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}page_visit_history WHERE page_id = %s", $post_id ) );
            //db call ok; no-cache ok
        }
    
    }
    
    /**
     * Get column head title in wordpress admin
     *
     * @since    1.0.0
     *
     * @return  string
     */
    public function pvcp_columns_head( $defaults )
    {
        $defaults['hits'] = esc_html__( 'Hits', PVCP_TEXT_DOMAIN );
        return $defaults;
    }
    
    /**
     * Get column head content in wordpress admin
     *
     * @param  string $column_name
     * @param  int $post_ID
     *
     * @since    1.0.0
     *
     */
    public function pvcp_columns_content( $column_name, $post_ID )
    {
        
        if ( $column_name == 'hits' ) {
            global  $wpdb ;
            $post_result = get_post( $post_ID );
            
            if ( 'post' === $post_result->post_type ) {
                $type = 'post';
            } else {
                $type = 'page';
            }
            
            $pageCount = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE page_id = %d", $post_ID ) );
            
            if ( $pageCount ) {
                echo  '<a href="' . esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page&duration=30&type=' . $type . '&page_id=' . esc_attr( $post_ID ) ) ) . '">' . esc_html( $pageCount ) . '</a>' ;
            } else {
                echo  "0" ;
            }
        
        }
    
    }
    
    /**
     * Get Browser history
     *
     * @since    1.0.0
     *
     * @uses pvcp_month_compare()
     *
     * @return  string
     */
    public function pvcp_dashboard_summary()
    {
        global  $wpdb ;
        $all_row_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}page_visit_history" );
        //db call ok; no-cache ok
        // get browser list
        $browser = $wpdb->get_results( "SELECT count(id) AS browser_count,browser_short_name FROM {$wpdb->prefix}page_visit_history GROUP BY browser_short_name" );
        //db call ok; no-cache ok
        $browser_arr = array();
        if ( $browser ) {
            foreach ( $browser as $dash_browser ) {
                $browser_count = $dash_browser->browser_count;
                $browser_count_perc = round( $browser_count * 100 / $all_row_count );
                $browser_short_name = $dash_browser->browser_short_name;
                $browser_arr[] = array(
                    "label" => $browser_short_name,
                    "y"     => $browser_count_perc,
                );
            }
        }
        // get operating system list
        $os = $wpdb->get_results( "SELECT count(id) AS os_count,os FROM {$wpdb->prefix}page_visit_history GROUP BY os" );
        //db call ok; no-cache ok
        $os_arr = array();
        if ( $os ) {
            foreach ( $os as $dash_os ) {
                $os_count = $dash_os->os_count;
                $os_count_perc = round( $os_count * 100 / $all_row_count );
                $os_name = $dash_os->os;
                $os_arr[] = array(
                    "label" => $os_name,
                    "y"     => $os_count_perc,
                );
            }
        }
        $resultsArr = array();
        $resultsArr['topBrowser'] = $browser_arr;
        $resultsArr['topOs'] = $os_arr;
        echo  wp_json_encode( $resultsArr, JSON_NUMERIC_CHECK ) ;
        unset( $resultsArr );
        die;
    }
    
    /**
     * Get last 'n' day date
     *
     * @since    1.0.0
     *
     * @return  array
     */
    public function pvcp_get_last_n_days( $days, $format = 'Y-m-d' )
    {
        $m = date( "m" );
        $de = date( "d" );
        $y = date( "Y" );
        $dateArray = array();
        for ( $i = 0 ;  $i <= $days - 1 ;  $i++ ) {
            $dateArray[] = date( $format, mktime(
                0,
                0,
                0,
                $m,
                $de - $i,
                $y
            ) );
        }
        return array_reverse( $dateArray );
    }
    
    /**
     * Get Page history
     *
     * @since    1.0.0
     *
     * @uses pvcp_get_last_n_days()
     *
     * @return  string
     */
    public function pvcp_page_summary()
    {
        global  $wpdb ;
        $page_id_wpnonce = filter_input( INPUT_GET, 'page_id', FILTER_SANITIZE_STRING );
        $page_id = ( !empty($page_id_wpnonce) ? sanitize_text_field( $page_id_wpnonce ) : '' );
        $type_wpnonce = filter_input( INPUT_GET, 'type', FILTER_SANITIZE_STRING );
        $type = ( !empty($type_wpnonce) ? sanitize_text_field( $type_wpnonce ) : '' );
        $duration_wpnonce = filter_input( INPUT_GET, 'duration', FILTER_SANITIZE_STRING );
        $duration = ( !empty($duration_wpnonce) ? sanitize_text_field( $duration_wpnonce ) : 30 );
        // get page list
        $currentDate = date( "Y-m-d" );
        $lastDay = date( "Y-m-d", strtotime( "-" . $duration . " days" ) );
        // last n'th day date
        $pages_record = $wpdb->get_results( $wpdb->prepare(
            "SELECT date,count(date) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type = %s  AND page_id = %d AND date BETWEEN %s AND %s GROUP BY date ORDER BY date ASC",
            $type,
            $page_id,
            $lastDay,
            $currentDate
        ) );
        //db call ok; no-cache ok
        $last_nth_day_date = $this->pvcp_get_last_n_days( $duration );
        $page_date_arr = array();
        $page_visitor_arr = array();
        $page_arr = array();
        foreach ( $pages_record as $record ) {
            $page_date = strtotime( $record->date ) * 1000;
            $page_visitor = $record->visit;
            $page_date_arr[] = $record->date;
            $page_visitor_arr[] = $record->visit;
            $page_arr[] = array(
                "x" => $page_date,
                "y" => $page_visitor,
            );
        }
        $remaining_date = array_diff( $last_nth_day_date, $page_date_arr );
        $max_visitor = ( max( $page_visitor_arr ) > 5 ? max( $page_visitor_arr ) + 5 : '5' );
        foreach ( $remaining_date as $r_info ) {
            $r_date = strtotime( $r_info ) * 1000;
            $page_arr[] = array(
                "x" => $r_date,
                "y" => 0,
            );
        }
        $orderByDate = $my2 = array();
        foreach ( $page_arr as $key => $row ) {
            $my2 = explode( '/', $row['x'] );
            $my_date2 = $my2[1] . '/' . $my2[0] . '/' . $my2[2];
            $orderByDate[$key] = strtotime( $my_date2 );
        }
        array_multisort( $orderByDate, SORT_DESC, $page_arr );
        $resultsArr = array();
        $resultsArr['data'] = $page_arr;
        $resultsArr['max_count'] = $max_visitor;
        echo  wp_json_encode( $resultsArr, JSON_NUMERIC_CHECK ) ;
        unset( $resultsArr );
        die;
    }
    
    /**
     * Get Page Report
     *
     * @since    1.0.0
     *
     * @return  string
     */
    public function pvcp_page_summary_report()
    {
        global  $wpdb ;
        // monthly report
        $top_pages_id = $wpdb->get_results( "SELECT page_id FROM {$wpdb->prefix}page_visit_history WHERE type NOT IN ('post') GROUP BY page_id ORDER BY COUNT(id) DESC LIMIT 10" );
        //db call ok; no-cache ok
        
        if ( $top_pages_id ) {
            $currentDate = date( "Y-m-d" );
            // current date
            $lastMonth = date( "Y-m-d", strtotime( "-30 days" ) );
            // last 30 day date
            $last_30_days_arr = $this->pvcp_get_last_n_days( '30' );
            // last 30 day array
            $resultsArr = array();
            foreach ( $top_pages_id as $page_id ) {
                $page_date_arr = array();
                $page_visitor_arr = array();
                $page_report_arr = array();
                $pages_record = $wpdb->get_results( $wpdb->prepare(
                    "SELECT date,count(date) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type NOT IN (%s) AND page_id = %d AND date BETWEEN %s AND %s GROUP BY date ORDER BY date ASC",
                    'post',
                    $page_id->page_id,
                    $lastMonth,
                    $currentDate
                ) );
                //db call ok; no-cache ok
                foreach ( $pages_record as $record ) {
                    $page_date = strtotime( $record->date ) * 1000;
                    $page_visitor = $record->visit;
                    $page_date_arr[] = $record->date;
                    $page_visitor_arr[] = $record->visit;
                    $page_report_arr[] = array(
                        "x" => $page_date,
                        "y" => $page_visitor,
                    );
                }
                $remaining_day = array_diff( $last_30_days_arr, $page_date_arr );
                foreach ( $remaining_day as $r_info ) {
                    $r_date = strtotime( $r_info ) * 1000;
                    $page_report_arr[] = array(
                        "x" => $r_date,
                        "y" => 0,
                    );
                }
                $orderByDate = $my2 = array();
                foreach ( $page_report_arr as $key => $row ) {
                    $my2 = explode( '/', $row['x'] );
                    $my_date2 = $my2[1] . '/' . $my2[0] . '/' . $my2[2];
                    $orderByDate[$key] = strtotime( $my_date2 );
                }
                array_multisort( $orderByDate, SORT_DESC, $page_report_arr );
                $resultsArr[get_the_title( $page_id->page_id )] = $page_report_arr;
            }
            echo  wp_json_encode( $resultsArr, JSON_NUMERIC_CHECK ) ;
            unset( $resultsArr );
        }
        
        die;
    }
    
    /**
     * Get Post Report
     *
     * @since    1.0.0
     *
     * @return  array/object
     */
    public function pvcp_post_summary_report()
    {
        global  $wpdb ;
        // monthly report
        $top_posts_id = $wpdb->get_results( $wpdb->prepare( "SELECT page_id FROM {$wpdb->prefix}page_visit_history WHERE type = %s GROUP BY page_id ORDER BY COUNT(id) DESC LIMIT 10", 'post' ) );
        //db call ok; no-cache ok
        
        if ( $top_posts_id ) {
            $currentDate = date( "Y-m-d" );
            // current date
            $lastMonth = date( "Y-m-d", strtotime( "-30 days" ) );
            // last 30 day date
            $last_30_days_arr = $this->pvcp_get_last_n_days( '30' );
            // last 30 day array
            $resultsArr = array();
            foreach ( $top_posts_id as $post_id ) {
                $post_date_arr = array();
                $post_visitor_arr = array();
                $post_report_arr = array();
                $posts_record = $wpdb->get_results( $wpdb->prepare(
                    "SELECT date,count(date) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type = %s AND page_id = %d AND date BETWEEN %s AND %s GROUP BY date ORDER BY date ASC",
                    'post',
                    $post_id->page_id,
                    $lastMonth,
                    $currentDate
                ) );
                //db call ok; no-cache ok
                foreach ( $posts_record as $record ) {
                    $post_date = strtotime( $record->date ) * 1000;
                    $post_visitor = $record->visit;
                    $post_date_arr[] = $record->date;
                    $post_visitor_arr[] = $record->visit;
                    $post_report_arr[] = array(
                        "x" => $post_date,
                        "y" => $post_visitor,
                    );
                }
                $remaining_day = array_diff( $last_30_days_arr, $post_date_arr );
                foreach ( $remaining_day as $r_info ) {
                    $r_date = strtotime( $r_info ) * 1000;
                    $post_report_arr[] = array(
                        "x" => $r_date,
                        "y" => 0,
                    );
                }
                $orderByDate = $my2 = array();
                foreach ( $post_report_arr as $key => $row ) {
                    $my2 = explode( '/', $row['x'] );
                    $my_date2 = $my2[1] . '/' . $my2[0] . '/' . $my2[2];
                    $orderByDate[$key] = strtotime( $my_date2 );
                }
                array_multisort( $orderByDate, SORT_DESC, $post_report_arr );
                $resultsArr[get_the_title( $post_id->page_id )] = $post_report_arr;
            }
            echo  wp_json_encode( $resultsArr, JSON_NUMERIC_CHECK ) ;
            unset( $resultsArr );
        }
        
        die;
    }

}