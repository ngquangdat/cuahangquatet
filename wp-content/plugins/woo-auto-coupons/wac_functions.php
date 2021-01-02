<?php
/*
Plugin Name: Auto Coupons for WooCommerce
Description: Apply WooCommerce Coupons automatically.
Author: Richard Lerma Design & Development
Version: 1.3.10
Text Domain: r1cm
Author URI: https://richardlerma.com/plugins/
Copyright: (c) 2019-2020 - richardlerma.com - All Rights Reserved
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
WC requires at least: 3.5.0
WC tested up to: 4.8
*/

global $wac_version; $wac_version='1.3.10';
if(!defined('ABSPATH')) exit;

function wac_error() {file_put_contents(dirname(__file__).'/error_activation.txt', ob_get_contents());}
if(defined('WP_DEBUG') && true===WP_DEBUG) add_action('activated_plugin','wac_error');

function wac_adminMenu() {
  if(current_user_can('manage_options')) {
    add_options_page('Auto Coupons','Auto Coupons','manage_options','woo-auto-coupons','wac_admin');
  }
}
//add_action('admin_menu','wac_adminMenu');

function wac_admin() { // Future admin settings
  global $wpdb;
  global $wac_version;
  wp_enqueue_style('wac_style',plugins_url('assets/wac_min.css?v='.$wac_version,__FILE__));
}
//add_shortcode('wp_admin','wac_admin');

function wac_activate($upgrade) {
  global $wpdb;
  global $wac_version;
  require_once(ABSPATH.basename(get_admin_url()).'/includes/upgrade.php');
  update_option('wac_db_version',$wac_version,'no');
  if(function_exists('wac_pro_ping'))wac_pro_ping(2);
}
register_activation_hook(__FILE__,'wac_activate');
function wac_shh() { ?><style type='text/css'>div.error{display:none!important}</style><?php }
if(wac_is_path(basename(get_admin_url()).'/plugins.php') && wac_is_path('plugin=woo-auto-coupons')) add_action('admin_head','wac_shh'); 

function wac_add_action_links($links) {
  $settings_url=get_admin_url(null,'edit.php?post_type=shop_coupon');
  $support_url='https://richardlerma.com/plugins/';
  $links[]='<a href="'.$support_url.'">Support</a>';
  array_push($links,'<a href="'.$settings_url.'">Settings</a>');
  return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__),'wac_add_action_links');

function wac_uninstall() {delete_option('wac_db_version');}
register_uninstall_hook(__FILE__,'wac_uninstall');

