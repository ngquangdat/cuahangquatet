<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
$wizard_id = ( empty($_REQUEST['wizard_id']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['wizard_id'] ) ) );
$retrieved_nonce = ( empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );
$wizard_title = '';
$wizard_shortcode = '';
$wizard_status = '';
$btnValue = __( ADD_NEW_WIZARD_SAVE_BUTTON_NAME, PVCP_TEXT_DOMAIN );
if ( isset( $_POST['submitWizard'] ) && sanitize_text_field( wp_unslash( $_POST['submitWizard'] ) ) === EDIT_NEW_WIZARD_SAVE_BUTTON_NAME ) {
    
    if ( !wp_verify_nonce( $retrieved_nonce, 'wizardfrm' ) ) {
        die( 'Failed security check' );
    } else {
        $data_post = $_POST;
        if ( method_exists( $this, 'pvcp_wizard_save' ) ) {
            $this->pvcp_wizard_save( $data_post, 'add', $data_post['wizard_post_id'] );
        }
    }

}
if ( isset( $_REQUEST['action'] ) && sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) === 'edit' ) {
    
    if ( !wp_verify_nonce( $retrieved_nonce, 'pvcpwznonce' ) ) {
        die( 'Failed security check' );
    } else {
        $btnValue = __( EDIT_NEW_WIZARD_SAVE_BUTTON_NAME, PVCP_TEXT_DOMAIN );
        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}page_visit_wizard WHERE ID=%d", $wizard_id ) );
        //db call ok; no-cache ok
        
        if ( !empty($get_rows) && isset( $get_rows ) ) {
            $get_wizard_id = esc_attr( $get_rows->ID );
            $wizard_title = esc_attr( $get_rows->name );
            $wizard_shortcode = esc_attr( $get_rows->shortcode );
            $wizard_status = esc_attr( $get_rows->status );
        }
    
    }

}
?>
<div class="pvcp-main-table res-cl">
    <h2><?php 
esc_html_e( 'Wizard Configuration', PVCP_TEXT_DOMAIN );
?></h2>
    <form method="POST" name="wizardfrm" action="">
        <?php 
wp_nonce_field( 'wizardfrm' );
?>
        <input type="hidden" name="wizard_post_id" value="<?php 
echo  esc_attr( $wizard_id ) ;
?>">
        <table class="form-table table-outer counter-wizard-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_title"><?php 
esc_html_e( WIZARD_TITLE, PVCP_TEXT_DOMAIN );
?><span class="required-star">*</span></label></th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wizard_title" class="text-class half_width" id="wizard_title" value="<?php 
echo  ( !empty(esc_attr( $wizard_title )) ? esc_attr( $wizard_title ) : '' ) ;
?>" required="1" placeholder="<?php 
esc_html_e( WIZARD_TITLE_PLACEHOLDER, PVCP_TEXT_DOMAIN );
?>">
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description"><?php 
esc_html_e( WIZARD_TITLE_DESCRIPTION, PVCP_TEXT_DOMAIN );
?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_shortcode"><?php 
esc_html_e( WIZARD_SHORTCODE, PVCP_TEXT_DOMAIN );
?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <div class="product_cost_left_div">
                            <input type="text" name="wizard_shortcode" required="1" class="text-class" id="wizard_shortcode" value="<?php 
echo  ( !empty(esc_attr( $wizard_shortcode )) ? esc_attr( $wizard_shortcode ) : '' ) ;
?>" readonly>
                            <span class="pvcp_tooltip_icon"></span>
                            <p class="pcvp_tooltip_desc description">
                                <?php 
esc_html_e( WIZARD_SHORTCODE_DESCRIPTION, PVCP_TEXT_DOMAIN );
?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_status"><?php 
esc_html_e( WIZARD_STATUS, PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <label class="switch">
                            <input type="checkbox" name="wizard_status" value="on" <?php 
echo  ( !empty(esc_attr( $wizard_status )) && esc_attr( $wizard_status ) === 'off' ? '' : 'checked' ) ;
?>>
                            <div class="slider round"></div>
                        </label>
                    </td>
                </tr>	
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submitWizard" class="button button-primary button-large" value="<?php 
echo  esc_attr( $btnValue ) ;
?>"></p>
    </form>
</div>
<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';