<?php

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.thedotstore.com/
 * @since      1.0.0
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Page_Visit_Counter
 * @subpackage Page_Visit_Counter/public
 * @author     Thedotstore <support@thedotstore.com>
 */
class Page_Visit_Counter_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Page_Visit_Counter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Page_Visit_Counter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/page-visit-counter-public.css',
            array(),
            $this->version,
            'all'
        );
        $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
        $pvcp_general_css = ( isset( $general_wizard_setting['pvcp_general_css'] ) && !empty($general_wizard_setting['pvcp_general_css']) ? $general_wizard_setting['pvcp_general_css'] : '' );
        if ( $pvcp_general_css ) {
            wp_add_inline_style( $this->plugin_name, $pvcp_general_css );
        }
        $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
        
        if ( isset( $general_wizard_setting['pvcp_general_font'] ) && !empty($general_wizard_setting['pvcp_general_font']) ) {
            $font_value = str_replace( ' ', '+', $general_wizard_setting['pvcp_general_font'] );
            wp_enqueue_style(
                $this->plugin_name . 'pvcp-google-font',
                'http://fonts.googleapis.com/css?family=' . $font_value,
                array(),
                $this->version
            );
        }
    
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Page_Visit_Counter_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Page_Visit_Counter_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/page-visit-counter-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    /**
     * action use in call header
     * Insert_page_visit_counter function use insert the page data
     * pageid,Currentdate,Ipaddress,pagecount add in database.
     */
    public function insert_page_visit_counter()
    {
        global  $wpdb, $wp ;
        $flag = 0;
        // Check the site running on HTTPS. If the site running on HTTPS then we are removing S from HTTPS
        
        if ( is_ssl() ) {
            $actual_link = "https://";
            if ( isset( $_SERVER['HTTP_HOST'] ) ) {
                $actual_link .= sanitize_text_field( $_SERVER['HTTP_HOST'] );
            }
            if ( isset( $_SERVER['REQUEST_URI'] ) ) {
                $actual_link .= sanitize_text_field( $_SERVER['REQUEST_URI'] );
            }
            
            if ( strpos( $actual_link, 'wp-admin' ) !== false ) {
                $page = 0;
                $flag = 1;
            } else {
                $page = url_to_postid( preg_replace( '/^https(?=:\\/\\/)/i', 'http', esc_url( $actual_link ) ) );
            }
        
        } else {
            $actual_link = "http://";
            if ( isset( $_SERVER['HTTP_HOST'] ) ) {
                $actual_link .= sanitize_text_field( $_SERVER['HTTP_HOST'] );
            }
            if ( isset( $_SERVER['REQUEST_URI'] ) ) {
                $actual_link .= sanitize_text_field( $_SERVER['REQUEST_URI'] );
            }
            
            if ( strpos( $actual_link, 'wp-admin' ) !== false ) {
                $page = 0;
                $flag = 1;
            } else {
                $page = url_to_postid( esc_url( $actual_link ) );
            }
        
        }
        
        
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
            if ( is_shop() ) {
                $page = (int) get_option( 'woocommerce_shop_page_id' );
            }
            if ( is_cart() ) {
                $page = (int) get_option( 'woocommerce_cart_page_id' );
            }
            if ( is_checkout() ) {
                $page = (int) get_option( 'woocommerce_checkout_page_id' );
            }
        }
        
        if ( $flag === 0 ) {
            
            if ( $page === 0 ) {
                $page = get_the_ID();
                
                if ( $page === 0 ) {
                    $current_url = home_url( $wp->request );
                    
                    if ( is_ssl() ) {
                        $page = url_to_postid( preg_replace( '/^https(?=:\\/\\/)/i', 'http', $current_url ) );
                    } else {
                        $page = url_to_postid( $current_url );
                    }
                    
                    
                    if ( $page === 0 ) {
                        $queried_object = get_queried_object();
                        
                        if ( $queried_object ) {
                            $post_id = $queried_object->ID;
                            $page = $post_id;
                        }
                    
                    }
                
                }
            
            }
        
        }
        
        if ( $page !== 0 ) {
            
            if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
                $ipaddress = sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
            } else {
                $ipaddress = "";
            }
            
            $ipdat = @json_decode( file_get_contents( "http://www.geoplugin.net/json.gp?ip={$ipaddress}" ) );
            //$country = $ipdat->geoplugin_countryName . " (" . $ipdat->geoplugin_countryCode . ")";
            $country = $ipdat->geoplugin_countryCode;
            $user_id = get_current_user_id();
            
            if ( $user_id ) {
                $user = get_userdata( $user_id );
                $user_roles_arr = $user->roles;
                $user_role = $user_roles_arr[0];
            } else {
                $user_role = 'guest';
            }
            
            
            if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
                $u_agent = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
            } else {
                $u_agent = "";
            }
            
            $version = "";
            //First get the platform?
            
            if ( preg_match( '/linux/i', $u_agent ) ) {
                $platform = 'Linux';
            } elseif ( preg_match( '/macintosh|mac os x/i', $u_agent ) ) {
                $platform = 'macOS';
            } elseif ( preg_match( '/windows|win32/i', $u_agent ) ) {
                $platform = 'Windows';
            } else {
                $platform = 'Unknown';
            }
            
            // Next get the name of the useragent yes seperately and for good reason
            
            if ( preg_match( '/MSIE/i', $u_agent ) && !preg_match( '/Opera/i', $u_agent ) ) {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            } elseif ( preg_match( '/Firefox/i', $u_agent ) ) {
                $bname = 'Mozilla Firefox';
                $ub = "Firefox";
            } elseif ( preg_match( '/OPR/i', $u_agent ) ) {
                $bname = 'Opera';
                $ub = "Opera";
            } elseif ( preg_match( '/Chrome/i', $u_agent ) && !preg_match( '/Edge/i', $u_agent ) ) {
                $bname = 'Google Chrome';
                $ub = "Chrome";
            } elseif ( preg_match( '/Safari/i', $u_agent ) && !preg_match( '/Edge/i', $u_agent ) ) {
                $bname = 'Apple Safari';
                $ub = "Safari";
            } elseif ( preg_match( '/Netscape/i', $u_agent ) ) {
                $bname = 'Netscape';
                $ub = "Netscape";
            } elseif ( preg_match( '/Edge/i', $u_agent ) ) {
                $bname = 'Edge';
                $ub = "Edge";
            } elseif ( preg_match( '/Trident/i', $u_agent ) ) {
                $bname = 'Internet Explorer';
                $ub = "MSIE";
            } else {
                $bname = 'Unknown';
                $ub = "Unknown";
            }
            
            // finally get the correct version number
            $known = array( 'Version', $ub, 'other' );
            $pattern = '#(?<browser>' . join( '|', $known ) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if ( !preg_match_all( $pattern, $u_agent, $matches ) ) {
                // we have no matching number just continue
            }
            // see how many we have
            $i = count( $matches['browser'] );
            
            if ( $i !== 1 ) {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                
                if ( strripos( $u_agent, "Version" ) < strripos( $u_agent, $ub ) ) {
                    $version = $matches['version'][0];
                } else {
                    $version = ( isset( $matches['version'][1] ) ? $matches['version'][1] : null );
                }
            
            } else {
                $version = ( isset( $matches['version'][0] ) ? $matches['version'][0] : null );
            }
            
            // check if we have a number
            if ( $version === null || $version === "" ) {
                $version = "?";
            }
            
            if ( array_key_exists( 'HTTPS', $_SERVER ) && $_SERVER["HTTPS"] === "on" ) {
                $http_referer = 'https://';
            } else {
                $http_referer = 'http://';
            }
            
            if ( isset( $_SERVER['HTTP_HOST'] ) ) {
                $http_referer .= sanitize_text_field( $_SERVER['HTTP_HOST'] );
            }
            if ( isset( $_SERVER['REQUEST_URI'] ) ) {
                $http_referer .= sanitize_text_field( $_SERVER['REQUEST_URI'] );
            }
            // refer url
            
            if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
                $site_url = get_site_url();
                $site_parse = wp_parse_url( $site_url );
                $site_host = $site_parse['host'];
                if ( substr( $site_host, 0, 4 ) === "www." ) {
                    $site_host = substr( $site_host, 4 );
                }
                $referer = sanitize_text_field( $_SERVER['HTTP_REFERER'] );
                $parse = wp_parse_url( $referer );
                $host = $parse['host'];
                if ( substr( $host, 0, 4 ) === "www." ) {
                    $host = substr( $host, 4 );
                }
                
                if ( $host !== $site_host ) {
                    $reff_host = $host;
                } else {
                    $reff_host = "";
                }
            
            } else {
                $reff_host = "";
            }
            
            // Page Type
            $type = get_post_type( $page );
            
            if ( !empty($reff_host) ) {
                $wpdb->query( $wpdb->prepare(
                    "INSERT into {$wpdb->prefix}page_visit_referer \n                        (`page_id`, `type`, `date`, `http_referer`, `ref_url`) \n                        VALUES (%d, %s, %s, %s, %s)",
                    $page,
                    $type,
                    date( "Y/m/d" ),
                    $http_referer,
                    $reff_host
                ) );
                //db call ok; no-cache ok
            }
            
            $today_Data = $wpdb->get_results( $wpdb->prepare( "SELECT user_id,ipaddress,browser_short_name FROM {$wpdb->prefix}page_visit_history WHERE date = %s AND page_id = %d", date( "Y/m/d" ), $page ) );
            //db call ok; no-cache ok
            $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
            $page_meta_value = get_post_meta( $page, 'enable_page_count' );
            $post = get_post( $page );
            // check shortcode is available or not in page/post
            if ( $post ) {
                
                if ( strpos( $post->post_content, '[pvcp_' ) === false ) {
                    $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
                    // get general wizard setting
                    // get ipaddress
                    
                    if ( isset( $general_wizard_setting['pvcp_general_ip'] ) && !empty($general_wizard_setting['pvcp_general_ip']) ) {
                        $def_wz_ip_address = $general_wizard_setting['pvcp_general_ip'];
                    } else {
                        $def_wz_ip_address = '';
                    }
                    
                    // get user ID
                    
                    if ( isset( $general_wizard_setting['pvcp_general_user'] ) && !empty($general_wizard_setting['pvcp_general_user']) ) {
                        $def_wz_user_id = $general_wizard_setting['pvcp_general_user'];
                    } else {
                        $def_wz_user_id = '';
                    }
                    
                    if ( empty($page_meta_value) || in_array( 'yes', $page_meta_value ) ) {
                        if ( (empty($def_wz_ip_address) || !in_array( $ipaddress, $def_wz_ip_address )) && (empty($def_wz_user_id) || !in_array( $user_id, $def_wz_user_id )) ) {
                            
                            if ( $today_Data ) {
                                $flag = 0;
                                foreach ( $today_Data as $info ) {
                                    $today_user_id = $info->user_id;
                                    $today_ipaddress = $info->ipaddress;
                                    $today_browser = $info->browser_short_name;
                                    
                                    if ( $today_user_id === strval( $user_id ) && $today_ipaddress === $ipaddress && $today_browser === $ub ) {
                                        $flag = 0;
                                        break;
                                    } else {
                                        $flag = 1;
                                    }
                                
                                }
                                if ( $flag === 1 && !empty($type) ) {
                                    
                                    if ( empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] ) ) {
                                        $wpdb->query( $wpdb->prepare(
                                            "INSERT into {$wpdb->prefix}page_visit_history \n                                (`page_id`, `user_id`, `user_role`, `date`, `lastdate`, `ipaddress`, `country`,`browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`, `type`) \n                                VALUES (%d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                            $page,
                                            $user_id,
                                            $user_role,
                                            date( "Y/m/d" ),
                                            date( "Y/m/d" ),
                                            $ipaddress,
                                            $country,
                                            $bname,
                                            $ub,
                                            $version,
                                            $platform,
                                            $http_referer,
                                            $type
                                        ) );
                                        //db call ok; no-cache ok
                                    }
                                
                                }
                            } else {
                                if ( !empty($type) ) {
                                    
                                    if ( empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] ) ) {
                                        $wpdb->query( $wpdb->prepare(
                                            "INSERT into {$wpdb->prefix}page_visit_history \n                                (`page_id`, `user_id`, `user_role`, `date`, `lastdate`, `ipaddress`, `country`,`browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`, `type`) \n                                VALUES (%d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                            $page,
                                            $user_id,
                                            $user_role,
                                            date( "Y/m/d" ),
                                            date( "Y/m/d" ),
                                            $ipaddress,
                                            $country,
                                            $bname,
                                            $ub,
                                            $version,
                                            $platform,
                                            $http_referer,
                                            $type
                                        ) );
                                        //db call ok; no-cache ok
                                    }
                                
                                }
                            }
                        
                        }
                    }
                } else {
                    $get_page_shortcode = self::pvcp_get_string_part( $post->post_content, '[pvcp_', ']' );
                    $wzResult = $wpdb->get_results( $wpdb->prepare( "SELECT wizard_setting,status FROM {$wpdb->prefix}page_visit_wizard WHERE shortcode = %s", $get_page_shortcode ) );
                    //db call ok; no-cache ok
                    
                    if ( $wzResult ) {
                        $page_wizards = maybe_unserialize( $wzResult[0]->wizard_setting );
                        // get individual wizard setting
                    }
                    
                    $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
                    // get general wizard setting
                    // get ipaddress
                    
                    if ( isset( $page_wizards['pvcp_ind_wz_ip'] ) && !empty($page_wizards['pvcp_ind_wz_ip']) ) {
                        $wz_ip_addres = $page_wizards['pvcp_ind_wz_ip'];
                    } elseif ( isset( $general_wizard_setting['pvcp_general_ip'] ) && !empty($general_wizard_setting['pvcp_general_ip']) ) {
                        $wz_ip_addres = $general_wizard_setting['pvcp_general_ip'];
                    } else {
                        $wz_ip_addres = '';
                    }
                    
                    // get user ID
                    
                    if ( isset( $page_wizards['pvcp_ind_wz_user'] ) && !empty($page_wizards['pvcp_ind_wz_user']) ) {
                        $wz_user_id = $page_wizards['pvcp_ind_wz_user'];
                    } elseif ( isset( $general_wizard_setting['pvcp_general_user'] ) && !empty($general_wizard_setting['pvcp_general_user']) ) {
                        $wz_user_id = $general_wizard_setting['pvcp_general_user'];
                    } else {
                        $wz_user_id = '';
                    }
                    
                    if ( empty($page_meta_value) || in_array( 'yes', $page_meta_value ) ) {
                        if ( (empty($wz_ip_addres) || !in_array( $ipaddress, $wz_ip_addres )) && (empty($wz_user_id) || !in_array( $user_id, $wz_user_id )) ) {
                            
                            if ( $today_Data ) {
                                $flag = 0;
                                foreach ( $today_Data as $info ) {
                                    $today_user_id = $info->user_id;
                                    $today_ipaddress = $info->ipaddress;
                                    $today_browser = $info->browser_short_name;
                                    
                                    if ( $today_user_id === strval( $user_id ) && $today_ipaddress === $ipaddress && $today_browser === $ub ) {
                                        $flag = 0;
                                        break;
                                    } else {
                                        $flag = 1;
                                    }
                                
                                }
                                if ( $flag === 1 && !empty($type) ) {
                                    
                                    if ( empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] ) ) {
                                        $wpdb->query( $wpdb->prepare(
                                            "INSERT into {$wpdb->prefix}page_visit_history \n                            (`page_id`, `user_id`, `user_role`, `date`, `lastdate`, `ipaddress`, `country`,`browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`, `type`) \n                            VALUES (%d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                            $page,
                                            $user_id,
                                            $user_role,
                                            date( "Y/m/d" ),
                                            date( "Y/m/d" ),
                                            $ipaddress,
                                            $country,
                                            $bname,
                                            $ub,
                                            $version,
                                            $platform,
                                            $http_referer,
                                            $type
                                        ) );
                                        //db call ok; no-cache ok
                                    }
                                
                                }
                            } else {
                                if ( !empty($type) ) {
                                    
                                    if ( empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] ) ) {
                                        $wpdb->query( $wpdb->prepare(
                                            "INSERT into {$wpdb->prefix}page_visit_history \n                            (`page_id`, `user_id`, `user_role`, `date`, `lastdate`, `ipaddress`, `country`,`browser_full_name`, `browser_short_name`, `browser_version`, `os`, `http_referer`, `type`) \n                            VALUES (%d, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                            $page,
                                            $user_id,
                                            $user_role,
                                            date( "Y/m/d" ),
                                            date( "Y/m/d" ),
                                            $ipaddress,
                                            $country,
                                            $bname,
                                            $ub,
                                            $version,
                                            $platform,
                                            $http_referer,
                                            $type
                                        ) );
                                        //db call ok; no-cache ok
                                    }
                                
                                }
                            }
                        
                        }
                    }
                }
            
            }
        }
    
    }
    
    function pvcp_get_string_part( $string, $startStr, $endStr )
    {
        $startpos = strpos( $string, $startStr );
        $endpos = strpos( $string, $endStr, $startpos );
        $endpos = $endpos - $startpos + 1;
        $string = substr( $string, $startpos, $endpos );
        return $string;
    }
    
    /**
     * Display default page visit counter without shortcode for all page/post
     *
     * @since    1.0.0
     *
     * @param $content
     *
     * @return string
     */
    public function default_page_visit_counter( $content )
    {
        global  $wpdb ;
        
        if ( is_ssl() ) {
            $actual_link = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $current_page_id = url_to_postid( preg_replace( '/^https(?=:\\/\\/)/i', 'http', esc_url( $actual_link ) ) );
        } else {
            $actual_link = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $current_page_id = url_to_postid( esc_url( $actual_link ) );
        }
        
        if ( ($_SERVER['REQUEST_URI'] == '/shop/' || strpos( $_SERVER['REQUEST_URI'], '/shop/' ) !== false) && $current_page_id == 0 ) {
            $current_page_id = (int) get_option( 'woocommerce_shop_page_id' );
        }
        $type = get_post_type( $current_page_id );
        $totalWebsiteVisitsHtml = '';
        // get general wizard setting
        $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
        $page_meta_value = get_post_meta( $current_page_id, 'enable_page_count' );
        $page_meta_value_per_day = get_post_meta( $current_page_id, 'enable_page_count_day_wise' );
        if ( $current_page_id ) {
            
            if ( "enable" === $general_wizard_setting['pvcp_general_front_view_counter'] && (empty($page_meta_value) || in_array( 'yes', $page_meta_value )) && (empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] )) ) {
                // get background color
                
                if ( !empty($general_wizard_setting['pvcp_general_bc_color']) ) {
                    $backgroundColor = trim( $general_wizard_setting['pvcp_general_bc_color'] );
                } else {
                    $backgroundColor = '#FFFFFF';
                }
                
                // get font color
                
                if ( !empty($general_wizard_setting['pvcp_general_font_color']) ) {
                    $fontColor = trim( $general_wizard_setting['pvcp_general_font_color'] );
                } else {
                    $fontColor = '#000000';
                }
                
                $currentDate = date( "Y/m/d" );
                // current date
                $pageCountToday = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE page_id = %d AND date = %s", $current_page_id, $currentDate ) );
                //db call ok; no-cache ok
                $pageCountAll = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE page_id = %d", $current_page_id ) );
                //db call ok; no-cache ok
                
                if ( empty($page_meta_value_per_day) || in_array( 'yes', $page_meta_value_per_day ) ) {
                    $page_per_day_count = ' - ' . __( 'Today Page Visits', PVCP_TEXT_DOMAIN ) . ': ' . $pageCountToday;
                } else {
                    $page_per_day_count = '';
                }
                
                $totalWebsiteVisitsHtml .= '<div class="page_counter_label"><span class="page_counter_text" style="color:' . esc_attr( $fontColor ) . ';background:' . esc_attr( $backgroundColor ) . ';">' . __( 'Total Page Visits', 'page-visit-counter' ) . ': ' . $pageCountAll . $page_per_day_count . '</span></div>';
            }
        
        }
        return $content . ' ' . $totalWebsiteVisitsHtml;
    }
    
    /**
     * Display default page visit counter for shop page without shortcode for all page/post
     *
     * @since    1.0.0
     *
     * @param $content
     */
    public function default_page_visit_counter_for_shop( $content )
    {
        global  $wpdb ;
        $current_page_id = wc_get_page_id( 'shop' );
        $type = get_post_type( $current_page_id );
        $totalWebsiteVisitsHtml = '';
        // get general wizard setting
        $general_wizard_setting = maybe_unserialize( get_option( 'pvcp_general_settings' ) );
        $page_meta_value = get_post_meta( $current_page_id, 'enable_page_count' );
        $page_meta_value_per_day = get_post_meta( $current_page_id, 'enable_page_count_day_wise' );
        
        if ( "enable" === $general_wizard_setting['pvcp_general_front_view_counter'] && (empty($page_meta_value) || in_array( 'yes', $page_meta_value )) && (empty($general_wizard_setting['pvcp_general_post_type']) || in_array( $type, $general_wizard_setting['pvcp_general_post_type'] )) ) {
            // get background color
            
            if ( !empty($general_wizard_setting['pvcp_general_bc_color']) ) {
                $backgroundColor = trim( $general_wizard_setting['pvcp_general_bc_color'] );
            } else {
                $backgroundColor = '#000000';
            }
            
            // get font color
            
            if ( !empty($general_wizard_setting['pvcp_general_font_color']) ) {
                $fontColor = trim( $general_wizard_setting['pvcp_general_font_color'] );
            } else {
                $fontColor = '#FFFFFF';
            }
            
            $currentDate = date( "Y/m/d" );
            // current date
            $pageCountToday = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE page_id = %d AND date = %s", $current_page_id, $currentDate ) );
            //db call ok; no-cache ok
            $pageCountAll = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM {$wpdb->prefix}page_visit_history WHERE page_id = %d", $current_page_id ) );
            //db call ok; no-cache ok
            
            if ( empty($page_meta_value_per_day) || in_array( 'yes', $page_meta_value_per_day ) ) {
                $page_per_day_count = ' - ' . __( 'Today Page Visits', PVCP_TEXT_DOMAIN ) . ': ' . $pageCountToday;
            } else {
                $page_per_day_count = '';
            }
            
            $totalWebsiteVisitsHtml .= '<div class="page_counter_label"><span class="page_counter_text" style="color:' . esc_attr( $fontColor ) . ';background:' . esc_attr( $backgroundColor ) . ';">' . __( 'Total Page Visits', 'page-visit-counter' ) . ': ' . $pageCountAll . $page_per_day_count . '</span></div>';
        }
        
        echo  $content . ' ' . $totalWebsiteVisitsHtml ;
    }

}