<?php

/**
 * @package WordPress
 * @subpackage Reales
 */
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="facebook-domain-verification" content="rl10us1gn9mnd4pmpenuf312vv2rh3" />
    <meta name="google-site-verification" content="CYPUlfRlcpTCZlGEPkrS1FdGV7UU1RdoBX9cuIR-Dk8" />
    <link rel="pingback" href="https://nextsqft.com/xmlrpc.php">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "WebSite",
            "name": "nextsqft.com",
            "url": "https://nextsqft.com/",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "https://nextsqft.com/search-results/{search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
    <script>
        window.addEventListener("load", function() {
            setTimeout(() => {
                let gtmScript = document.createElement("script");
                gtmScript.src = "https://www.googletagmanager.com/gtag/js?id=GTM-MHDF2V4";
                gtmScript.async = true;
                document.body.appendChild(gtmScript);
            }, 3000); // Load after 3 seconds to avoid render-blocking
        });
    </script>



    <!-- Google tag (gtag.js) -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-604396905"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'AW-604396905');
    </script>





    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0&appId=359149214426018&autoLogAppEvents=1" nonce="ElvPFgZY"></script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MHDF2V4');
    </script>
    <!-- End Google Tag Manager -->
    <meta charset="<?php bloginfo('charset'); ?>">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MHDF2V4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <![endif]-->
    <?php
    $reales_general_settings = get_option('reales_general_settings');
    $favicon = isset($reales_general_settings['reales_favicon_field']) ? $reales_general_settings['reales_favicon_field'] : '';
    if ($favicon != '') {
        echo '<link rel="shortcut icon" href="' . esc_url($favicon) . '" type="image/x-icon" />';
    } else {
        echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/images/favicon.png" type="image/x-icon" />';
    }
    ?>
    <?php get_template_part('templates/social_meta'); ?>
    <?php wp_head(); ?>
    <meta name="google-site-verification" content="e5_VX3wd_opIQGNn04MN9lcOtnWO5RZkoMPfd2rbvIw" />
    <!-- Event snippet for Contact Seller conversion page -->
    <script>
        function gtag_report_conversion(url) {
            console.log("Called - ", url);
            var callback = function () {
                if (typeof (url) != 'undefined') {
                    window.location = url;
                }
            };
            gtag('event', 'conversion', {
                'send_to': 'AW-604396905/Ac0kCJ7CqoMYEOm6maAC',
                'event_callback': callback
            });
            return false;
        }
    </script>
		<!-- Preconnect for faster DNS resolution -->
    <link rel="preconnect" href="https://www.googletagmanager.com">
		<link rel="preconnect" href="https://www.google-analytics.com">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="<?php echo get_home_url(); ?>">

    <?php wp_head(); ?> <!-- Keep this to ensure plugins work properly -->
</head>
	
	
<script type="text/javascript">var $zoho = $zoho || {};
    $zoho.salesiq = $zoho.salesiq || {widgetcode: "86904c2774facbd940b003cfe0d67b7d21876af6fd70432b699215b345b36a56", values: {}, ready: function () {}};
    var d = document;
    s = d.createElement("script");
    s.type = "text/javascript";
    s.id = "zsiqscript";
    s.defer = true;
    s.src = "https://salesiq.zoho.in/widget";
    t = d.getElementsByTagName("script")[0];
    t.parentNode.insertBefore(s, t);
    d.write("<div id='zsiqwidget'></div>");</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-169214247-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-169214247-1');
    gtag('config', 'AW-604396905');
</script>

	
	
	
<?php
$body_classes = 'no-transition';
$reales_appearance_settings = get_option('reales_appearance_settings', '');
$home_header = isset($reales_appearance_settings['reales_home_header_field']) ? $reales_appearance_settings['reales_home_header_field'] : '';
$home_caption = isset($reales_appearance_settings['reales_home_caption_field']) ? $reales_appearance_settings['reales_home_caption_field'] : '';
$home_spotlight = isset($reales_appearance_settings['reales_home_spotlight_field']) ? $reales_appearance_settings['reales_home_spotlight_field'] : '';
$nomap = isset($reales_appearance_settings['reales_nomap_field']) ? $reales_appearance_settings['reales_nomap_field'] : '';
?>

<body <?php body_class($body_classes); ?>>

    <?php
    if (is_front_page()) {
        get_template_part('templates/front_hero');
    } else if (is_home() || is_archive() || is_search()) {
        get_template_part('templates/blog_carousel');
    } else if (is_single() && !is_singular('property') && !is_singular('agent')) {
        get_template_part('templates/post_hero');
    } else if (
        !(is_page_template('property-search-results.php') || is_page_template('property-search-results-seo.php')) &&
        !is_singular('ds-idx-listings-page') &&
        !is_page_template('idx-listings.php') &&
        !(defined("IS_OPTIMA") && IS_OPTIMA) &&
        !is_page_template('submit-property.php') &&
        !is_page_template('my-properties.php') &&
        !is_page_template('favourite-properties.php') &&
        !is_singular('property') &&
        !is_singular('agent') ||
        (is_page_template('property-search-results.php') && $nomap == '1') ||
        (is_singular('property') && $nomap == '1') ||
        (is_singular('agent') && $nomap == '1')
    ) {
        get_template_part('templates/page_hero');
    }

    if (((is_page_template('property-search-results.php') || is_page_template('property-search-results-seo.php')) && $nomap != '1') ||
        is_singular('ds-idx-listings-page') ||
        is_page_template('idx-listings.php') ||
        (defined("IS_OPTIMA") && IS_OPTIMA) ||
        (is_singular('property') && $nomap != '1') ||
        (is_singular('agent') && $nomap != '1') ||
        is_page_template('submit-property.php') ||
        is_page_template('my-properties.php') ||
        is_page_template('favourite-properties.php')
    ) {
        get_template_part('templates/app_header');
    } else {
        get_template_part('templates/home_header');
    }

    if (is_front_page() && ($home_header == 'slideshow' || $home_header == 'video') && $home_caption) {
        get_template_part('templates/home_caption');
    }

    if (
        !is_front_page() &&
        !is_home() &&
        !is_archive() &&
        !is_search() &&
        !is_single() &&
        !is_404() &&
        !(is_page_template('property-search-results.php') || is_page_template('property-search-results-seo.php')) &&
        !is_singular('ds-idx-listings-page') &&
        !is_page_template('idx-listings.php') &&
        !(defined("IS_OPTIMA") && IS_OPTIMA) &&
        !is_page_template('submit-property.php') &&
        !is_page_template('my-properties.php') &&
        !is_page_template('favourite-properties.php') ||
        (is_page_template('property-search-results.php') && $nomap == '1') ||
        (is_singular('agent') && $nomap == '1')
    ) {
        get_template_part('templates/page_caption');
    }

    if (is_front_page()) {
        get_template_part('templates/search_properties');
    }

    if (is_404()) {
        get_template_part('templates/page_error_caption');
    }
    ?>

</div>

<?php
if (is_front_page() && $home_spotlight) {
    get_template_part('templates/home_spotlight');
}
?>