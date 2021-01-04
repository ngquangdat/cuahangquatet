<?php
if (!defined('ABSPATH')) {
    exit;
}
require_once( plugin_dir_path( __FILE__ ) .'header/plugin-header.php' );
global $wpdb;
?>

<div class="pvcp-main-table res-cl">

    <h2><?php esc_html_e('Quick info', PVCP_TEXT_DOMAIN); ?></h2>

    <table class="table-outer">
        <tbody>

            <tr>
                <td class="fr-1"><?php esc_html_e('Product Type', PVCP_TEXT_DOMAIN); ?></td>
                <td class="fr-2"><?php esc_html_e('WordPress Plugin', PVCP_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Product Name', PVCP_TEXT_DOMAIN); ?></td>
                <td class="fr-2"><?php esc_html_e(PVCP_PLUGIN_NAME, PVCP_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Installed Version', PVCP_TEXT_DOMAIN); ?></td>
                <td class="fr-2"><?php esc_html_e(PVCP_VERSION_TEXT, PVCP_TEXT_DOMAIN); ?> <?php echo esc_html($plugin_version); ?></td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('License & Terms of use', PVCP_TEXT_DOMAIN); ?></td>
                <td class="fr-2"><a target="_blank"  href="<?php echo esc_url("https://www.thedotstore.com/terms-and-conditions/"); ?>">
                        <?php esc_html_e('Click here', PVCP_TEXT_DOMAIN); ?></a>
                    <?php esc_html_e('to view license and terms of use.', PVCP_TEXT_DOMAIN); ?>
                </td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e('Help & Support', PVCP_TEXT_DOMAIN); ?></td>
                <td class="fr-2 pvcp-information">
                    <ul>
                        <li><a target="_blank" href="<?php echo esc_url(site_url('wp-admin/admin.php?page=pvcp-get-started')); ?>"><?php esc_html_e('Quick Start', PVCP_TEXT_DOMAIN); ?></a></li>
                        <li><a target="_blank" href="javascript:void(0);"><?php esc_html_e('Guide Documentation', PVCP_TEXT_DOMAIN); ?></a></li>
                        <li><a target="_blank" href="<?php echo esc_url("https://www.thedotstore.com/support/"); ?>"><?php esc_html_e('Support Forum', PVCP_TEXT_DOMAIN); ?></a></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="fr-1"><?php esc_html_e( 'Localization', PVCP_TEXT_DOMAIN ); ?></td>
                <td class="fr-2"><?php esc_html_e( 'English', PVCP_TEXT_DOMAIN ); ?></td>
            </tr>

        </tbody>
    </table>

</div>

<?php
require_once( plugin_dir_path( __FILE__ ) .'header/plugin-sidebar.php' );
