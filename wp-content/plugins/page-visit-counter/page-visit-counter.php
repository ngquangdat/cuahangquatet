<?php

/*
 * @link              https://www.thedotstore.com/
 * @since             1.0.0
 * @package           Page_Visit_Counter
 *
 * @wordpress-plugin
 * Plugin Name: Page Visit Counter
 * Plugin URI:        https://www.thedotstore.com/page-visit-counter/
 * Description:       This plugin will count the total visits of the pages of your site.
 * Version:           6.0.8
 * Author:            theDotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * WC tested up to: 4.5
 */
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'pvc_fs' ) ) {
    pvc_fs()->set_basename( false, __FILE__ );
    return;
}


if ( !function_exists( 'pvc_fs' ) ) {
    // Create a helper function for easy SDK access.
    function pvc_fs()
    {
        global  $pvc_fs ;
        
        if ( !isset( $pvc_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $pvc_fs = fs_dynamic_init( array(
                'id'             => '4453',
                'slug'           => 'page-visit-counter',
                'type'           => 'plugin',
                'public_key'     => 'pk_e7705ac1700ddfca594652ad4470e',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'       => 'pvcp-get-started',
                'first-path' => 'admin.php?page=pvcp-get-started',
                'contact'    => false,
                'support'    => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $pvc_fs;
    }
    
    // Init Freemius.
    pvc_fs();
    // Signal that SDK was initiated.
    do_action( 'pvc_fs_loaded' );
}

if ( !defined( 'PVCP_VERSION' ) ) {
    define( 'PVCP_VERSION', '6.0.8' );
}
if ( !defined( 'PVCP_PLUGIN_URL' ) ) {
    define( 'PVCP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'PVCP_PLUGIN_DIR' ) ) {
    define( 'PVCP_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( !defined( 'PVCP_PLUGIN_DIR_PATH' ) ) {
    define( 'PVCP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'PVCP_PLUGIN_BASENAME' ) ) {
    define( 'PVCP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
/** The code that runs during plugin activation.
 *
 * @package Page_Visit_Counter
 * @since 1.0.0
 */
function activate_page_visit_counter()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-page-visit-counter-activator.php';
    Page_Visit_Counter_Activator::activate();
}

/** The code that runs during plugin deactivation.
 *
 * @package Page_Visit_Counter
 * @since 1.0.0
 */
function deactivate_page_visit_counter()
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-page-visit-counter-deactivator.php';
    Page_Visit_Counter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_page_visit_counter' );
register_deactivation_hook( __FILE__, 'deactivate_page_visit_counter' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-page-visit-counter.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_page_visit_counter()
{
    $plugin = new Page_Visit_Counter();
    $plugin->run();
}

run_page_visit_counter();
/**
 * Get individual  page visit count
 *
 * @since     1.0.0
 * @return    string
 */
function page_visit_counter_md_page_visit( $atts, $content, $tag )
{
    global  $wpdb ;
    $current_page_id = get_the_ID();
    $type = get_post_type( $current_page_id );
    $shortcodes = '[' . $tag . ']';
    $wzResult = $wpdb->get_results( $wpdb->prepare( "SELECT wizard_setting,status FROM {$wpdb->prefix}page_visit_wizard WHERE shortcode = %s", $shortcodes ) );
    //db call ok; no-cache ok
    $totalVisitsHtml = '';
    // get individual wizard setting
    $page_wizards = maybe_unserialize( $wzResult[0]->wizard_setting );
    // get individual wizard status
    $page_status = $wzResult[0]->status;
    $page_meta_value = get_post_meta( $current_page_id, 'enable_page_count' );
    $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
    // get general wizard setting
    
    if ( 'on' === $page_status && (empty($page_meta_value) || in_array( 'yes', $page_meta_value )) && (empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] )) ) {
        // get title
        
        if ( !empty($general_wizard_setting['pvcp_general_title']) ) {
            $title = $general_wizard_setting['pvcp_general_title'];
        } else {
            $title = 'Total Page Visits';
        }
        
        // get background color
        
        if ( isset( $page_wizards['pvcp_ind_wz_bc_color'] ) && !empty($page_wizards['pvcp_ind_wz_bc_color']) ) {
            $backgroundColor = trim( $page_wizards['pvcp_ind_wz_bc_color'] );
        } elseif ( !empty($general_wizard_setting['pvcp_general_bc_color']) ) {
            $backgroundColor = trim( $general_wizard_setting['pvcp_general_bc_color'] );
        } else {
            $backgroundColor = '#FFFFFF';
        }
        
        // get font color
        
        if ( isset( $page_wizards['pvcp_ind_wz_font_color'] ) && !empty($page_wizards['pvcp_ind_wz_font_color']) ) {
            $fontColor = trim( $page_wizards['pvcp_ind_wz_font_color'] );
        } elseif ( !empty($general_wizard_setting['pvcp_general_font_color']) ) {
            $fontColor = trim( $general_wizard_setting['pvcp_general_font_color'] );
        } else {
            $fontColor = '#000000';
        }
        
        $totalCount = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE  page_id = %d", $current_page_id ) );
        $totalVisitsHtml .= '<div class="page_counter_label"><span class="page_counter_text" style="color:' . esc_attr( $fontColor ) . ';background:' . esc_attr( $backgroundColor ) . ';">' . __( $title, 'page-visit-counter' ) . ': ' . $totalCount . '</span></div>';
    }
    
    return $totalVisitsHtml;
}

add_shortcode( 'pvcp_1', 'page_visit_counter_md_page_visit' );
/**
 * Get total website visit count
 *
 * @since     1.0.0
 * @return    string
 */
function page_visit_counter_md_total_sites_visit()
{
    global  $wpdb ;
    $current_page_id = get_the_ID();
    $type = get_post_type( $current_page_id );
    // get general wizard setting
    $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
    $title = 'Total Website Visits';
    // get background color
    
    if ( !empty($general_wizard_setting['pvcp_general_bc_color']) ) {
        $backgroundColor = trim( $general_wizard_setting['pvcp_general_bc_color'] );
    } else {
        $backgroundColor = '#FFFFFF';
    }
    
    // get font color
    
    if ( !empty($general_wizard_setting['pvcp_general_font_color']) ) {
        $fontColor = trim( $general_wizard_setting['pvcp_general_font_color'] );
    } else {
        $fontColor = '#000000';
    }
    
    $totalWebsiteVisitsHtml = '';
    $totalWebsiteCount = $wpdb->get_var( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history" );
    $totalWebsiteVisitsHtml .= '<div class="page_counter_label"><span class="page_counter_text" style="color:' . esc_attr( $fontColor ) . ';background:' . esc_attr( $backgroundColor ) . ';">' . __( $title, 'page-visit-counter' ) . ': ' . $totalWebsiteCount . '</span></div>';
    return $totalWebsiteVisitsHtml;
}

add_shortcode( 'pvcp_website_count', 'page_visit_counter_md_total_sites_visit' );