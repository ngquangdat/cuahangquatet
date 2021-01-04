<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
$retrieved_nonce = ( empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );
$wizard_id = ( empty($_REQUEST['wizard_id']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['wizard_id'] ) ) );
if ( isset( $_POST['submitWizardSetting'] ) && sanitize_text_field( wp_unslash( $_POST['submitWizardSetting'] ) ) === 'Save' ) {
    
    if ( !wp_verify_nonce( $retrieved_nonce, 'pvcp_ind_wizardsettingfrm' ) ) {
        die( 'Failed security check' );
    } else {
        $data_post = $_POST;
        $this->pvcp_wizard_save( $data_post, 'setting', $data_post['pvcp_ind_wizard_post_id'] );
    }

}
$wizard_setting_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}page_visit_wizard WHERE ID=%d", array( $wizard_id ) ) );
//db call ok; no-cache ok
$wizard_title = ( empty($wizard_setting_rows->name) ? '' : $wizard_setting_rows->name );
$wizard_setting = ( empty($wizard_setting_rows->wizard_setting) ? '' : maybe_unserialize( $wizard_setting_rows->wizard_setting ) );
$pvcp_ind_wz_bc_color = ( isset( $wizard_setting['pvcp_ind_wz_bc_color'] ) && !empty($wizard_setting['pvcp_ind_wz_bc_color']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_bc_color'] ) ) : '' );
$pvcp_ind_wz_font_color = ( isset( $wizard_setting['pvcp_ind_wz_font_color'] ) && !empty($wizard_setting['pvcp_ind_wz_font_color']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_font_color'] ) ) : '' );
$pvcp_ind_wz_font_size = ( isset( $wizard_setting['pvcp_ind_wz_font_size'] ) && !empty($wizard_setting['pvcp_ind_wz_font_size']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_font_size'] ) ) : '' );
$pvcp_ind_wz_padding = ( isset( $wizard_setting['pvcp_ind_wz_padding'] ) && !empty($wizard_setting['pvcp_ind_wz_padding']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_padding'] ) ) : '' );
$pvcp_ind_wz_border = ( isset( $wizard_setting['pvcp_ind_wz_border'] ) && !empty($wizard_setting['pvcp_ind_wz_border']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_border'] ) ) : '' );
$pvcp_ind_wz_border_radius = ( isset( $wizard_setting['pvcp_ind_wz_border_radius'] ) && !empty($wizard_setting['pvcp_ind_wz_border_radius']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_border_radius'] ) ) : '' );
$pvcp_ind_wz_font = ( isset( $wizard_setting['pvcp_ind_wz_font'] ) && !empty($wizard_setting['pvcp_ind_wz_font']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_font'] ) ) : '' );
$pvcp_ind_wz_counter_pos = ( isset( $wizard_setting['pvcp_ind_wz_counter_pos'] ) && !empty($wizard_setting['pvcp_ind_wz_counter_pos']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_counter_pos'] ) ) : '' );
$pvcp_ind_wz_counter_view = ( isset( $wizard_setting['pvcp_ind_wz_counter_view'] ) && !empty($wizard_setting['pvcp_ind_wz_counter_view']) ? sanitize_text_field( wp_unslash( $wizard_setting['pvcp_ind_wz_counter_view'] ) ) : '' );
$pvcp_ind_wz_user = ( isset( $wizard_setting['pvcp_ind_wz_user'] ) && !empty($wizard_setting['pvcp_ind_wz_user']) ? $wizard_setting['pvcp_ind_wz_user'] : '' );
// WPCS: XSS OK.
$pvcp_ind_wz_user_role = ( isset( $wizard_setting['pvcp_ind_wz_user_role'] ) && !empty($wizard_setting['pvcp_ind_wz_user_role']) ? $wizard_setting['pvcp_ind_wz_user_role'] : '' );
// WPCS: XSS OK.
$pvcp_ind_wz_ip = ( isset( $wizard_setting['pvcp_ind_wz_ip'] ) && !empty($wizard_setting['pvcp_ind_wz_ip']) ? $wizard_setting['pvcp_ind_wz_ip'] : '' );
// WPCS: XSS OK.
?>
<div class="pvcp-main-table res-cl">
    <h2>
        <?php 
esc_html_e( 'Wizard Setting For', PVCP_TEXT_DOMAIN );
?> <?php 
echo  wp_kses_post( $wizard_title ) ;
?>
        <a class="add-new-btn back-button"  id="back_button" href="<?php 
echo  esc_url( admin_url( '/admin.php?page=pvcp-list' ) ) ;
?>"><?php 
esc_html_e( BACK_TO_WIZARD_LIST, PVCP_TEXT_DOMAIN );
?></a>
    </h2>
    <form method="POST" name="pvcp_ind_wizardsettingfrm" action="">
        <?php 
wp_nonce_field( 'pvcp_ind_wizardsettingfrm' );
?>
        <input type="hidden" name="pvcp_ind_wizard_post_id" value="<?php 
echo  esc_attr( $wizard_id ) ;
?>">
        <table class="form-table table-outer product-fee-table">
            <tbody>
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="perfect_match_title"><?php 
esc_html_e( 'Background Color', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <input name="pvcp_ind_wz_bc_color" class="jscolor" value="<?php 
echo  esc_attr( $pvcp_ind_wz_bc_color ) ;
?>">
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description">
                            <?php 
esc_html_e( 'Select background color which you want to set in front side page visit counter.', PVCP_TEXT_DOMAIN );
?>
                        </p>
                    </td>
                </tr>
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="perfect_match_title"><?php 
esc_html_e( 'Font Color', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <input name="pvcp_ind_wz_font_color" class="jscolor" value="<?php 
echo  esc_attr( $pvcp_ind_wz_font_color ) ;
?>">
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description">
                            <?php 
esc_html_e( 'Select font color which you want to set in front side page visit counter.', PVCP_TEXT_DOMAIN );
?>
                        </p>
                    </td>
                </tr>
                <?php 
?>
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="pvcp_ind_wz_ip"><?php 
esc_html_e( 'Exclude IPs', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <?php 
echo  '<select id="ip_address" name = "pvcp_ind_wz_ip[]" multiple="multiple" class="multiselect2 chosen-select-ip category-select" data-placeholder="' . esc_attr( 'Add IP address separated by comma' ) . '">' ;
echo  '<option value=""></option>' ;
if ( is_array( $pvcp_ind_wz_ip ) && !empty($pvcp_ind_wz_ip) ) {
    foreach ( $pvcp_ind_wz_ip as $key => $values ) {
        echo  '<option value="' . esc_attr( $values ) . '" selected=selected>' . esc_attr( $values ) . '</option>' ;
    }
}
echo  '</select>' ;
?>
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description">
                            <?php 
esc_html_e( 'With this feature, you can exclude IPs which you do not count in page visit.', PVCP_TEXT_DOMAIN );
?>
                        </p>
                    </td>
                </tr>        
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="pvcp_ind_wz_user"><?php 
esc_html_e( 'Exclude Users', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <?php 
$blogusers = get_users( array(
    'fields' => array( 'ID', 'user_login' ),
) );
echo  '<select name = "pvcp_ind_wz_user[]" multiple="multiple" class="multiselect2">' ;
foreach ( $blogusers as $user ) {
    $selectedVal = ( is_array( $pvcp_ind_wz_user ) && !empty($pvcp_ind_wz_user) && in_array( $user->ID, $pvcp_ind_wz_user, true ) ? 'selected=selected' : '' );
    echo  '<option value="' . esc_attr( $user->ID ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $user->user_login, PVCP_TEXT_DOMAIN ) . '</option>' ;
}
echo  '</select>' ;
?>
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description">
                            <?php 
esc_html_e( 'With this feature, you can exclude User which you do not count in page visit.', PVCP_TEXT_DOMAIN );
?>
                        </p>
                    </td>
                </tr>
                <?php 
?>

            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submitWizardSetting" class="button button-primary button-large" value="<?php 
esc_html_e( 'Save', PVCP_TEXT_DOMAIN );
?>"></p>
    </form>
</div>
<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';