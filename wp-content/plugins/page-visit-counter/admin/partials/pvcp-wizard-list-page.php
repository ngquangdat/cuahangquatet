<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
$wizard_post_id = ( empty($_REQUEST['wizard_id']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['wizard_id'] ) ) );
$retrieved_nonce = ( empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );

if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'delete' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'pvcpwznonce' ) ) {
        die( 'Failed security check' );
    }
    $delete_sql = $wpdb->delete( WIZARDS_PRO_TABLE, array(
        'ID' => esc_attr( $wizard_post_id ),
    ), array( '%d' ) );
    //db call ok; no-cache ok
    
    if ( $delete_sql === '1' ) {
        wp_redirect( esc_url( site_url( '/wp-admin/admin.php?page=pvcp-list' ) ) );
        exit;
    } else {
        esc_html_e( 'Something went wrong. Please try again', PVCP_TEXT_DOMAIN );
        wp_redirect( esc_url( site_url( '/wp-admin/admin.php?page=pvcp-list' ) ) );
        exit;
    }

}

$sel_rows_for_page_wizard = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}page_visit_wizard ORDER BY created_date DESC" );
//db call ok; no-cache ok
wp_nonce_field( 'delete' );
?>
<div class="pvcp-main-table res-cl">
    <div class="product_header_title">
        <h2>
            <?php 
esc_html_e( LIST_PAGE_TITLE, PVCP_TEXT_DOMAIN );
?>
            <?php 
?>
                <a class="add-new-btn pvcp-pro-ver"  href="javascript:void(0)"><?php 
esc_html_e( ADD_NEW_WIZARD, PVCP_TEXT_DOMAIN );
?></a>
            <?php 
?>
        </h2>
    </div>
    <table id="wizard-listing" class="table-outer form-table all-table-listing">
        <thead>
            <tr class="pvcp-head">
                <?php 
?>
                <th><?php 
esc_html_e( 'Name', PVCP_TEXT_DOMAIN );
?></th>
                <th><?php 
esc_html_e( 'Shortcode', PVCP_TEXT_DOMAIN );
?></th>
                <th><?php 
esc_html_e( 'Status', PVCP_TEXT_DOMAIN );
?></th>
                <th><?php 
esc_html_e( 'Action', PVCP_TEXT_DOMAIN );
?></th>
            </tr>
        </thead>
        <tbody>

            <tr id="wizard_row_totla_wb">
                <?php 
?>
                <td><?php 
esc_html_e( 'Total Website Visit', PVCP_TEXT_DOMAIN );
?></td>
                <td><?php 
echo  esc_attr( '[pvcp_website_count]' ) ;
?></td>
                <td><?php 
esc_html_e( 'N/A', PVCP_TEXT_DOMAIN );
?></td>
                <td><?php 
esc_html_e( 'N/A', PVCP_TEXT_DOMAIN );
?></td>
            </tr>

            <?php 
// Total page visit wizard

if ( !empty($sel_rows_for_page_wizard) && isset( $sel_rows_for_page_wizard ) && is_array( $sel_rows_for_page_wizard ) ) {
    $i = 1;
    foreach ( $sel_rows_for_page_wizard as $sel_data ) {
        $wizard_id = esc_attr( $sel_data->ID );
        $wizard_title = esc_attr( $sel_data->name );
        $wizard_shortcode = esc_attr( $sel_data->shortcode );
        $wizard_status = esc_attr( $sel_data->status );
        $pvcpnonce = wp_create_nonce( 'pvcpwznonce' );
        ?>
                    <tr id="wizard_row_<?php 
        echo  esc_attr( $wizard_id ) ;
        ?>">
                        <?php 
        ?>
                        <td>
                            <a href="<?php 
        echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-edit-wizard&wizard_id=' . esc_attr( $wizard_id ) . '&action=edit' . '&_wpnonce=' . esc_attr( $pvcpnonce ) ) ) ;
        ?>"><?php 
        esc_html_e( $wizard_title, PVCP_TEXT_DOMAIN );
        ?></a>
                        </td>
                        <td>
                            <?php 
        echo  esc_attr( $wizard_shortcode ) ;
        ?>
                        </td>
                        <td>
                            <?php 
        echo  ( !empty(esc_attr( $wizard_status )) && esc_attr( $wizard_status ) === 'on' ? '<span class="active-status">' . esc_html_e( 'Enabled', PVCP_TEXT_DOMAIN ) . '</span>' : '<span class="inactive-status">' . esc_html_e( 'Disabled', PVCP_TEXT_DOMAIN ) . '</span>' ) ;
        ?>
                        </td>
                        <td>
                            <a class="pvcp-action-button button-primary" href="<?php 
        echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-edit-wizard&wizard_id=' . esc_attr( $wizard_id ) . '&action=edit' . '&_wpnonce=' . esc_attr( $pvcpnonce ) ) ) ;
        ?>"><?php 
        esc_html_e( 'Edit', PVCP_TEXT_DOMAIN );
        ?></a>
                            <?php 
        ?>
                            <a class="pvcp-action-button button-primary setting_single_selected_wizard" href="<?php 
        echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-wizard-setting&wizard_id=' . esc_attr( $wizard_id ) . '&action=setting' . '&_wpnonce=' . esc_attr( $pvcpnonce ) ) ) ;
        ?>" id="setting_single_selected_wizard_<?php 
        echo  esc_attr( $wizard_id ) ;
        ?>" data-attr_name="<?php 
        echo  esc_attr( $wizard_title ) ;
        ?>"><?php 
        esc_html_e( 'Setting', PVCP_TEXT_DOMAIN );
        ?></a> 
                        </td>
                    </tr>
                    <?php 
        $i++;
    }
}

?>
        </tbody>
    </table>
</div>

<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';