<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fired during plugin activation
 *
 * @link       https://www.thedotstore.com/
 * @since      1.0.0
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/includes
 * @author     Thedotstore
 */

class Page_Visit_Counter_Activator
{

    /**
     * Create custom tables and other initial operations on plugin activation.
     *
     * Fired during plugin activation.
     *
     * @since    1.0.0
     */
    public static function activate()
    {

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $page_visit_history_table = HISTORY_TABLE;

        if ($wpdb->get_var("show tables like '$page_visit_history_table'") !== $page_visit_history_table) {

            $page_visit_history_sql = "CREATE TABLE $page_visit_history_table (id bigint(20) NOT NULL AUTO_INCREMENT,page_id bigint(20) NOT NULL,user_id bigint(20) NOT NULL,user_role varchar(255) NOT NULL,date  date NOT NULL,lastdate  date NOT NULL,ipaddress varchar(255) NOT NULL,country varchar(255) NOT NULL,browser_full_name varchar(255) NOT NULL,browser_short_name varchar(255) NOT NULL,browser_version varchar(255) NOT NULL,os varchar(255) NOT NULL,http_referer text NOT NULL,type varchar(255) NOT NULL,PRIMARY KEY  (id)) $charset_collate;";

            dbDelta($page_visit_history_sql);
        } /*else {

            $new_column_name = 'type';
            $new_column = $wpdb->get_results($wpdb->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ", DB_NAME, $page_visit_history_table, $new_column_name));

            if (empty($new_column)) {
                $wpdb->query("ALTER TABLE $page_visit_history_table CHANGE `id` `id` bigint(20) NOT NULL AUTO_INCREMENT, CHANGE `page_id` `page_id` bigint(20) NOT NULL, CHANGE `http_referer` `http_referer` text NOT NULL, ADD COLUMN `type` varchar(255) AFTER `http_referer`");
            }
        }*/

        $page_referer_table = REFERER_TABLE;
        if ($wpdb->get_var("show tables like '$page_referer_table'") !== $page_referer_table) {

            $page_referer_table_sql = "CREATE TABLE $page_referer_table (ID int(11) NOT NULL AUTO_INCREMENT,page_id bigint(20) NOT NULL,type varchar(255) NOT NULL,date  date NOT NULL,http_referer text NOT NULL,ref_url text NOT NULL,PRIMARY KEY  (ID)) $charset_collate;";

            dbDelta($page_referer_table_sql);
        }

        $wizard_table = WIZARDS_TABLE;

        if ($wpdb->get_var("show tables like '$wizard_table'") !== $wizard_table) {

            $wizard_sql = "CREATE TABLE $wizard_table (ID int( 11 ) NOT NULL AUTO_INCREMENT,name varchar( 255 ) NOT NULL,wizard_setting text NOT NULL,shortcode text NOT NULL,status varchar( 25 ) NOT NULL,created_date datetime NOT NULL,updated_date datetime NOT NULL,PRIMARY KEY  ( ID )) $charset_collate;";

            dbDelta($wizard_sql);
            $wizard_sql_data = $wpdb->insert($wizard_table, array(
                    'id' => '1',
                    'name' => 'Page Visit Count',
                    'wizard_setting' => '',
                    'shortcode' => '[pvcp_1]',
                    'status' => 'on',
                    'created_date' => date("Y-m-d H:i:s"),
                    'updated_date' => date("Y-m-d H:i:s"),
                )
            );
            dbDelta($wizard_sql_data);
        }
        /* Data Migration Script Start */
        $pvcp_db_upgrade = get_option('pvcp_db_upgrade');

        if (empty($pvcp_db_upgrade)) {
            $db_upgrade_flag = self::pvcp_data_migration_script();
            if ($db_upgrade_flag == 1) {
                update_option('pvcp_db_upgrade', 'required');
            }
        }
        /* Data Migration Script End */
        set_transient('_welcome_screen_activation_redirect_pvcp', true, 30);
        add_option('pvcp_version', PVCP_VERSION);

    }