// Run Query
function wac_r($q,$t=NULL) {
  include_once(ABSPATH .'wp-includes/pluggable.php'); // If called prior to pluggable loaded natively
  require_once(ABSPATH .'wp-includes/wp-db.php');
  global $wpdb;
  if(!$wpdb) $wpdb=new wpdb(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
  $prf=$wpdb->prefix;
  $s=str_replace(' wp_',' '.$prf,$q);
  $s=str_replace($prf.str_replace('wp_','',$prf),$prf,$s);
  if(strpos($s,'DELETE')!==false || strpos($s,'INSERT')!==false) $r=$wpdb->query($s); else $r=$wpdb->get_results($s,OBJECT);
  if($t) {echo $wpdb->last_error."<br>";echo $s;}
  if($r) return $r;
}

// Strict Comparison
function wac_in ($n,$h) {
  if(!is_array($h)) $h=explode(',',$h);
  if(in_array($n,$h,true)!==false) return true;return false;
}

// Loose Comparison (regardless of vars types)
function wac_in_like($n,$h) {
  if(!is_array($h)) $h=explode(',',$h);
  foreach($h as $item) {
    if(!empty($item)) if(stripos($n,$item)!==false) return true;
  }
  return false;
}

// Path Comparison
function wac_is_path($pages) {
  $page=strtolower($_SERVER['REQUEST_URI']);
  return wac_in_like($page,$pages);
}

// Apply WC Coupons
function wac_is_coupon_valid($coupon_code,$dsp_err=0) {
  $coupon=new \WC_Coupon($coupon_code);   
  $discounts=new \WC_Discounts(WC()->cart);
  $status=$discounts->is_coupon_valid($coupon);
  if(is_wp_error($status)) {if($dsp_err>0) return $status->get_error_message(); else return false;} else return true;
}

function wac_qty_in_cart($product_id) {
  global $woocommerce;
  $cart=$woocommerce->cart;
  $qty=0;
  foreach($cart->cart_contents as $cart_item_key=>$cart_item) {
    if(wac_in_like($cart_item['product_id'],$product_id) || wac_in_like($cart_item['variation_id'],$product_id)) $qty=$qty+$cart_item['quantity'];
  }
  return $qty;
}

function wac_apply_coupons() {
  if(current_user_can('administrator') && isset($_GET['troubleshoot'])) $trb=1; else $trb=0;
  $req=$req2='';
  $meta='_wc_%_apply';
  $cart_ip=sanitize_text_field($_SERVER['REMOTE_ADDR']);
  global $woocommerce,$coupon_codes;
  $cart=$woocommerce->cart; //print_r($cart);
  $cart_items=$auto_apply_indv=0;

  if(isset($_GET['coupon'])) {$coupon=sanitize_text_field($_GET['coupon']); $req.=" AND post_title='$coupon'"; $meta='_wc_url_apply';}
  else {
    if($woocommerce->cart->get_cart_contents_count()>0) {
      $cache_coupon=get_transient("wac_$cart_ip");
      if(!empty($cache_coupon)) {$coupon=$cache_coupon; delete_transient("wac_$cart_ip");}
    }
  }
  
  if($trb<1) {
    $req.=" AND IFNULL(NULLIF(FROM_UNIXTIME(x.meta_value),''),NOW())>=NOW()";
    $req2.=" WHERE(individual='yes' OR apply IS NOT NULL)";
  }
  $coupons=wac_r("
    SELECT * FROM (
      SELECT post_title coupon_code 
      ,(SELECT meta_value FROM wp_postmeta WHERE post_id=p.ID AND meta_key='product_ids' LIMIT 1)product_ids
      ,(SELECT post_title FROM wp_posts WHERE ID IN (SELECT meta_value FROM wp_postmeta WHERE post_id=p.ID AND meta_key='product_ids') LIMIT 1)product
      ,(SELECT meta_value FROM wp_postmeta WHERE post_id=p.ID AND meta_key='individual_use' LIMIT 1)individual
      ,(SELECT meta_value FROM wp_postmeta WHERE post_id=p.ID AND meta_key='coupon_amount' LIMIT 1)coupon_amount
      ,(SELECT meta_value FROM wp_postmeta WHERE post_id=p.ID AND meta_key='_wc_min_qty' LIMIT 1)min_qty
      ,(SELECT meta_value FROM wp_postmeta WHERE post_id=p.ID AND meta_key='_wc_max_qty' LIMIT 1)max_qty
      ,(SELECT meta_key FROM wp_postmeta WHERE post_id=p.ID AND meta_key LIKE '$meta' AND meta_value='yes' LIMIT 1)apply
      ,DATE_FORMAT(FROM_UNIXTIME(meta_value),'%m-%d-%Y')exp_date
      ,CASE WHEN FROM_UNIXTIME(meta_value)<NOW() THEN 1 ELSE 0 END exp
      FROM wp_posts p
      LEFT JOIN wp_postmeta x ON x.post_id=p.ID AND x.meta_key='date_expires'
      WHERE post_type='shop_coupon'
      AND post_status='publish'
      $req
    )a
    $req2
    ORDER BY exp,individual DESC,CAST(coupon_amount AS SIGNED) DESC;");
  if(!$coupons) return; 

  
  foreach($cart->cart_contents as $cart_item_key=>$cart_item) $cart_items++;

  $coupon_codes[]='';
  $coupon_count=count($coupons);
  foreach($coupons as $c) {
    $valid=1;
    $coupon_code=ucwords($c->coupon_code);
    $reason=$individual_use=$apply_type='';
    $qty_in_cart=wac_qty_in_cart($c->product_ids);

    if($c->individual=='yes') $individual_use='[Individual Use]';
    if(!empty($auto_apply_indv)) {$valid=0; $reason.=" Individual use coupon [$auto_apply_indv] has already been applied.";}
    if($c->exp>0 && $trb>0) {$valid=0; $reason.=" Expired {$c->exp_date}.";}
    if(!empty($c->product_ids) && $qty_in_cart<1 && empty($coupon)) {if($trb>0) {$valid=0; $reason.=' No qualifying cart items.';} else continue;}
    if(wac_in(strtolower($coupon_code),$cart->applied_coupons)) $applied=1; else $applied=0;
    if($cart_items==0 && empty($coupon)) {$valid=0; $reason.=' No Items in Cart.';}

    if($valid>0 && ($c->min_qty>0 || $c->max_qty>0)) { // Check Qty
      if($c->min_qty>0 && $qty_in_cart<$c->min_qty) {$valid=0; if($trb>0) $reason.=' Min quantity not met.'; else echo "<div class='woocommerce-message wac'><i class='fas fa-sort-amount-up'></i> Add ".floatval($c->min_qty-$qty_in_cart)." more ".$c->product." to qualify for a discount.</div>";}
      if($c->max_qty>0 && $qty_in_cart>$c->max_qty) {$valid=0; if($trb>0) $reason.=' Max quantity exceeded.'; else echo "<div class='woocommerce-message wac'><i class='fas fa-sort-amount-down'></i> Reduce ".$c->product." quantity to ".$c->max_qty." to qualify for a discount.</div>";}
    }

    if($valid>0) $valid=wac_is_coupon_valid($coupon_code);

    if($valid>0 && ($applied>0 || !empty($coupon) || $c->apply=='_wc_auto_apply')) {
      if(!$applied) $woocommerce->cart->add_discount($coupon_code); // Apply To Cart
      if($woocommerce->cart->get_cart_contents_count()==0) set_transient("wac_$cart_ip",$coupon_code,3600);
      $apply_type='';
      if($c->apply=='_wc_auto_apply') {
        $apply_type=' Auto-'; 
        if(!empty($individual_use)) $auto_apply_indv=$coupon_code; 
        if(wac_is_path('ajax,add-to-cart')===false) {?><style>.cart-discount.coupon-<?php echo strtolower(str_replace(' ','-',$coupon_code));?> .woocommerce-remove-coupon{display:none!important}</style><?php }
        array_push($coupon_codes,$coupon_code); // Style line item
      }
      if($trb>0) echo "<div class='woocommerce-message wac trb'><i class='fas fa-check-circle'></i> $coupon_code - {$apply_type}Applied successfully $individual_use</div>";
    } elseif($valid>0 && $trb>0) {
      $apply_type=' via manual entry';
      if(stripos($c->apply,'url')!==false) $apply_type.=' or URL';
      echo "<div class='woocommerce-message wac trb'><i class='fas fa-check-circle'></i> $coupon_code - Eligible $apply_type. $individual_use</div>";
    }

    if($valid==0) {
      if($applied) $woocommerce->cart->remove_coupon($coupon_code); // Remove From Cart
      if(!$applied && $trb>0) {
        if(empty($reason)) $reason=wac_is_coupon_valid($coupon_code,1);
        echo "<div class='woocommerce-message wac trb'><i class='fas fa-exclamation-triangle'></i> $coupon_code -$reason</div>";
      }
    }

  } 
  if(wac_is_path('ajax')===false) add_action('wp_footer','wac_style_coupons');
}

add_action('woocommerce_add_to_cart','wac_apply_coupons'); // Product
add_action('woocommerce_before_checkout_form','wac_apply_coupons'); // Cart
add_action('woocommerce_before_cart','wac_apply_coupons'); // Checkout
if(isset($_GET['coupon'])) add_action('template_redirect','wac_apply_coupons'); // URL Apply


function wac_style_coupons() { 
  global $coupon_codes;
  if(empty($coupon_codes)) return;
  foreach($coupon_codes as $coupon_code) {
    $coupon_code=str_replace(' ','-',$coupon_code);?>
    <script type='text/javascript'>setTimeout(function(){wac_style_cpn('<?php echo strtolower($coupon_code);?>');},1000);</script><?php 
  } ?>
  <style>
    .woocommerce .wac .fas{zoom:1.3}
    .woocommerce .wac .fa-sort-amount-up{color:#77c777}
    .woocommerce .wac .fa-sort-amount-down{color:darkorange}
    .woocommerce .wac.trb:before{content:''}
    .woocommerce .wac.trb{background:rgba(220,220,220,.5);color:#777}
    .woocommerce .wac.trb .fa-exclamation-triangle{color:#ffa2a2}
    .woocommerce .wac.trb .fa-check-circle{color:#77c777}
    .woocommerce-message.wac.trb{margin-bottom:1em;padding:1em}
    .woocommerce .cart-discount td[data-title],.woocommerce .cart-discount .amount{color:green}
    .woocommerce .cart-discount th,.woocommerce .cart-discount td[data-title]:before{font-weight:normal}
    .woocommerce .cart-discount td:after,.woocommerce .cart-discount td[data-title]:after{content:"\00a0 \f14a";display:inline-block;font-family:'Font Awesome 5 Free';position:absolute;margin-top:-.5em;opacity:0;-webkit-transition:all 1s;transition:all 1s}
    .woocommerce .cart-discount td[data-title]:before{color:#6d6d6d;font-weight:normal;white-space:pre-wrap}
    .woocommerce .cart-discount.anm td:after{opacity:1;margin-left:-3em;color:green;font-size:2em}
  </style>
  <script type='text/javascript'>
    function wac_rc(e){setTimeout(function(){e.classList.remove('anm');},3000);}
    function wac_style_cpn(coupon_code) {
      var coupon_class='coupon-'+coupon_code;
      if(!document.getElementsByClassName(coupon_class)) return;
      cpn=document.getElementsByClassName(coupon_class);
      for(i=0; i<cpn.length; i++) {
        cpn[i].innerHTML=cpn[i].innerHTML.replace(/Coupon:/g,"");
        cpn[i].classList.add('anm');
        wac_rc(cpn[i]);
      }
    }
    setTimeout(function(){wac_style_cpn('<?php echo strtolower($coupon_code);?>');},1500);
  </script><?php 
}


// WC Admin Coupon Quantity
function wac_qty_add_coupon_field() {
  echo "<div class='options_group'>
    <p class='form-field' style='background:#0073aa;margin:1em 0 0'><label style='color:#fff;font-variant-caps:all-small-caps;font-size:1.3em'><span class='dashicons dashicons-admin-settings' style='vertical-align:text-top'></span> Auto Coupons</label></p>";
    woocommerce_wp_checkbox(array('id'=>'_wc_url_apply','label'=> __('Apply via URL','wc-url-apply'),'placeholder'=>'','description'=> __('This setting will apply coupon to qualifying carts upon visiting /?coupon=<span id=\'cname\'>COUPON_NAME</span>.<br><span class=\'wac_restr\'>&#9888; <i>If usage restrictions are present, product must be in cart when URL is visited.</i></span>','wc-url-apply')));
    woocommerce_wp_checkbox(array('id'=>'_wc_auto_apply','label'=> __('Auto Apply','wc-auto-apply'),'placeholder'=>'','desc_tip'=>'true','description'=> __('This setting will apply the coupon to ALL qualifying carts on the cart and checkout page.','wc-auto-apply')));
  echo "<div class='_wc_qty'>";
    woocommerce_wp_text_input(array('id'=>'_wc_min_qty','label'=> __('Min Product Quantity','wc-min-qty'),'placeholder'=>'Optional','desc_tip'=>'true','description'=> __('Set a minimum product quantity for this coupon. Enter a number, 1 or greater.','wc-min-qty')));
    woocommerce_wp_text_input(array('id'=>'_wc_max_qty','label'=> __('Max Product Quantity','wc-max-qty'),'placeholder'=>'Optional','desc_tip'=>'true','description'=> __('Set a maximum quantity limit allowed per coupon. Enter a number, 1 or greater.','wc-max-qty')));
  echo "</div>
    </div>
    <style>
      .woocommerce_options_panel p._wc_url_apply_field{background:#f8f8f8;padding-top:1em!important;padding-bottom:1em!important;margin-top:0}
      .wac_restr{color:#0073ab;font-size:.9em}
    </style>
    <script type='text/javascript'>
      function wac_cname() {
        if(document.getElementById('title').value.length>0) document.getElementById('cname').innerHTML=document.getElementById('title').value;
      }
      wac_cname();
      
      function wac_dsp_qty() {
        wcaa=document.getElementById('_wc_auto_apply');
        wcmn=document.getElementById('_wc_min_qty');
        wcmx=document.getElementById('_wc_max_qty');
        if(wcmn.value>0) tmn=wcmn.value;
        if(wcmx.value>0) tmx=wcmx.value;
        if(wcaa.checked) {
          document.getElementsByClassName('_wc_qty')[0].style.visibility='visible';
          if(typeof tmn!=='undefined') wcmn.value=tmn;
          if(typeof tmx!=='undefined') wcmx.value=tmx;
          if(wcmn.value>0 && wcmx.value && parseInt(wcmn.value)>parseInt(wcmx.value)) alert('Min quantity must be less than max quantity.');
        } else {
          wcmn.value=wcmx.value='';
          document.getElementsByClassName('_wc_qty')[0].style.visibility='hidden';
        }
      }
      wac_dsp_qty();
      
      function wac_val_qty() {
        wcmn=document.getElementById('_wc_min_qty');
        wcmx=document.getElementById('_wc_max_qty');
        if(wcmn.value>0 && wcmx.value && parseInt(wcmn.value)>parseInt(wcmx.value)) {
          alert('Min quantity must be less than max quantity.');
          wcmn.style.borderColor='red';
        } else wcmn.style.borderColor='';
      }

      function wac_activate(wac_id) {
        cpn=document.getElementById('title').value;
        expiry=document.getElementById('expiry_date');
        var todayDate=new Date().toISOString().slice(0,10);
        if(expiry.value.length>0 && expiry.value<=todayDate){alert('This coupon expired on '+expiry.value+' and it cannot be auto-applied.');expiry.focus();return false;}
        if(wac_id=='_wc_auto_apply')alert('This setting will apply the '+cpn+' coupon to ALL qualifying carts on the cart and checkout page.');
        if(wac_id=='_wc_url_apply')alert('This setting will apply the coupon to qualifying carts upon visiting:\\n/?coupon='+cpn+'.');
        return true;
      }
      
      document.getElementById('title').onchange=function(){wac_cname();};
      document.getElementById('titlewrap').onclick=function(){wac_cname();};
      document.getElementById('_wc_min_qty').onchange=function(){wac_val_qty();};
      document.getElementById('_wc_max_qty').onchange=function(){wac_val_qty();};
      document.getElementById('_wc_auto_apply').onclick=function(){if(this.checked)if(!wac_activate(this.id))this.checked=false;wac_dsp_qty();}
      document.getElementById('_wc_url_apply').onclick=function() {if(this.checked)if(!wac_activate(this.id))this.checked=false;wac_dsp_qty();}
    </script>
  ";
}
add_action('woocommerce_coupon_options','wac_qty_add_coupon_field');


// WC Save Admin Coupon Fields
function wac_qty_save_coupon($post_id,$coupon){
  $val_url=trim(get_post_meta($post_id,'_wc_url_apply',true));
  $new_url=sanitize_text_field($_POST['_wc_url_apply']);
  if($val_url!=$new_url)update_post_meta($post_id,'_wc_url_apply',$new_url);
  
  $val_auto=trim(get_post_meta($post_id,'_wc_auto_apply',true));
  $new_auto=sanitize_text_field($_POST['_wc_auto_apply']);
  if($val_auto!=$new_auto)update_post_meta($post_id,'_wc_auto_apply',$new_auto);

  $val_min=trim(get_post_meta($post_id,'_wc_min_qty',true));
  $new_min=sanitize_text_field($_POST['_wc_min_qty']);
  if($val_min!=$new_min)update_post_meta($post_id,'_wc_min_qty',$new_min);
  
  $val_max=trim(get_post_meta($post_id,'_wc_max_qty',true));
  $new_max=sanitize_text_field($_POST['_wc_max_qty']);
  if($val_max!=$new_max)update_post_meta($post_id,'_wc_max_qty',$new_max);
}
add_action('woocommerce_coupon_options_save','wac_qty_save_coupon',10,2);
