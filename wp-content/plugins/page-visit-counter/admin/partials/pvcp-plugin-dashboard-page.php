<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
$page_id_wpnonce = filter_input( INPUT_GET, 'page_id', FILTER_SANITIZE_STRING );
$page_id = ( empty($page_id_wpnonce) ? '' : sanitize_text_field( wp_unslash( $page_id_wpnonce ) ) );
$duration = filter_input( INPUT_GET, 'duration', FILTER_SANITIZE_STRING );
$last_week = ( isset( $duration ) && '7' === $duration ? 'active' : '' );
$month_1 = ( isset( $duration ) && '30' === $duration ? 'active' : '' );
?>


<div class="pvcp-main-dashboard full-cl res-cl">

    <?php 

if ( !empty($page_id) ) {
    ?>
        <h2>
            <?php 
    esc_html_e( get_the_title( $page_id ) . ' Page Summary', PVCP_TEXT_DOMAIN );
    ?>
            <a class="add-new-btn back-button" id="back_button" href="<?php 
    echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page' ) ) ;
    ?>">Back to Page List</a>
        </h2>
        <ul>
            <li><a class="pvcp-action-link <?php 
    echo  esc_attr( $last_week ) ;
    ?>" href="<?php 
    echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page&type=page&duration=7&page_id=' . esc_attr( $page_id ) ) ) ;
    ?>"><?php 
    esc_html_e( 'Last Week', PVCP_TEXT_DOMAIN );
    ?></a></li>
            <li><a class="pvcp-action-link <?php 
    echo  esc_attr( $month_1 ) ;
    ?>" href="<?php 
    echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page&type=page&duration=30&page_id=' . esc_attr( $page_id ) ) ) ;
    ?>"><?php 
    esc_html_e( '1 Month', PVCP_TEXT_DOMAIN );
    ?></a></li>
            <?php 
    ?>
        </ul>
        <!-- Page History Report-->
        <div class="dash-page-history pvcp-table-cover">
            <div id="chartContainerByPage<?php 
    echo  esc_attr( $page_id ) ;
    ?>" class="chartContainerHeight"></div>
        </div>

        <!-- Top Page List -->
        <div class="dash-top-page">
            <h2><?php 
    esc_html_e( get_the_title( $page_id ) . ' Page Summary', PVCP_TEXT_DOMAIN );
    ?></h2>
            <table class="pvcp-form-data-table display">
                <thead>
                    <tr>
                        <th><?php 
    esc_html_e( 'ID', PVCP_TEXT_DOMAIN );
    ?></th>
                        <th><?php 
    esc_html_e( 'Browser Name', PVCP_TEXT_DOMAIN );
    ?></th>
                        <th><?php 
    esc_html_e( 'IP Address', PVCP_TEXT_DOMAIN );
    ?></th>
                        <th><?php 
    esc_html_e( 'Date', PVCP_TEXT_DOMAIN );
    ?></th>
                        <?php 
    ?>
                    </tr>
                </thead>
                <tbody>
                <?php 
    $page_info = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}page_visit_history WHERE type = %s AND page_id = %d ORDER BY date DESC", 'page', $page_id ) );
    //db call ok; no-cache ok
    
    if ( $page_info ) {
        $i = 1;
        foreach ( $page_info as $in_page ) {
            
            if ( "MSIE" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/ie.png';
            } elseif ( "Firefox" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/firefox.png';
            } elseif ( "Opera" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/opera.png';
            } elseif ( "Chrome" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/chrome.png';
            } elseif ( "Safari" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/safari.png';
            } elseif ( "Netscape" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/netscape.png';
            } elseif ( "Edge" === $in_page->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/ie.png';
            } else {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/other-bw.png';
            }
            
            ?>

                            <tr>
                                <td><?php 
            esc_html_e( $i, PVCP_TEXT_DOMAIN );
            ?></td>
                                <td><img src="<?php 
            echo  esc_url( $browser_url ) ;
            ?>" title="<?php 
            echo  esc_attr( $in_page->browser_short_name ) ;
            ?>" alt="<?php 
            echo  esc_attr( $in_page->browser_short_name ) ;
            ?>" width="16"></td>
                                <td><?php 
            esc_html_e( $in_page->ipaddress, PVCP_TEXT_DOMAIN );
            ?></td>
                                <td><?php 
            esc_html_e( $in_page->date, PVCP_TEXT_DOMAIN );
            ?></td>
                                <?php 
            ?>
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
} else {
    ?>
        <h2>
            <?php 
    esc_html_e( 'Page Summary', PVCP_TEXT_DOMAIN );
    ?>
        </h2>
        <!-- Monthly Report -->
        <div class="monthly-report pvcp-table-cover">
            <h2><?php 
    esc_html_e( 'Monthly report', PVCP_TEXT_DOMAIN );
    ?></h2>
            <div id="chartContainerReportByMonthPage" class="chartContainerHeight"></div>
        </div>

        <!-- Top Page List -->
        <div class="dash-top-page">
            <h2><?php 
    esc_html_e( 'Pages Summary', PVCP_TEXT_DOMAIN );
    ?></h2>
            <table class="pvcp-form-data-table display">
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
    $top_pages = $wpdb->get_results( "SELECT page_id,http_referer,count(id) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type != 'post' GROUP BY page_id ORDER BY COUNT(id) DESC" );
    //db call ok; no-cache ok
    if ( $top_pages ) {
        foreach ( $top_pages as $dash_page ) {
            $pvcp_page_nonce = wp_create_nonce( 'pvcp-page-nonce' );
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
                            <td><a class="pvcp-action-link" id="<?php 
            echo  esc_attr( $dash_page->page_id ) ;
            ?>" href="<?php 
            echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-page&duration=30&type=page&page_id=' . esc_attr( $dash_page->page_id ) ) ) ;
            ?>"><?php 
            esc_html_e( $dash_page->visit, PVCP_TEXT_DOMAIN );
            ?></a></td>
                        </tr>
                        <?php 
        }
    }
    ?>
                </tbody>
            </table>
        </div>
    <?php 
}

?>

</div>
