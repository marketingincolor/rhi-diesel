<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>

    <!-- HOME SCREEN ICONS -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/apple-icon-144x144.png" />

<script src="<?php echo get_template_directory_uri(); ?>/js/navFX.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jq_easing_current.js" type="text/javascript"></script>









    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <script type="text/javascript">
        (function($) {

            /*
             *  render_map
             *
             *  This function will render a Google Map onto the selected jQuery element
             *
             *  @type	function
             *  @date	8/11/2013
             *  @since	4.3.0
             *
             *  @param	$el (jQuery element)
             *  @return	n/a
             */

            function render_map( $el ) {

                // var
                var $markers = $el.find('.marker');

                // vars
                var args = {
                    zoom		: 16,
                    center		: new google.maps.LatLng(0, 0),
                    mapTypeId	: google.maps.MapTypeId.ROADMAP
                };

                // create map
                var map = new google.maps.Map( $el[0], args);

                // add a markers reference
                map.markers = [];

                // add markers
                $markers.each(function(){

                    add_marker( $(this), map );

                });

                // center map
                center_map( map );

            }

            /*
             *  add_marker
             *
             *  This function will add a marker to the selected Google Map
             *
             *  @type	function
             *  @date	8/11/2013
             *  @since	4.3.0
             *
             *  @param	$marker (jQuery element)
             *  @param	map (Google Map object)
             *  @return	n/a
             */

            function add_marker( $marker, map ) {

                // var
                var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

                // create marker
                var marker = new google.maps.Marker({
                    position	: latlng,
                    map			: map
                });

                // add to array
                map.markers.push( marker );

                // if marker contains HTML, add it to an infoWindow
                if( $marker.html() )
                {
                    // create info window
                    var infowindow = new google.maps.InfoWindow({
                        content		: $marker.html()
                    });

                    // show info window when marker is clicked
                    google.maps.event.addListener(marker, 'click', function() {

                        infowindow.open( map, marker );

                    });
                }

            }

            /*
             *  center_map
             *
             *  This function will center the map, showing all markers attached to this map
             *
             *  @type	function
             *  @date	8/11/2013
             *  @since	4.3.0
             *
             *  @param	map (Google Map object)
             *  @return	n/a
             */

            function center_map( map ) {

                // vars
                var bounds = new google.maps.LatLngBounds();

                // loop through all markers and create bounds
                $.each( map.markers, function( i, marker ){

                    var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

                    bounds.extend( latlng );

                });

                // only 1 marker?
                if( map.markers.length == 1 )
                {
                    // set center of map
                    map.setCenter( bounds.getCenter() );
                    map.setZoom( 16 );
                }
                else
                {
                    // fit to bounds
                    map.fitBounds( bounds );
                }

            }

            /*
             *  document ready
             *
             *  This function will render each map when the document is ready (page has loaded)
             *
             *  @type	function
             *  @date	8/11/2013
             *  @since	5.0.0
             *
             *  @param	n/a
             *  @return	n/a
             */

            $(document).ready(function(){

                $('.acf-map').each(function(){

                    render_map( $(this) );

                });

            });

        })(jQuery);

    </script>

    <!-- google analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-3417983-4', 'auto');
        ga('send', 'pageview');

    </script>

</head>

<body <?php body_class(); ?>>

<?php wp_nav_menu( array('menu' => 'Mobile Menu' )); ?>

<div class="siteWrap">
    <header class="header" id="header">
        <nav>
            <ul class="mainNav">
                <li><?php wp_nav_menu( array('menu' => 'Main Menu Left' )); ?></li>

                <!--
                <li><a href="">Hours &amp; Locations</a></li>
                <li><a href="">Services</a></li>
                <li><a href="">Schedules</a></li>
            -->
                <li class="persistent"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logoLink"><div class="logoShadow"></div> <img src="<?php the_field('diesel_logo', 'option'); ?>" /> </a> </li>
                <li><?php wp_nav_menu( array('menu' => 'Main Menu Right' )); ?></li>
                <!--
                <li><a href="">Diesel's Story</a></li>
                <li><a href="">Photos</a></li>
                <li><a href="">Shop</a></li>
                -->
                <li class="burger"><a href="javascript:;" class="burgerLink"><span class="fa fa-bars fa-2x"></span></a></li>
                <!--<li class="iconCont persistent"><a href="<?php the_field('shopping_cart_link', 'option'); ?>" class="navIcon"><span class="fa fa-shopping-cart fa-flip-horizontal"></span></a></li>-->
                <!--<li class="iconCont"><a href="<?php the_field('facebook_link', 'option'); ?>" class="navIcon" target="_blank"><span class="fa fa-facebook"></span></a></li>
                <li class="iconCont"><a href="<?php the_field('instagram_link', 'option'); ?>" class="navIcon" target="_blank"><span class="fa fa-instagram"></span></a></li>-->
            </ul>
        </nav>

    </header>
