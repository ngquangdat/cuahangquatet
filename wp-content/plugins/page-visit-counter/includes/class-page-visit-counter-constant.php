<?php

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The file that defines constant variabes
 *
 * Defines admin side constant.
 *
 * @link       https://www.thedotstore.com/
 * @since      1.0.0
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/includes
 */
global  $wpdb ;
// Define constant for plugin
define( 'PVCP_PLUGIN_SLUG', 'page-visit-counter-pro' );
// Plugin Tables Constant
define( 'WP_TABLE_PREFIX', $wpdb->prefix );
define( 'PVCP_TABLE_PREFIX', "page_visit_" );
define( 'PVCP_PLUGIN_NAME', __( 'Page Visit Counter' ) );
define( 'PVCP_TEXT_DOMAIN', 'page-visit-counter' );
define( 'PVCP_VERSION_TEXT', __( 'Free Version' ) );
define( 'HISTORY_TABLE', WP_TABLE_PREFIX . PVCP_TABLE_PREFIX . "history" );
define( 'REFERER_TABLE', WP_TABLE_PREFIX . PVCP_TABLE_PREFIX . "referer" );
define( 'WIZARDS_TABLE', WP_TABLE_PREFIX . PVCP_TABLE_PREFIX . "wizard" );
// Header Section
define( 'GENERAL_SETTING_PAGE_TITLE', 'General Setting' );
define( 'ABOUT_PLUGIN', 'About Plugin' );
define( 'GETTING_STARTED', 'Getting Started' );
define( 'QUICK_INFO', 'Quick info' );
// Button Names
define( 'ADD_NEW_WIZARD_SAVE_BUTTON_NAME', "Save & Continue" );
define( 'EDIT_NEW_WIZARD_SAVE_BUTTON_NAME', "Update" );
// Wizard Page Constant
define( 'LIST_PAGE_TITLE', 'Manage Wizards' );
define( 'DELETE_LIST_NAME', 'Delete ( Selected )' );
define( 'ADD_NEW_WIZARD', 'Add New Wizard' );
define( 'EDIT_WIZARD', 'Edit Wizard' );
define( 'BACK_TO_WIZARD_LIST', 'Back to wizard list' );
define( 'BACK_TO_EDIT_WIZARD_CONFIGURATION', 'Back to wizard configuration' );
define( 'WIZARD_TITLE', 'Wizard Title' );
define( 'WIZARD_TITLE_PLACEHOLDER', 'Enter Wizard Title Here' );
define( 'WIZARD_TITLE_DESCRIPTION', 'Wizard title will display in front side.' );
define( 'WIZARD_CATEGORY_TITLE', 'Wizard Category' );
define( 'WIZARD_CATEGORY_TITLE_PLACEHOLDER', 'Select Wizard Category' );
define( 'WIZARD_CATEGORY_TITLE_DESCRIPTION', 'If you select category, then product will display based on these selected category.' );
define( 'WIZARD_SHORTCODE', 'Wizard Shortcode' );
define( 'WIZARD_SHORTCODE_DESCRIPTION', 'Paste shortcode in that page where you want to configure recommendation wizard' );
define( 'WIZARD_STATUS', 'Status' );
define( 'NO_DATA_FOUND', 'No Data Found' );