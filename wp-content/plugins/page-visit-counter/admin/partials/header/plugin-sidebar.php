<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$image_url = esc_url( PVCP_PLUGIN_URL . 'admin/images/right_click.png' );
?>

<div class="dotstore_plugin_sidebar">
<?php 
$review_url = '';
$plugin_at = '';
$review_url = esc_url( 'https://wordpress.org/plugins/page-visit-counter/#reviews' );
$plugin_at = 'WP.org';
?>
    <div class="dotstore-important-link">
        <div class="image_box">
            <img src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/rate-us.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Rate us', 'size-chart-for-woocommerce' );
?> ">
        </div>
        <div class="content_box">
            <h3><?php 
esc_html_e( 'Like This Plugin?', PVCP_TEXT_DOMAIN );
?></h3>
            <p><?php 
esc_html_e( 'Your Review is very important to us as it helps us to grow more.', PVCP_TEXT_DOMAIN );
?></p>
            <a class="btn_style" href="<?php 
echo  $review_url ;
?>" target="_blank"><?php 
esc_html_e( 'Review Us on ', PVCP_TEXT_DOMAIN );
echo  $plugin_at ;
?></a>
        </div>
    </div>
    <div class="dotstore-important-link">
        <h2><span class="dotstore-important-link-title"><?php 
esc_html_e( 'Important link', PVCP_TEXT_DOMAIN );
?></span></h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank" href="javascript:void(0);"><?php 
esc_html_e( 'Plugin documentation', PVCP_TEXT_DOMAIN );
?></a>
                </li> 
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/support" ) ;
?>"><?php 
esc_html_e( 'Support platform', PVCP_TEXT_DOMAIN );
?></a>
                </li>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/suggest-a-feature/" ) ;
?>"><?php 
esc_html_e( 'Suggest A Feature', PVCP_TEXT_DOMAIN );
?></a>
                </li>
                <li>
                    <img src="<?php 
echo  esc_url( $image_url ) ;
?>">
                    <a  target="_blank" href="<?php 
echo  esc_url( 'https://www.thedotstore.com/page-visit-counter/#tab-change-log' ) ;
?>"><?php 
esc_html_e( 'Changelog', PVCP_TEXT_DOMAIN );
?></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="dotstore-important-link">
        <h2>
            <span class="dotstore-important-link-title">
                <?php 
esc_html_e( 'Our Popular plugins', PVCP_TEXT_DOMAIN );
?>
            </span>
        </h2>
        <div class="video-detail important-link">
            <ul>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Conditional-Product-Fees-For-WooCommerce-Checkout.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Conditional Product Fees For WooCommerce Checkout', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/product/woocommerce-extra-fees-plugin/" ) ;
?>">
                        <?php 
esc_html_e( 'Extra Fees Plugin for WooCommerce', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/plugn-login-128.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Hide Shipping Method For WooCommerce', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/hide-shipping-method-for-woocommerce/" ) ;
?>">
                        <?php 
esc_html_e( 'Hide Shipping Method For WooCommerce', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/WooCommerce Conditional Discount Rules For Checkout.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Conditional Discount Rules For WooCommerce Checkout', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/woocommerce-conditional-discount-rules-for-checkout/" ) ;
?>">
                        <?php 
esc_html_e( 'Conditional Discount Rules For WooCommerce Checkout', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/WooCommerce-Blocker-Prevent-Fake-Orders.png' ) ;
?>" alt="<?php 
esc_attr_e( 'WooCommerce Blocker – Prevent Fake Orders', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/woocommerce-anti-fraud" ) ;
?>">
                        <?php 
esc_html_e( 'WooCommerce Anti-Fraud', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/Advanced-Product-Size-Charts-for-WooCommerce.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Product Size Charts Plugin For WooCommerce', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/woocommerce-advanced-product-size-charts/" ) ;
?>">
                        <?php 
esc_html_e( 'Product Size Charts Plugin For WooCommerce', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/wcbm-logo.png' ) ;
?>" alt="<?php 
esc_attr_e( 'WooCommerce Category Banner Management', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/product/woocommerce-category-banner-management/" ) ;
?>">
                        <?php 
esc_html_e( 'WooCommerce Category Banner Management', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
                <li>
                    <img class="sidebar_plugin_icone" src="<?php 
echo  esc_url( plugin_dir_url( dirname( __FILE__, 2 ) ) . 'images/thedotstore-images/popular-plugins/woo-product-att-logo.png' ) ;
?>" alt="<?php 
esc_attr_e( 'Product Attachment For WooCommerce', PVCP_TEXT_DOMAIN );
?>">
                    <a target="_blank" href="<?php 
echo  esc_url( "https://www.thedotstore.com/woocommerce-product-attachment/" ) ;
?>">
                        <?php 
esc_html_e( 'Product Attachment For WooCommerce', PVCP_TEXT_DOMAIN );
?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="view-button">
            <a class="view_button_dotstore" href="<?php 
echo  esc_url( "http://www.thedotstore.com/plugins/" ) ;
?>"  target="_blank"><?php 
esc_html_e( 'View All', PVCP_TEXT_DOMAIN );
?></a>
        </div>
    </div>
    <!-- html end for popular plugin !-->

</div>	
</div>
</body>
</html>
