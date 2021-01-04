<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
$retrieved_nonce = ( empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );
if ( isset( $_POST['submitGeneralSetting'] ) && sanitize_text_field( wp_unslash( $_POST['submitGeneralSetting'] ) ) === 'Save' ) {
    
    if ( !wp_verify_nonce( $retrieved_nonce, 'pvcp_general_wizardsettingfrm' ) ) {
        die( 'Failed security check' );
    } else {
        $data_post = $_POST;
        $this->pvcp_general_setting_save( $data_post, 'general-setting' );
    }

}
$general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
$pvcp_general_title = ( isset( $general_wizard_setting['pvcp_general_title'] ) && !empty($general_wizard_setting['pvcp_general_title']) ? sanitize_text_field( $general_wizard_setting['pvcp_general_title'] ) : '' );
$pvcp_general_post_type = ( isset( $general_wizard_setting['pvcp_general_post_type'] ) && !empty($general_wizard_setting['pvcp_general_post_type']) ? $general_wizard_setting['pvcp_general_post_type'] : '' );
$pvcp_general_front_view_counter = ( isset( $general_wizard_setting['pvcp_general_front_view_counter'] ) && !empty($general_wizard_setting['pvcp_general_front_view_counter']) ? $general_wizard_setting['pvcp_general_front_view_counter'] : 'disable' );
$pvcp_general_bc_color = ( isset( $general_wizard_setting['pvcp_general_bc_color'] ) && !empty($general_wizard_setting['pvcp_general_bc_color']) ? sanitize_text_field( wp_unslash( $general_wizard_setting['pvcp_general_bc_color'] ) ) : '#FFFFFF' );
$pvcp_general_font_color = ( isset( $general_wizard_setting['pvcp_general_font_color'] ) && !empty($general_wizard_setting['pvcp_general_font_color']) ? sanitize_text_field( wp_unslash( $general_wizard_setting['pvcp_general_font_color'] ) ) : '#000000' );
$pvcp_general_ip = ( isset( $general_wizard_setting['pvcp_general_ip'] ) && !empty($general_wizard_setting['pvcp_general_ip']) ? $general_wizard_setting['pvcp_general_ip'] : '' );
$pvcp_general_css = ( isset( $general_wizard_setting['pvcp_general_css'] ) && !empty($general_wizard_setting['pvcp_general_css']) ? $general_wizard_setting['pvcp_general_css'] : '' );
$pvcp_general_user = ( isset( $general_wizard_setting['pvcp_general_user'] ) && !empty($general_wizard_setting['pvcp_general_user']) ? $general_wizard_setting['pvcp_general_user'] : '' );
?>
<div class="pvcp-main-table pvcp-default-table res-cl">
    <h2>
        <?php 
esc_html_e( 'General Setting', PVCP_TEXT_DOMAIN );
?>
    </h2>
    <form method="POST" name="pvcp_general_wizardsettingfrm" class="pvcp_general_wizardsettingfrm"action="" enctype="multipart/form-data">
        <?php 
