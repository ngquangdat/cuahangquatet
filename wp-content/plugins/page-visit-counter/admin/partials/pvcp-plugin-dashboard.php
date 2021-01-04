<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
?>


<div class="pvcp-main-dashboard full-cl res-cl">
    <h2>
        <?php 
esc_html_e( 'Dashboard', PVCP_TEXT_DOMAIN );
?>
     </h2>
    <div class="postbox-container" id="pvcp-postbox-container-1">
        <!-- Top Summary -->
        <div class="dash-summary pvcp-table-cover">
            <h2><?php 
esc_html_e( 'Website Summary', PVCP_TEXT_DOMAIN );
?></h2>
            <?php 
$currentDate = date( "Y/m/d" );
// current date
$yesterday = date( "Y/m/d", strtotime( "-1 days" ) );
// yesterday date
$lastWeek = date( "Y/m/d", strtotime( "-7 days" ) );
// last week date
$lastMonth = date( "Y/m/d", strtotime( "-1 month" ) );
// last month date
$lastyear = date( "Y/m/d", strtotime( "-1 year" ) );
// last tear date
// Site Visit Count
$today_count_visit = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE date = %s", $currentDate ) );
//db call ok; no-cache ok
$yesterday_count_visit = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE date = %s", $yesterday ) );
//db call ok; no-cache ok
$last_week_count_visit = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE date BETWEEN %s AND %s", $lastWeek, $currentDate ) );
//db call ok; no-cache ok
$last_month_count_visit = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE date BETWEEN %s AND %s", $lastMonth, $currentDate ) );
//db call ok; no-cache ok
$last_year_count_visit = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE date BETWEEN %s AND %s", $lastyear, $currentDate ) );
//db call ok; no-cache ok
$total_count_visit = $wpdb->get_var( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history" );
//db call ok; no-cache ok
// Site Visitor Count
$today_count_visitor = $wpdb->get_var( $wpdb->prepare( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history WHERE date = %s", $currentDate ) );
//db call ok; no-cache ok
$yesterday_count_visitor = $wpdb->get_var( $wpdb->prepare( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history WHERE date = %s", $yesterday ) );
//db call ok; no-cache ok
$last_week_count_visitor = $wpdb->get_var( $wpdb->prepare( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history WHERE date BETWEEN %s AND %s", $lastWeek, $currentDate ) );
//db call ok; no-cache ok
$last_month_count_visitor = $wpdb->get_var( $wpdb->prepare( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history WHERE date BETWEEN %s AND %s", $lastMonth, $currentDate ) );
//db call ok; no-cache ok
$last_year_count_visitor = $wpdb->get_var( $wpdb->prepare( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history WHERE date BETWEEN %s AND %s", $lastyear, $currentDate ) );
//db call ok; no-cache ok
$total_count_visitor = $wpdb->get_var( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history" );
//db call ok; no-cache ok
?>
            <table class="form-table">
                <thead>
                <tr>
                    <th width="60%"><?php 
esc_html_e( '', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Visitors', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Visit', PVCP_TEXT_DOMAIN );
?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php 
esc_html_e( 'Today', PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $today_count_visitor, PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $today_count_visit, PVCP_TEXT_DOMAIN );
?></td>
                </tr>
                <tr>
                    <td><?php 
esc_html_e( 'Yesterday', PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $yesterday_count_visitor, PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $yesterday_count_visit, PVCP_TEXT_DOMAIN );
?></td>
                </tr>
                <tr>
                    <td><?php 
esc_html_e( 'Last Week', PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $last_week_count_visitor, PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $last_week_count_visit, PVCP_TEXT_DOMAIN );
?></td>
                </tr>
                <tr>
                    <td><?php 
esc_html_e( 'Last Month', PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $last_month_count_visitor, PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $last_month_count_visit, PVCP_TEXT_DOMAIN );
?></td>
                </tr>
                <tr>
                    <td><?php 
esc_html_e( 'Last Year', PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $total_count_visitor, PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $total_count_visit, PVCP_TEXT_DOMAIN );
?></td>
                </tr>
                <tr>
                    <td><?php 
esc_html_e( 'Total', PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $last_year_count_visitor, PVCP_TEXT_DOMAIN );
?></td>
                    <td><?php 
esc_html_e( $last_year_count_visit, PVCP_TEXT_DOMAIN );
?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Top Browser History -->
        <div class="dash-browser-history pvcp-table-cover">
            <h2><?php 
esc_html_e( 'Site Visit By Browser', PVCP_TEXT_DOMAIN );
?></h2>
            <div id="chartContainerByBrowser" class="chartContainerHeight"></div>
        </div>
        <!-- Top Os History -->
        <div class="dash-os-history pvcp-table-cover">
            <h2><?php 
esc_html_e( 'Site Visit By OS', PVCP_TEXT_DOMAIN );
?></h2>
            <div id="chartContainerByOs" class="chartContainerHeight"></div>
        </div>
        <?php 
?>
        <!-- Refer URL List-->
        <div class="dash-top-referer pvcp-table-cover">
            <h2><?php 
esc_html_e( 'Top 10 Referral Website', PVCP_TEXT_DOMAIN );
?></h2>
            <table class="form-table">
                <thead>
                <tr>
                    <th><?php 
esc_html_e( 'ID', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Referer URL', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Count', PVCP_TEXT_DOMAIN );
?></th>
                </tr>
                </thead>
                <tbody>
                <?php 
$top_reff = $wpdb->get_results( "SELECT ref_url, count(ref_url) AS total FROM {$wpdb->prefix}page_visit_referer GROUP BY ref_url ORDER BY COUNT(ref_url) DESC LIMIT 10" );
//db call ok; no-cache ok

if ( $top_reff ) {
    $reff_i = 1;
    foreach ( $top_reff as $dash_reff ) {
        ?>
                        <tr>
                            <td><?php 
        esc_html_e( $reff_i, PVCP_TEXT_DOMAIN );
        ?></td>
                            <td><?php 
        esc_html_e( $dash_reff->ref_url, PVCP_TEXT_DOMAIN );
        ?></td>
                            <td><?php 
        esc_html_e( $dash_reff->total, PVCP_TEXT_DOMAIN );
        ?></td>
                        </tr>
                        <?php 
        $reff_i++;
    }
} else {
    ?>
                    <tr>
                        <td colspan="3"><?php 
    esc_html_e( NO_DATA_FOUND, PVCP_TEXT_DOMAIN );
    ?></td>
                    </tr>
                    <?php 
}

?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="postbox-container" id="pvcp-postbox-container-2">
        <?php 
?>
        <!-- Top Page List -->
        <div class="dash-top-page pvcp-table-cover">
            <div class="for-button-outer">
                <a href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page' ) ) ;
?>" class="handlediv button-link wps-more" type="button" id="wps_top_visitors_more_button" aria-expanded="true">
                    <span class="dashicons dashicons-external"></span>
                    <span class="screen-reader-text">More Details</span>
                </a>
                <h2><?php 
esc_html_e( 'Top 10 Pages', PVCP_TEXT_DOMAIN );
?></h2>
            </div>
            <table class="form-table">
                <thead>
                    <tr>
                        <th><?php 
esc_html_e( 'Title', PVCP_TEXT_DOMAIN );
?></th>
                        <th><?php 
esc_html_e( 'Link', PVCP_TEXT_DOMAIN );
?></th>
                        <th><?php 
esc_html_e( 'Visit', PVCP_TEXT_DOMAIN );
?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
$top_pages = $wpdb->get_results( "SELECT page_id,http_referer,count(id) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type NOT IN ('post') GROUP BY page_id ORDER BY COUNT(id) DESC LIMIT 10" );
//db call ok; no-cache ok

if ( $top_pages ) {
    foreach ( $top_pages as $dash_page ) {
        ?>
                            <tr>
                                <td><?php 
        esc_html_e( get_the_title( $dash_page->page_id ), PVCP_TEXT_DOMAIN );
        ?></td>
                                <td><a href="<?php 
        echo  esc_url( $dash_page->http_referer ) ;
        ?>" target="_blank"><?php 
        esc_html_e( get_the_title( $dash_page->page_id ), PVCP_TEXT_DOMAIN );
        ?></a></td>
                                <td><?php 
        esc_html_e( $dash_page->visit, PVCP_TEXT_DOMAIN );
        ?></td>
                            </tr>
                            <?php 
    }
} else {
    ?>
                        <tr>
                            <td colspan="3"><?php 
    esc_html_e( NO_DATA_FOUND, PVCP_TEXT_DOMAIN );
    ?></td>
                        </tr>
                    <?php 
}

?>
                </tbody>
            </table>
        </div>
        <!-- Top Post List -->
        <div class="dash-top-post pvcp-table-cover">
            <div class="for-button-outer">
                <a href="<?php 
echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-post' ) ) ;
?>"class="handlediv button-link wps-more" type="button" id="wps_top_visitors_more_button" aria-expanded="true">
                    <span class="dashicons dashicons-external"></span>
                    <span class="screen-reader-text">More Details</span>
                </a>
                <h2><?php 
esc_html_e( 'Top 10 Posts', PVCP_TEXT_DOMAIN );
?></h2>
            </div>
            <table class="form-table">
                <thead>
                <tr>
                    <th><?php 
esc_html_e( 'Title', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Link', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Visit', PVCP_TEXT_DOMAIN );
?></th>
                </tr>
                </thead>
                <tbody>
                <?php 
$top_post = $wpdb->get_results( "SELECT page_id,http_referer,count(id) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type='post' GROUP BY page_id ORDER BY COUNT(id) DESC LIMIT 10" );
//db call ok; no-cache ok

if ( $top_post ) {
    foreach ( $top_post as $dash_post ) {
        ?>
                        <tr>
                            <td><?php 
        esc_html_e( get_the_title( $dash_post->page_id ), PVCP_TEXT_DOMAIN );
        ?></td>
                            <td><a href="<?php 
        echo  esc_url( $dash_post->http_referer ) ;
        ?>" target="_blank"><?php 
        esc_html_e( get_the_title( $dash_post->page_id ), PVCP_TEXT_DOMAIN );
        ?></a></td>
                            <td><?php 
        esc_html_e( $dash_post->visit, PVCP_TEXT_DOMAIN );
        ?></td>
                        </tr>
                        <?php 
    }
} else {
    ?>
                    <tr>
                        <td colspan="3"><?php 
    esc_html_e( NO_DATA_FOUND, PVCP_TEXT_DOMAIN );
    ?></td>
                    </tr>
                    <?php 
}

?>
                </tbody>
            </table>
        </div>
        <!-- Top IP Address -->
        <div class="dash-top-ip pvcp-table-cover">
            <h2><?php 
esc_html_e( 'Top 10 IPs', PVCP_TEXT_DOMAIN );
?></h2>
            <table class="form-table">
                <thead>
                <tr>
                    <th><?php 
esc_html_e( 'IP Address', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Visitor', PVCP_TEXT_DOMAIN );
?></th>
                    <th><?php 
esc_html_e( 'Visit', PVCP_TEXT_DOMAIN );
?></th>
                </tr>
                </thead>
                <tbody>
                <?php 
$top_ip = $wpdb->get_results( "SELECT ipaddress,count(id) AS visit FROM {$wpdb->prefix}page_visit_history GROUP BY ipaddress ORDER BY COUNT(id) DESC LIMIT 10" );
//db call ok; no-cache ok

if ( $top_ip ) {
    foreach ( $top_ip as $dash_ip ) {
        $ip_visitor = $wpdb->get_var( $wpdb->prepare( "SELECT count(DISTINCT user_id) FROM {$wpdb->prefix}page_visit_history WHERE ipaddress = %s", $dash_ip->ipaddress ) );
        //db call ok; no-cache ok
        ?>
                        <tr>
                            <td><?php 
        esc_html_e( $dash_ip->ipaddress );
        ?></td>
                            <td><?php 
        esc_html_e( $ip_visitor, PVCP_TEXT_DOMAIN );
        ?></td>
                            <td><?php 
        esc_html_e( $dash_ip->visit, PVCP_TEXT_DOMAIN );
        ?></td>
                        </tr>
                        <?php 
    }
} else {
    ?>
                    <tr>
                        <td colspan="3"><?php 
    esc_html_e( NO_DATA_FOUND, PVCP_TEXT_DOMAIN );
    ?></td>
                    </tr>
                    <?php 
}

?>
                </tbody>
            </table>
        </div>
    </div>


</div>

