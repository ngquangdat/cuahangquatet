<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global  $wpdb ;
$post_id_wpnonce = filter_input( INPUT_GET, 'page_id', FILTER_SANITIZE_STRING );
$post_ids = ( empty($post_id_wpnonce) ? '' : sanitize_text_field( wp_unslash( $post_id_wpnonce ) ) );
$duration = filter_input( INPUT_GET, 'duration', FILTER_SANITIZE_STRING );
$last_week = ( isset( $duration ) && '7' === $duration ? 'active' : '' );
$month_1 = ( isset( $duration ) && '30' === $duration ? 'active' : '' );
?>


<div class="pvcp-main-dashboard full-cl res-cl">

    <?php 

if ( !empty($post_ids) ) {
    ?>
        <h2>
            <?php 
    esc_html_e( get_the_title( $post_ids ) . ' Post Summary', PVCP_TEXT_DOMAIN );
    ?>
            <a class="add-new-btn back-button" id="back_button" href="<?php 
    echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-post' ) ) ;
    ?>">Back to Post List</a>
        </h2>
        <ul>
            <li><a class="pvcp-action-link  <?php 
    echo  esc_attr( $last_week ) ;
    ?>" href="<?php 
    echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-post&type=post&duration=7&page_id=' . esc_attr( $post_ids ) ) ) ;
    ?>"><?php 
    esc_html_e( 'Last Week', PVCP_TEXT_DOMAIN );
    ?></a></li>
            <li><a class="pvcp-action-link  <?php 
    echo  esc_attr( $month_1 ) ;
    ?>" href="<?php 
    echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-post&type=post&duration=30&page_id=' . esc_attr( $post_ids ) ) ) ;
    ?>"><?php 
    esc_html_e( '1 Month', PVCP_TEXT_DOMAIN );
    ?></a></li>
            <?php 
    ?>
        </ul>
        <!-- Post History -->
        <div class="dash-post-history pvcp-table-cover">
            <div id="chartContainerByPage<?php 
    echo  esc_attr( $post_ids ) ;
    ?>" class="chartContainerHeight"></div>
        </div>

        <!-- Top Page List -->
        <div class="dash-top-page">
            <h2><?php 
    esc_html_e( get_the_title( $post_ids ) . ' Post Summary', PVCP_TEXT_DOMAIN );
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
    $post_info = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}page_visit_history WHERE type = %s AND page_id = %d ORDER BY date DESC", 'post', $post_ids ) );
    //db call ok; no-cache ok
    
    if ( $post_info ) {
        $i = 1;
        // get browser icon
        foreach ( $post_info as $in_post ) {
            
            if ( "MSIE" === $in_post->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/ie.png';
            } elseif ( "Firefox" === $in_post->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/firefox.png';
            } elseif ( "Opera" === $in_post->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/opera.png';
            } elseif ( "Chrome" === $in_post->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/chrome.png';
            } elseif ( "Safari" === $in_post->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/safari.png';
            } elseif ( "Netscape" === $in_post->browser_short_name ) {
                $browser_url = PVCP_PLUGIN_URL . 'admin/images/netscape.png';
            } elseif ( "Edge" === $in_post->browser_short_name ) {
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
            echo  esc_attr( $in_post->browser_short_name ) ;
            ?>" alt="<?php 
            echo  esc_attr( $in_post->browser_short_name ) ;
            ?>" width="16"></td>
                                <td><?php 
            esc_html_e( $in_post->ipaddress, PVCP_TEXT_DOMAIN );
            ?></td>
                                <td><?php 
            esc_html_e( $in_post->date, PVCP_TEXT_DOMAIN );
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
    esc_html_e( 'Post Summary', PVCP_TEXT_DOMAIN );
    ?>
        </h2>
        <!-- Monthly Report -->
        <div class="monthly-report pvcp-table-cover">
            <h2><?php 
    esc_html_e( 'Monthly report', PVCP_TEXT_DOMAIN );
    ?></h2>
            <div id="chartContainerReportByMonthPost" class="chartContainerHeight"></div>
        </div>

        <!-- Top Page List -->
        <div class="dash-top-page">
            <h2><?php 
    esc_html_e( 'Top Post', PVCP_TEXT_DOMAIN );
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
    $top_post = $wpdb->get_results( "SELECT page_id,http_referer,count(id) AS visit FROM {$wpdb->prefix}page_visit_history WHERE type='post' GROUP BY page_id ORDER BY COUNT(id) DESC" );
    //db call ok; no-cache ok
    if ( $top_post ) {
        foreach ( $top_post as $t_post ) {
            ?>
                        <tr>
                            <td><?php 
            esc_html_e( get_the_title( $t_post->page_id ), PVCP_TEXT_DOMAIN );
            ?></td>
                            <td><a href="<?php 
            echo  esc_url( $t_post->http_referer ) ;
            ?>" target="_blank"><?php 
            esc_html_e( get_the_title( $t_post->page_id ), PVCP_TEXT_DOMAIN );
            ?></a></td>
                            <td><a class="pvcp-action-link" id="<?php 
            echo  esc_attr( $t_post->page_id ) ;
            ?>" href="<?php 
            echo  esc_url( site_url( '/wp-admin/admin.php?page=pvcp-dashboard-post&duration=30&type=post&page_id=' . esc_attr( $t_post->page_id ) ) ) ;
            ?>"><?php 
            esc_html_e( $t_post->visit, PVCP_TEXT_DOMAIN );
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