wp_nonce_field( 'pvcp_general_wizardsettingfrm' );
?>
        <table class="form-table table-outer general-setting">
            <tbody>
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="pvcp_general_title"><?php 
esc_html_e( 'Title', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                         <input type="text" name="pvcp_general_title" class="text-class" id="pvcp_general_title" value="<?php 
echo  esc_attr( $pvcp_general_title ) ;
?>" placeholder="<?php 
esc_html_e( 'Page visit counter Title', PVCP_TEXT_DOMAIN );
?>">
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description"><?php 
esc_html_e( 'Enter Post Counter Title which you want to display in front side for Wizard.', PVCP_TEXT_DOMAIN );
?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="pvcp_general_post_type"><?php 
esc_html_e( 'Post Type', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <?php 
$post_types = get_post_types();
echo  '<select name = "pvcp_general_post_type[]" multiple="multiple" class="multiselect2" data-placeholder="' . esc_attr__( ' Add Page/Post Type', PVCP_TEXT_DOMAIN ) . '">' ;
foreach ( $post_types as $post_list ) {
    $selectedVal = ( is_array( $pvcp_general_post_type ) && !empty($pvcp_general_post_type) && in_array( $post_list, $pvcp_general_post_type, true ) ? 'selected=selected' : '' );
    echo  '<option value="' . esc_attr( $post_list ) . '" ' . esc_attr( $selectedVal ) . '>' . esc_html( $post_list ) . '</option>' ;
}
echo  '</select>' ;
?>
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description">
                            <?php 
esc_html_e( 'Select post types for which post views will be counted.', PVCP_TEXT_DOMAIN );
?>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="pvcp_general_front_view_counter"><?php 
esc_html_e( 'Front View Counter', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <select name="pvcp_general_front_view_counter" id="pvcp_general_front_view_counter">
                            <option value="enable" <?php 
echo  ( !empty(esc_attr( $pvcp_general_front_view_counter )) && esc_attr( $pvcp_general_front_view_counter ) === 'enable' ? 'selected="selected"' : '' ) ;
?>><?php 
esc_html_e( 'Enable', PVCP_TEXT_DOMAIN );
?></option>
                            <option value="disable" <?php 
echo  ( !empty(esc_attr( $pvcp_general_front_view_counter )) && esc_attr( $pvcp_general_front_view_counter ) === 'disable' ? 'selected="selected"' : '' ) ;
?>><?php 
esc_html_e( 'Disable', PVCP_TEXT_DOMAIN );
?></option>
                        </select>
                        <span class="pvcp_tooltip_icon"></span>
                        <p class="pcvp_tooltip_desc description">
                            <?php 
esc_html_e( 'Enable or Disable page counter display in front side page visit counter.', PVCP_TEXT_DOMAIN );
?>
                        </p>
                    </td>
                </tr>
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="pvcp_general_bc_color"><?php 
esc_html_e( 'Background Color', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <input name="pvcp_general_bc_color" class="jscolor" value="<?php 
echo  esc_attr( $pvcp_general_bc_color ) ;
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
                        <label for="pvcp_general_font_color"><?php 
esc_html_e( 'Font Color', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <input name="pvcp_general_font_color" class="jscolor" value="<?php 
echo  esc_attr( $pvcp_general_font_color ) ;
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
                        <label for="pvcp_general_ip"><?php 
esc_html_e( 'Exclude IPs', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <?php 
echo  '<select id="ip_address" name = "pvcp_general_ip[]" multiple="multiple" class="multiselect2 chosen-select-ip category-select" data-placeholder="' . esc_attr__( 'Add IP address separated by comma', PVCP_TEXT_DOMAIN ) . '">' ;
echo  '<option value=""></option>' ;
if ( is_array( $pvcp_general_ip ) && !empty($pvcp_general_ip) ) {
    foreach ( $pvcp_general_ip as $key => $values ) {
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
                        <label for="pvcp_general_user"><?php 
esc_html_e( 'Exclude Users', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <?php 
$blogusers = get_users( array(
    'fields' => array( 'ID', 'user_login' ),
) );
echo  '<select name = "pvcp_general_user[]" multiple="multiple" class="multiselect2">' ;
foreach ( $blogusers as $user ) {
    $selectedVal = ( is_array( $pvcp_general_user ) && !empty($pvcp_general_user) && in_array( $user->ID, $pvcp_general_user, true ) ? 'selected=selected' : '' );
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
                <tr valign="top"> 
                    <th class="titledesc" scope="row">
                        <label for="pvcp_general_font"><?php 
esc_html_e( 'Custom CSS', PVCP_TEXT_DOMAIN );
?></label></th>
                    <td class="forminp mdtooltip">
                        <textarea name="pvcp_general_css" placeholder="<?php 
esc_html_e( 'Custom CSS', PVCP_TEXT_DOMAIN );
?>" rows="4" cols="50"><?php 
echo  esc_attr( $pvcp_general_css ) ;
?></textarea>
                    </td>
                </tr>

            </tbody>
        </table>
        <p class="submit"><input type="submit" id="submitGeneralSetting" name="submitGeneralSetting" class="button button-primary button-large" value="<?php 
esc_html_e( 'Save', PVCP_TEXT_DOMAIN );
?>">
        <a class="pvcp-action-button button-primary reset_all_page_report_count" href="javascript:void(0);" id="reset_all_page_report_count"><?php 
esc_html_e( 'Reset all pages counts & report ', PVCP_TEXT_DOMAIN );
?></a></p>
    </form>
</div>

<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';