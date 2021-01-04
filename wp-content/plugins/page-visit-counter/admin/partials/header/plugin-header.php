<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global  $pvc_fs ;
$plugin_name = PVCP_PLUGIN_NAME;
$plugin_version = PVCP_VERSION;
$current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
$pvcp_list = ( isset( $current_page ) && 'pvcp-list' === $current_page || 'pvcp-edit-wizard' === $current_page || 'pvcp-add-new' === $current_page || 'pvcp-wizard-setting' === $current_page ? 'active' : '' );
$pvcp_add_new = ( isset( $current_page ) && 'pvcp-add-new' === $current_page ? 'active' : '' );
$pvcp_settings = ( isset( $current_page ) && 'pvcp-settings' === $current_page ? 'active' : '' );
$pvcp_getting_started = ( isset( $current_page ) && 'pvcp-get-started' === $current_page ? 'active' : '' );
$pvcp_quick_info = ( isset( $current_page ) && 'pvcp-quick-information' === $current_page ? 'active' : '' );
$pvcp_abount_plugin = ( isset( $current_page ) && 'pvcp-quick-information' === $current_page || isset( $current_page ) && 'pvcp-get-started' === $current_page ? 'active' : '' );
$pvcp_list_dashboard = ( isset( $current_page ) && 'pvcp-main-dashboard' === $current_page ? 'active' : '' );
$pvcp_page_summary = ( isset( $current_page ) && 'pvcp-dashboard-page' === $current_page ? 'active' : '' );
$pvcp_post_summary = ( isset( $current_page ) && 'pvcp-dashboard-post' === $current_page ? 'active' : '' );
$pvcp_action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );

if ( isset( $pvcp_action ) && !empty($pvcp_action) ) {
    if ( 'add' === $pvcp_action || 'edit' === $pvcp_action ) {
        $pvcp_add_new = 'active';
    }
    
    if ( 'edit' === $pvcp_action && 'pvcp-edit-wizard' === $pvcp_action ) {
        $wizard_id = ( empty($_REQUEST['wizard_id']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['wizard_id'] ) ) );
        $pvcpnonce = ( empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );
        $wizard_header_title = EDIT_WIZARD;
        $wizard_header_url = esc_url( site_url( '/wp-admin/admin.php?page=pvcp-edit-wizard&wizard_id=' . esc_attr( $wizard_id ) . '&action=edit' . '&_wpnonce=' . esc_attr( $pvcpnonce ) ) );
    } else {
        $wizard_header_title = ADD_NEW_WIZARD;
        $wizard_header_url = esc_url( site_url( '/wp-admin/admin.php?page=pvcp-add-new' ) );
    }

} else {
    $wizard_header_title = ADD_NEW_WIZARD;
    $wizard_header_url = esc_url( site_url( '/wp-admin/admin.php?page=pvcp-add-new' ) );
}

?>

<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/pvcp-icon.png' ) ;
?>">
            </div>
            <div class="dots-header-right">
                <div class="logo-detail">
                    <strong><?php 
esc_html_e( $plugin_name );
?> </strong>
                    <span><?php 
esc_html_e( PVCP_VERSION_TEXT, PVCP_TEXT_DOMAIN );
?> <?php 
esc_html_e( PVCP_VERSION );
?></span>
                </div>
                <div class="button-group">
                    <?php 
?>
                        <div class="button-dots-left">
                                <span class="support_dotstore_image"><a target="_blank" href="<?php 
echo  $pvc_fs->get_upgrade_url() ;
?>">
                                        <img src="<?php 
echo  PVCP_PLUGIN_URL . 'admin/images/upgrade_new.png' ;
?>"></a>
                                </span>
                        </div>
                        <?php 
?>
                    <div class="button-dots">
                        <span class="support_dotstore_image"><a target="_blank" href="<?php 
echo  esc_url( 'http://www.thedotstore.com/support/' ) ;
?>">
                                <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/support_new.png' ) ;
?>"></a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_list_dashboard ) ;
?>"  href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-main-dashboard' ) ) ;
?>"><?php 
esc_html_e( 'Dashboard', PVCP_TEXT_DOMAIN );
?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_page_summary ) ;
?>"  href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page' ) ) ;
?>"><?php 
esc_html_e( 'Page Summary', PVCP_TEXT_DOMAIN );
?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_post_summary ) ;
?>"  href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-post' ) ) ;
?>"><?php 
esc_html_e( 'Post Summary', PVCP_TEXT_DOMAIN );
?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_list ) ;
?>"  href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-list' ) ) ;
?>"><?php 
esc_html_e( LIST_PAGE_TITLE, PVCP_TEXT_DOMAIN );
?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_settings ) ;
?>"  href="<?php 
echo  esc_url( admin_url( '/admin.php?page=pvcp-settings' ) ) ;
?>"> <?php 
esc_html_e( 'Setting', PVCP_TEXT_DOMAIN );
?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_abount_plugin ) ;
?>"  href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-get-started' ) ) ;
?>"><?php 
esc_html_e( ABOUT_PLUGIN, PVCP_TEXT_DOMAIN );
?></a>
                            <ul class="sub-menu">
                                <li><a  class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_getting_started ) ;
?>" href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-get-started' ) ) ;
?>"><?php 
esc_html_e( GETTING_STARTED, PVCP_TEXT_DOMAIN );
?></a></li>
                                <li><a class="dotstore_plugin <?php 
echo  esc_attr( $pvcp_quick_info ) ;
?>" href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-quick-information' ) ) ;
?>"><?php 
esc_html_e( QUICK_INFO, PVCP_TEXT_DOMAIN );
?></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dotstore_plugin" target="_blank" href="https://www.thedotstore.com/woocommerce-plugins/"><?php 
esc_html_e( 'Dotstore', PVCP_TEXT_DOMAIN );
?></a>
                            <ul class="sub-menu">
                                <li><a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/woocommerce-plugins" ) ;
?>"><?php 
esc_html_e( 'WooCommerce Plugins', PVCP_TEXT_DOMAIN );
?></a></li>
                                <li><a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/wordpress-plugins" ) ;
?>"><?php 
esc_html_e( 'WordPress Plugins', PVCP_TEXT_DOMAIN );
?></a></li><br>
                                <li><a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/support" ) ;
?>"><?php 
esc_html_e( 'Contact Support', PVCP_TEXT_DOMAIN );
?></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

        </header>