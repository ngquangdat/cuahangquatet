<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
?>

<div class="pvcp-main-table res-cl">

    <h2><?php 
esc_html_e( 'Thanks For Installing ' . PVCP_PLUGIN_NAME, PVCP_TEXT_DOMAIN );
?></h2>

    <table class="table-outer">
        <tbody>

            <tr>
                <td class="fr-2">

                    <p class="block gettingstarted"><strong><?php 
esc_html_e( 'Getting Started', PVCP_TEXT_DOMAIN );
?> </strong></p>
                    <?php 
?>
                        <p class="block textgetting">
                            <?php 
esc_html_e( 'Page Visit Counter counts the visit of the website. It enables site owners to exclude specific IP/s, register user from post/pages counter. There is an option to select specific post type that include in post/pages counter.', PVCP_TEXT_DOMAIN );
?>
                        </p>

                        <p class="block textgetting">
                            <strong><?php 
esc_html_e( 'Step 1', PVCP_TEXT_DOMAIN );
?>
                                :</strong> <?php 
esc_html_e( 'Wizard Configuration', PVCP_TEXT_DOMAIN );
?>
                            <span class="gettingstarted">
                                    <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_01.png' ) ;
?>">
                                </span>
                        </p>

                        <p class="block textgetting">
                            <strong><?php 
esc_html_e( 'Step 2', PVCP_TEXT_DOMAIN );
?>
                                :</strong> <?php 
esc_html_e( 'You can see list of all created wizard', PVCP_TEXT_DOMAIN );
?>
                            <span class="gettingstarted">
                                    <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_02.png' ) ;
?>">
                                </span>
                        </p>

                        <p class="block textgetting">
                            <strong><?php 
esc_html_e( 'Step 3', PVCP_TEXT_DOMAIN );
?>
                                :</strong> <?php 
esc_html_e( 'You can configure individual wizard.', PVCP_TEXT_DOMAIN );
?>
                            <span class="gettingstarted">
                                    <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_03.png' ) ;
?>">
                                </span>
                        </p>

                        <p class="block textgetting">
                            <strong><?php 
esc_html_e( 'Step 4', PVCP_TEXT_DOMAIN );
?>
                                :</strong> <?php 
esc_html_e( 'You can configure default/general wizard.', PVCP_TEXT_DOMAIN );
?>
                            <span class="gettingstarted">
                                    <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_04.png' ) ;
?>">
                                </span>
                        </p>
                    <?php 
?>

                    <p class="block textgetting">
                        <strong><?php 
esc_html_e( 'Step 5', PVCP_TEXT_DOMAIN );
?> :</strong> <?php 
esc_html_e( 'Set wizard shortcode in page/post which you want to display it.', PVCP_TEXT_DOMAIN );
?>
                        <span class="gettingstarted">
                            <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_05.png' ) ;
?>">
                        </span>
                    </p>

                    <p class="block textgetting">
                        <strong><?php 
esc_html_e( 'Step 6', PVCP_TEXT_DOMAIN );
?> :</strong> <?php 
esc_html_e( 'Also you can manage page visit counter by metabox.', PVCP_TEXT_DOMAIN );
?>
                        <span class="gettingstarted">
                            <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_06.png' ) ;
?>">
                        </span>
                    </p>

                    <p class="block textgetting">
                        <strong><?php 
esc_html_e( 'Step 7', PVCP_TEXT_DOMAIN );
?> :</strong> <?php 
esc_html_e( 'Front view page counter.', PVCP_TEXT_DOMAIN );
?>
                        <span class="gettingstarted">
                            <img src="<?php 
echo  esc_url( PVCP_PLUGIN_URL . 'admin/images/Getting_Started_07.png' ) ;
?>">
                        </span>
                    </p>

                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php 
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-sidebar.php';