    /**
     * Data Migration on plugin update
     *
     * @return int
     * @since    1.0.0
     *
     * */
    public static function pvcp_data_migration_script()
    {
        global $wpdb;
        $post_type = "";
        $ip = "";
        $user = "";
        $front_view = "disable";
        $color = "";

        if (get_option('wfap_post_type')) {
            $post_type = json_decode(get_option('wfap_post_type'));
        }
        if (get_option('ipaddress_visit')) {
            $ip = json_decode(get_option('ipaddress_visit'));
        }
        if (get_option('userlist_visit')) {
            $user = json_decode(get_option('userlist_visit'));
        }
        if (get_option('counter_hide_show_front_vew')) {
            $front_view_value = get_option('counter_hide_show_front_vew');
            $front_view = ('on' === $front_view_value) ? 'enable' : 'disable';
        }
        if (get_option('text_color_page_visit')) {
            $color = get_option('text_color_page_visit');
        }

        delete_option('wfap_post_type');
        delete_option('ipaddress_visit');
        delete_option('userlist_visit');
        delete_option('counter_hide_show_front_vew');
        delete_option('text_color_page_visit');

        $general_setting_data = array();
        $general_setting_data['pvcp_general_post_type'] = $post_type;
        $general_setting_data['pvcp_general_ip'] = $ip;
        $general_setting_data['pvcp_general_user'] = $user;
        $general_setting_data['pvcp_general_front_view_counter'] = $front_view;
        $general_setting_data['pvcp_general_font_color'] = $color;

        $general_setting_data = maybe_serialize($general_setting_data);
        if (!get_option('pvcp_general_settings')) {
            update_option('pvcp_general_settings', $general_setting_data);
        }
        $post_table = $wpdb->prefix . "posts";
        // replace total website old shortcode to new shortcode
        $website_sh_record = $wpdb->get_results("SELECT ID,post_content FROM $post_table WHERE (post_content LIKE '%page_visit_counter_md_total_sites_visit%')"); //db call ok; no-cache ok
        if ($website_sh_record) {
            foreach ($website_sh_record as $wr) {
                $post_content = $wr->post_content;
                $startpos = strpos($post_content, '[page_visit_counter_md_total_sites_visit');
                $endpos = strpos($post_content, ']', $startpos);
                $endpos = ($endpos - $startpos) + 1;
                $string = substr($post_content, $startpos, $endpos);
                $wpdb->query("UPDATE $post_table SET post_content = replace(post_content,'" . $string . "','[pvcp_website_count]')");
            }
        }

        // replace page and post old shortcode to new shortcode
        $page_sh_record = $wpdb->get_results("SELECT ID,post_content FROM $post_table WHERE (post_content LIKE '%page_visit_counter_md%')"); //db call ok; no-cache ok
        if ($page_sh_record) {
            foreach ($page_sh_record as $pr) {
                $post_content = $pr->post_content;
                $startpos = strpos($post_content, '[page_visit_counter_md');
                $endpos = strpos($post_content, ']', $startpos);
                $endpos = ($endpos - $startpos) + 1;
                $string = substr($post_content, $startpos, $endpos);
                $wpdb->query("UPDATE $post_table SET post_content = replace(post_content,'" . $string . "','[pvcp_1]')");
            }
        }

        $page_visit_history_table = HISTORY_TABLE;

        $new_column_user_id = 'user_id';
        $user_id_column = $wpdb->get_results($wpdb->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ", DB_NAME, $page_visit_history_table, $new_column_user_id));

        $new_column_user_role = 'user_role';
        $user_role_column = $wpdb->get_results($wpdb->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ", DB_NAME, $page_visit_history_table, $new_column_user_role));

        $new_column_country = 'country';
        $country_column = $wpdb->get_results($wpdb->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ", DB_NAME, $page_visit_history_table, $new_column_country));

        $new_column_type = 'type';
        $type_column = $wpdb->get_results($wpdb->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ", DB_NAME, $page_visit_history_table, $new_column_type));

        if (empty($user_id_column)) {
            $wpdb->query("ALTER TABLE $page_visit_history_table ADD COLUMN `user_id` bigint(20) AFTER `page_id`");
        }
        if (empty($user_role_column)) {
            $wpdb->query("ALTER TABLE $page_visit_history_table ADD COLUMN `user_role` varchar(255) AFTER `user_id`");
        }
        if (empty($country_column)) {
            $wpdb->query("ALTER TABLE $page_visit_history_table ADD COLUMN `country` varchar(255) AFTER `ipaddress`");
        }
        if (empty($type_column)) {
            $wpdb->query("ALTER TABLE $page_visit_history_table ADD COLUMN `type` varchar(255) AFTER `http_referer`");
        }

        /*$get_all_record = $wpdb->get_results("SELECT page_id FROM $page_visit_history_table"); //db call ok; no-cache ok
        if ($get_all_record) {
            foreach ($get_all_record as $result) {
                $page_id= $result->page_id;
                $set_post_type = get_post_type($page_id);
                $wpdb->query("UPDATE $page_visit_history_table SET type='$set_post_type' WHERE page_id=$page_id");
            }
        }*/

        $wpdb->query("UPDATE $page_visit_history_table SET type='page'"); 


        $db_upgrade_flag = 1;
        return $db_upgrade_flag;

    }
}
