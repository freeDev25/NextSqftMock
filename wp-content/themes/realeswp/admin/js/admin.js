(function($) {
    "use strict";

    var simpleIcons = "icon-user,icon-user-female,icon-users,icon-user-follow,icon-user-following,icon-user-unfollow,icon-trophy,icon-speedometer,icon-social-youtube,icon-social-twitter,icon-social-tumblr,icon-social-facebook,icon-social-dropbox,icon-social-dribbble,icon-shield,icon-screen-tablet,icon-screen-smartphone,icon-screen-desktop,icon-plane,icon-notebook,icon-moustache,icon-mouse,icon-magnet,icon-magic-wand,icon-hourglass,icon-graduation,icon-ghost,icon-game-controller,icon-fire,icon-eyeglasses,icon-envelope-open,icon-envelope-letter,icon-energy,icon-emoticon-smile,icon-disc,icon-cursor-move,icon-crop,icon-credit-card,icon-chemistry,icon-bell,icon-badge,icon-anchor,icon-action-redo,icon-action-undo,icon-bag,icon-basket,icon-basket-loaded,icon-book-open,icon-briefcase,icon-bubbles,icon-calculator,icon-call-end,icon-call-in,icon-call-out,icon-compass,icon-cup,icon-diamond,icon-direction,icon-directions,icon-docs,icon-drawer,icon-drop,icon-earphones,icon-earphones-alt,icon-feed,icon-film,icon-folder-alt,icon-frame,icon-globe,icon-globe-alt,icon-handbag,icon-layers,icon-map,icon-picture,icon-pin,icon-playlist,icon-present,icon-printer,icon-puzzle,icon-speech,icon-vector,icon-wallet,icon-arrow-down,icon-arrow-left,icon-arrow-right,icon-arrow-up,icon-bar-chart,icon-bulb,icon-calendar,icon-control-end,icon-control-forward,icon-control-pause,icon-control-play,icon-control-rewind,icon-control-start,icon-cursor,icon-dislike,icon-equalizer,icon-graph,icon-grid,icon-home,icon-like,icon-list,icon-login,icon-logout,icon-loop,icon-microphone,icon-music-tone,icon-music-tone-alt,icon-note,icon-pencil,icon-pie-chart,icon-question,icon-rocket,icon-share,icon-share-alt,icon-shuffle,icon-size-actual,icon-size-fullscreen,icon-support,icon-tag,icon-trash,icon-umbrella,icon-wrench,icon-ban,icon-bubble,icon-camcorder,icon-camera,icon-check,icon-clock,icon-close,icon-cloud-download,icon-cloud-upload,icon-doc,icon-envelope,icon-eye,icon-flag,icon-folder,icon-heart,icon-info,icon-key,icon-link,icon-lock,icon-lock-open,icon-magnifier,icon-magnifier-add,icon-magnifier-remove,icon-paper-clip,icon-paper-plane,icon-plus,icon-pointer,icon-power,icon-refresh,icon-reload,icon-settings,icon-star,icon-symbol-female,icon-symbol-male,icon-target,icon-volume-1,icon-volume-2,icon-volume-off";
    var faIcons = "fa-500px, fa-address-book, fa-address-book-o, fa-address-card, fa-address-card-o, fa-adjust, fa-adn, fa-align-center, fa-align-justify, fa-align-left, fa-align-right, fa-amazon, fa-ambulance, fa-american-sign-language-interpreting, fa-anchor, fa-android, fa-angellist, fa-angle-double-down, fa-angle-double-left, fa-angle-double-right, fa-angle-double-up, fa-angle-down, fa-angle-left, fa-angle-right, fa-angle-up, fa-apple, fa-archive, fa-area-chart, fa-arrow-circle-down, fa-arrow-circle-left, fa-arrow-circle-o-down, fa-arrow-circle-o-left, fa-arrow-circle-o-right, fa-arrow-circle-o-up, fa-arrow-circle-right, fa-arrow-circle-up, fa-arrow-down, fa-arrow-left, fa-arrow-right, fa-arrow-up, fa-arrows, fa-arrows-alt, fa-arrows-h, fa-arrows-v, fa-asl-interpreting, fa-assistive-listening-systems, fa-asterisk, fa-at, fa-audio-description, fa-automobile, fa-backward, fa-balance-scale, fa-ban, fa-bandcamp, fa-bank, fa-bar-chart, fa-bar-chart-o, fa-barcode, fa-bars, fa-bath, fa-bathtub, fa-battery, fa-battery-0, fa-battery-1, fa-battery-2, fa-battery-3, fa-battery-4, fa-battery-empty, fa-battery-full, fa-battery-half, fa-battery-quarter, fa-battery-three-quarters, fa-bed, fa-beer, fa-behance, fa-behance-square, fa-bell, fa-bell-o, fa-bell-slash, fa-bell-slash-o, fa-bicycle, fa-binoculars, fa-birthday-cake, fa-bitbucket, fa-bitbucket-square, fa-bitcoin, fa-black-tie, fa-blind, fa-bluetooth, fa-bluetooth-b, fa-bold, fa-bolt, fa-bomb, fa-book, fa-bookmark, fa-bookmark-o, fa-braille, fa-briefcase, fa-btc, fa-bug, fa-building, fa-building-o, fa-bullhorn, fa-bullseye, fa-bus, fa-buysellads, fa-cab, fa-calculator, fa-calendar, fa-calendar-check-o, fa-calendar-minus-o, fa-calendar-o, fa-calendar-plus-o, fa-calendar-times-o, fa-camera, fa-camera-retro, fa-car, fa-caret-down, fa-caret-left, fa-caret-right, fa-caret-square-o-down, fa-caret-square-o-left, fa-caret-square-o-right, fa-caret-square-o-up, fa-caret-up, fa-cart-arrow-down, fa-cart-plus, fa-cc, fa-cc-amex, fa-cc-diners-club, fa-cc-discover, fa-cc-jcb, fa-cc-mastercard, fa-cc-paypal, fa-cc-stripe, fa-cc-visa, fa-certificate, fa-chain, fa-chain-broken, fa-check, fa-check-circle, fa-check-circle-o, fa-check-square, fa-check-square-o, fa-chevron-circle-down, fa-chevron-circle-left, fa-chevron-circle-right, fa-chevron-circle-up, fa-chevron-down, fa-chevron-left, fa-chevron-right, fa-chevron-up, fa-child, fa-chrome, fa-circle, fa-circle-o, fa-circle-o-notch, fa-circle-thin, fa-clipboard, fa-clock-o, fa-clone, fa-close, fa-cloud, fa-cloud-download, fa-cloud-upload, fa-cny, fa-code, fa-code-fork, fa-codepen, fa-codiepie, fa-coffee, fa-cog, fa-cogs, fa-columns, fa-comment, fa-comment-o, fa-commenting, fa-commenting-o, fa-comments, fa-comments-o, fa-compass, fa-compress, fa-connectdevelop, fa-contao, fa-copy, fa-copyright, fa-creative-commons, fa-credit-card, fa-credit-card-alt, fa-crop, fa-crosshairs, fa-css3, fa-cube, fa-cubes, fa-cut, fa-cutlery, fa-dashboard, fa-dashcube, fa-database, fa-deaf, fa-deafness, fa-dedent, fa-delicious, fa-desktop, fa-deviantart, fa-diamond, fa-digg, fa-dollar, fa-dot-circle-o, fa-download, fa-dribbble, fa-drivers-license, fa-drivers-license-o, fa-dropbox, fa-drupal, fa-edge, fa-edit, fa-eercast, fa-eject, fa-ellipsis-h, fa-ellipsis-v, fa-empire, fa-envelope, fa-envelope-o, fa-envelope-open, fa-envelope-open-o, fa-envelope-square, fa-envira, fa-eraser, fa-etsy, fa-eur, fa-euro, fa-exchange, fa-exclamation, fa-exclamation-circle, fa-exclamation-triangle, fa-expand, fa-expeditedssl, fa-external-link, fa-external-link-square, fa-eye, fa-eye-slash, fa-eyedropper, fa-fa, fa-facebook, fa-facebook-f, fa-facebook-official, fa-facebook-square, fa-fast-backward, fa-fast-forward, fa-fax, fa-feed, fa-female, fa-fighter-jet, fa-file, fa-file-archive-o, fa-file-audio-o, fa-file-code-o, fa-file-excel-o, fa-file-image-o, fa-file-movie-o, fa-file-o, fa-file-pdf-o, fa-file-photo-o, fa-file-picture-o, fa-file-powerpoint-o, fa-file-sound-o, fa-file-text, fa-file-text-o, fa-file-video-o, fa-file-word-o, fa-file-zip-o, fa-files-o, fa-film, fa-filter, fa-fire, fa-fire-extinguisher, fa-firefox, fa-first-order, fa-flag, fa-flag-checkered, fa-flag-o, fa-flash, fa-flask, fa-flickr, fa-floppy-o, fa-folder, fa-folder-o, fa-folder-open, fa-folder-open-o, fa-font, fa-font-awesome, fa-fonticons, fa-fort-awesome, fa-forumbee, fa-forward, fa-foursquare, fa-free-code-camp, fa-frown-o, fa-futbol-o, fa-gamepad, fa-gavel, fa-gbp, fa-ge, fa-gear, fa-gears, fa-genderless, fa-get-pocket, fa-gg, fa-gg-circle, fa-gift, fa-git, fa-git-square, fa-github, fa-github-alt, fa-github-square, fa-gitlab, fa-gittip, fa-glass, fa-glide, fa-glide-g, fa-globe, fa-google, fa-google-plus, fa-google-plus-circle, fa-google-plus-official, fa-google-plus-square, fa-google-wallet, fa-graduation-cap, fa-gratipay, fa-grav, fa-group, fa-h-square, fa-hacker-news, fa-hand-grab-o, fa-hand-lizard-o, fa-hand-o-down, fa-hand-o-left, fa-hand-o-right, fa-hand-o-up, fa-hand-paper-o, fa-hand-peace-o, fa-hand-pointer-o, fa-hand-rock-o, fa-hand-scissors-o, fa-hand-spock-o, fa-hand-stop-o, fa-handshake-o, fa-hard-of-hearing, fa-hashtag, fa-hdd-o, fa-header, fa-headphones, fa-heart, fa-heart-o, fa-heartbeat, fa-history, fa-home, fa-hospital-o, fa-hotel, fa-hourglass, fa-hourglass-1, fa-hourglass-2, fa-hourglass-3, fa-hourglass-end, fa-hourglass-half, fa-hourglass-o, fa-hourglass-start, fa-houzz, fa-html5, fa-i-cursor, fa-id-badge, fa-id-card, fa-id-card-o, fa-ils, fa-image, fa-imdb, fa-inbox, fa-indent, fa-industry, fa-info, fa-info-circle, fa-inr, fa-instagram, fa-institution, fa-internet-explorer, fa-intersex, fa-ioxhost, fa-italic, fa-joomla, fa-jpy, fa-jsfiddle, fa-key, fa-keyboard-o, fa-krw, fa-language, fa-laptop, fa-lastfm, fa-lastfm-square, fa-leaf, fa-leanpub, fa-legal, fa-lemon-o, fa-level-down, fa-level-up, fa-life-bouy, fa-life-buoy, fa-life-ring, fa-life-saver, fa-lightbulb-o, fa-line-chart, fa-link, fa-linkedin, fa-linkedin-square, fa-linode, fa-linux, fa-list, fa-list-alt, fa-list-ol, fa-list-ul, fa-location-arrow, fa-lock, fa-long-arrow-down, fa-long-arrow-left, fa-long-arrow-right, fa-long-arrow-up, fa-low-vision, fa-magic, fa-magnet, fa-mail-forward, fa-mail-reply, fa-mail-reply-all, fa-male, fa-map, fa-map-marker, fa-map-o, fa-map-pin, fa-map-signs, fa-mars, fa-mars-double, fa-mars-stroke, fa-mars-stroke-h, fa-mars-stroke-v, fa-maxcdn, fa-meanpath, fa-medium, fa-medkit, fa-meetup, fa-meh-o, fa-mercury, fa-microchip, fa-microphone, fa-microphone-slash, fa-minus, fa-minus-circle, fa-minus-square, fa-minus-square-o, fa-mixcloud, fa-mobile, fa-mobile-phone, fa-modx, fa-money, fa-moon-o, fa-mortar-board, fa-motorcycle, fa-mouse-pointer, fa-music, fa-navicon, fa-neuter, fa-newspaper-o, fa-object-group, fa-object-ungroup, fa-odnoklassniki, fa-odnoklassniki-square, fa-opencart, fa-openid, fa-opera, fa-optin-monster, fa-outdent, fa-pagelines, fa-paint-brush, fa-paper-plane, fa-paper-plane-o, fa-paperclip, fa-paragraph, fa-paste, fa-pause, fa-pause-circle, fa-pause-circle-o, fa-paw, fa-paypal, fa-pencil, fa-pencil-square, fa-pencil-square-o, fa-percent, fa-phone, fa-phone-square, fa-photo, fa-picture-o, fa-pie-chart, fa-pied-piper, fa-pied-piper-alt, fa-pied-piper-pp, fa-pinterest, fa-pinterest-p, fa-pinterest-square, fa-plane, fa-play, fa-play-circle, fa-play-circle-o, fa-plug, fa-plus, fa-plus-circle, fa-plus-square, fa-plus-square-o, fa-podcast, fa-power-off, fa-print, fa-product-hunt, fa-puzzle-piece, fa-qq, fa-qrcode, fa-question, fa-question-circle, fa-question-circle-o, fa-quora, fa-quote-left, fa-quote-right, fa-ra, fa-random, fa-ravelry, fa-rebel, fa-recycle, fa-reddit, fa-reddit-alien, fa-reddit-square, fa-refresh, fa-registered, fa-remove, fa-renren, fa-reorder, fa-repeat, fa-reply, fa-reply-all, fa-resistance, fa-retweet, fa-rmb, fa-road, fa-rocket, fa-rotate-left, fa-rotate-right, fa-rouble, fa-rss, fa-rss-square, fa-rub, fa-ruble, fa-rupee, fa-s15, fa-safari, fa-save, fa-scissors, fa-scribd, fa-search, fa-search-minus, fa-search-plus, fa-sellsy, fa-send, fa-send-o, fa-server, fa-share, fa-share-alt, fa-share-alt-square, fa-share-square, fa-share-square-o, fa-shekel, fa-sheqel, fa-shield, fa-ship, fa-shirtsinbulk, fa-shopping-bag, fa-shopping-basket, fa-shopping-cart, fa-shower, fa-sign-in, fa-sign-language, fa-sign-out, fa-signal, fa-signing, fa-simplybuilt, fa-sitemap, fa-skyatlas, fa-skype, fa-slack, fa-sliders, fa-slideshare, fa-smile-o, fa-snapchat, fa-snapchat-ghost, fa-snapchat-square, fa-snowflake-o, fa-soccer-ball-o, fa-sort, fa-sort-alpha-asc, fa-sort-alpha-desc, fa-sort-amount-asc, fa-sort-amount-desc, fa-sort-asc, fa-sort-desc, fa-sort-down, fa-sort-numeric-asc, fa-sort-numeric-desc, fa-sort-up, fa-soundcloud, fa-space-shuttle, fa-spinner, fa-spoon, fa-spotify, fa-square, fa-square-o, fa-stack-exchange, fa-stack-overflow, fa-star, fa-star-half, fa-star-half-empty, fa-star-half-full, fa-star-half-o, fa-star-o, fa-steam, fa-steam-square, fa-step-backward, fa-step-forward, fa-stethoscope, fa-sticky-note, fa-sticky-note-o, fa-stop, fa-stop-circle, fa-stop-circle-o, fa-street-view, fa-strikethrough, fa-stumbleupon, fa-stumbleupon-circle, fa-subscript, fa-subway, fa-suitcase, fa-sun-o, fa-superpowers, fa-superscript, fa-support, fa-table, fa-tablet, fa-tachometer, fa-tag, fa-tags, fa-tasks, fa-taxi, fa-telegram, fa-television, fa-tencent-weibo, fa-terminal, fa-text-height, fa-text-width, fa-th, fa-th-large, fa-th-list, fa-themeisle, fa-thermometer, fa-thermometer-0, fa-thermometer-1, fa-thermometer-2, fa-thermometer-3, fa-thermometer-4, fa-thermometer-empty, fa-thermometer-full, fa-thermometer-half, fa-thermometer-quarter, fa-thermometer-three-quarters, fa-thumb-tack, fa-thumbs-down, fa-thumbs-o-down, fa-thumbs-o-up, fa-thumbs-up, fa-ticket, fa-times, fa-times-circle, fa-times-circle-o, fa-times-rectangle, fa-times-rectangle-o, fa-tint, fa-toggle-down, fa-toggle-left, fa-toggle-off, fa-toggle-on, fa-toggle-right, fa-toggle-up, fa-trademark, fa-train, fa-transgender, fa-transgender-alt, fa-trash, fa-trash-o, fa-tree, fa-trello, fa-tripadvisor, fa-trophy, fa-truck, fa-try, fa-tty, fa-tumblr, fa-tumblr-square, fa-turkish-lira, fa-tv, fa-twitch, fa-twitter, fa-twitter-square, fa-umbrella, fa-underline, fa-undo, fa-universal-access, fa-university, fa-unlink, fa-unlock, fa-unlock-alt, fa-unsorted, fa-upload, fa-usb, fa-usd, fa-user, fa-user-circle, fa-user-circle-o, fa-user-md, fa-user-o, fa-user-plus, fa-user-secret, fa-user-times, fa-users, fa-vcard, fa-vcard-o, fa-venus, fa-venus-double, fa-venus-mars, fa-viacoin, fa-viadeo, fa-viadeo-square, fa-video-camera, fa-vimeo, fa-vimeo-square, fa-vine, fa-vk, fa-volume-control-phone, fa-volume-down, fa-volume-off, fa-volume-up, fa-warning, fa-wechat, fa-weibo, fa-weixin, fa-whatsapp, fa-wheelchair, fa-wheelchair-alt, fa-wifi, fa-wikipedia-w, fa-window-close, fa-window-close-o, fa-window-maximize, fa-window-minimize, fa-window-restore, fa-windows, fa-won, fa-wordpress, fa-wpbeginner, fa-wpexplorer, fa-wpforms, fa-wrench, fa-xing, fa-xing-square, fa-y-combinator, fa-y-combinator-square, fa-yahoo, fa-yc, fa-yc-square, fa-yelp, fa-yen, fa-yoast, fa-youtube, fa-youtube-play, fa-youtube-square";
    var simpleIconsArray = simpleIcons.split(',');
    var faIconsArray = faIcons.split(',');
    var amenities_icons = [];
    for (var i = 0; i < simpleIconsArray.length; i++) {
        amenities_icons.push(simpleIconsArray[i]);
    }
    for (var i = 0; i < faIconsArray.length; i++) {
        amenities_icons.push('fa ' + faIconsArray[i]);
    }

    // Upload logo
    $('#logoImageBtn').click(function(event) {
        event.preventDefault();

        var frame = wp.media({
            title: 'Logo Image',
            button: {
                text: 'Insert Image'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').toJSON();
            $.each(attachment, function(index, value) {
                $('#logoImage').val(value.url);
            });
        });

        frame.open();
    });

    // Upload app logo
    $('#appLogoImageBtn').click(function(event) {
        event.preventDefault();

        var frame = wp.media({
            title: 'Logo Image',
            button: {
                text: 'Insert Image'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').toJSON();
            $.each(attachment, function(index, value) {
                $('#appLogoImage').val(value.url);
            });
        });

        frame.open();
    });

    // Upload favicon
    $('#faviconImageBtn').click(function(event) {
        event.preventDefault();

        var frame = wp.media({
            title: 'Logo Image',
            button: {
                text: 'Insert Image'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').toJSON();
            $.each(attachment, function(index, value) {
                $('#faviconImage').val(value.url);
            });
        });

        frame.open();
    });

    // Upload video
    $('#homeVideoBtn').click(function(event) {
        event.preventDefault();

        var frame = wp.media({
            title: 'Logo Image',
            button: {
                text: 'Insert Image'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').toJSON();
            $.each(attachment, function(index, value) {
                $('#homeVideo').val(value.url);
            });
        });

        frame.open();
    });

    // Upload video cover image
    $('#homeVideoCoverBtn').click(function(event) {
        event.preventDefault();

        var frame = wp.media({
            title: 'Video Cover',
            button: {
                text: 'Insert Image'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').toJSON();
            $.each(attachment, function(index, value) {
                $('#homeVideoCover').val(value.url);
            });
        });

        frame.open();
    });

    // Upload page header image
    $('#pageHeaderBtn').click(function() {
        tb_show('', 'media-upload.php?width=800&amp;height=500&amp;type=image&amp;TB_iframe=true');
        $('#TB_ajaxWindowTitle').html('Page Header Image');
        window.send_to_editor = function(html) {
            var imgURL = $('img',html).attr('src');
            $('#page_header').val(imgURL);
            tb_remove();
        }
        return false;
    });

    $(function() {
        $('.color-field').wpColorPicker();
    });

    if($('#customFieldsTable').length > 0) {
        $('.table-field-type').each(function(index, el) {
            if($(this).val() == 'list_field') {
                $(this).next('input').show();
            }
        });
    }

    $("#custom_field_type").change(function() {
        if($(this).val() == 'list_field') {
            $('#custom_list_field_items').show();
            $(this).siblings('.help').show();
        } else {
            $('#custom_list_field_items').val('').hide();
            $(this).siblings('.help').hide();
        }
    });

    $(".table-field-type").each(function(index, el) {
        $(this).change(function() {
            if($(this).val() == 'list_field') {
                $(this).next('input').show();
            } else {
                $(this).next('input').val('').hide();
            }
        });
    });

    $('#add_fields_btn').click(function() {
        var security = $('#securityAddCustomFields').val();
        var _self = $(this);

        _self.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'     : 'reales_add_custom_fields',
                'name'       : $('#custom_field_name').val(),
                'label'      : $('#custom_field_label').val(),
                'type'       : $('#custom_field_type').val(),
                'list'       : $('#custom_list_field_items').val(),
                'mandatory'  : $('#custom_field_mandatory').val(),
                'position'   : $('#custom_field_position').val(),
                'search'     : $('#custom_field_search').val(),
                'comparison' : $('#custom_field_comparison').val(),
                'security'   : security
            },
            success: function(data) {
                if(data.add == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=fields';
                } else {
                    _self.removeAttr('disabled');
                    alert(data.message);
                }
            }
        });
    });

    $(document).on('click', '.delete-field', function() {
        var _self = $(this);
        var field_name = $(this).attr('data-row');
        var security = $('#securityAddCustomFields').val();
        var _self = $(this);

        _self.children('.preloader').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action': 'reales_delete_custom_fields',
                'field_name': field_name,
                'security': security
            },
            success: function(data) {
                if(data.delete == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=fields';
                } else {
                    _self.children('.preloader').hide();
                }
            }
        });
    });

    if($('.datePicker').length > 0) {
        $('.datePicker').datepicker({
            'format' : 'yyyy-mm-dd'
        });
    }

    $('#add_amenity_btn').click(function() {
        var security = $('#securityAddAmenities').val();
        var _self = $(this);

        _self.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'     : 'reales_add_amenities',
                'name'       : $('#amenity_name').val(),
                'label'      : $('#amenity_label').val(),
                'icon'       : $('#amenity_icon').val(),
                'position'   : $('#amenity_position').val(),
                'security'   : security
            },
            success: function(data) {
                if(data.add == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=amenities';
                } else {
                    _self.removeAttr('disabled');   
                    alert(data.message);
                }
            }
        });
    });

    $(document).on('click', '.delete-amenity', function() {
        var _self = $(this);
        var amenity_name = $(this).attr('data-row');
        var security = $('#securityAddAmenities').val();
        var _self = $(this);

        _self.children('.preloader').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action': 'reales_delete_amenities',
                'amenity_name': amenity_name,
                'security': security
            },
            success: function(data) {
                if(data.delete == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=amenities';
                } else {
                    _self.children('.preloader').hide();
                }
            }
        });
    });

    $('.dropdown a').click(function(event) {
        var _parent = $(this).parent();
        if(_parent.hasClass('open')) {
            $(this).parent().removeClass('open');
        } else {
            $(this).parent().addClass('open');
        }
    });
    $('.dropdown-backdrop').click(function(event) {
        var _prev = $(this).prev();
        _prev.removeClass('open');
    });
    for(var i = 0; i < amenities_icons.length; i++) {
        var iconsMenuItem = '<li><a href="#"><span class="' + amenities_icons[i] + '"></span> ' + amenities_icons[i] + '</a></li>';
        $('.iconsMenu').each(function(index, el) {
            $(this).append(iconsMenuItem);
        });
    }
    $('.iconsMenu a').click(function(event) {
        var icon = $(this).text();

        $(this).parent().parent().prev('.button').html('<span class="' + icon + '"></span> ' + icon + '&nbsp;&nbsp;&nbsp;<span class="fa fa-caret-down"></span>');
        $(this).parent().parent().next('input').val(icon);
        $(this).parent().parent().parent().removeClass('open');
    });
    $('.iconsField').each(function(index, el) {
        var fieldValue = $(this).val();
        if(fieldValue != '') {
            $(this).prev().prev('.button').html('<span class="' + fieldValue + '"></span> ' + fieldValue + '&nbsp;&nbsp;&nbsp;<span class="fa fa-caret-down"></span>');
        }
    });

    $('#add_city_btn').click(function() {
        var security = $('#securityAddCities').val();
        var _self = $(this);

        _self.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_add_cities',
                'id'       : $('#city_id').val(),
                'name'     : $('#city_name').val(),
                'position' : $('#city_position').val(),
                'security' : security
            },
            success: function(data) {
                if(data.add == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=cities';
                } else {
                    _self.removeAttr('disabled');
                    alert(data.message);
                }
            }
        });
    });

    $(document).on('click', '.delete-city', function() {
        var _self = $(this);
        var city_id = $(this).attr('data-row');
        var security = $('#securityAddCities').val();

        _self.children('.preloader').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_delete_cities',
                'city_id'  : city_id,
                'security' : security
            },
            success: function(data) {
                if(data.delete == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=cities';
                } else {
                    _self.children('.preloader').hide();
                }
            }
        });
    });

    // Upload slide image
    $('.slide_image_btn').click(function(event) {
        var _self = $(this);
        event.preventDefault();

        var frame = wp.media({
            title: 'Slide Image',
            button: {
                text: 'Insert Image'
            },
            multiple: false
        });

        frame.on( 'select', function() {
            var attachment = frame.state().get('selection').toJSON();
            $.each(attachment, function(index, value) {
                _self.prev().val(value.url);
            });
        });

        frame.open();
    });

    $('#add_slide_btn').click(function() {
        var security = $('#securitySlider').val();
        var _self = $(this);

        _self.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_add_slide',
                'id'       : $('#slide_id').val(),
                'image'    : $('#slide_image').val(),
                'title'    : $('#slide_title').val(),
                'subtitle' : $('#slide_subtitle').val(),
                'cta_text' : $('#slide_cta_text').val(),
                'cta_link' : $('#slide_cta_link').val(),
                'position' : $('#slide_position').val(),
                'security' : security
            },
            success: function(data) {
                if(data.add == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=slider';
                } else {
                    _self.removeAttr('disabled');   
                    alert(data.message);
                }
            }
        });
    });

    $(document).on('click', '.delete-slide', function() {
        var _self = $(this);
        var id = $(this).attr('data-row');
        var security = $('#securitySlider').val();

        _self.children('.preloader').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_delete_slide',
                'id'       : id,
                'security' : security
            },
            success: function(data) {
                if(data.delete == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=slider';
                } else {
                    _self.children('.preloader').hide();
                }
            }
        });
    });

    $('input[name=demo_version]').change(function(event) {
        $('.theme-setup-btn').hide();

        if($(this).is(':checked')) {
            $(this).parent().next('.theme-setup-btn').show();
        } else {
            $(this).parent().next('.theme-setup-btn').hide();
        }
    });

    var setup_msgs;
    var setup_success;
    var demo_version;

    $('.theme-setup-btn > input').click(function() {
        var _this  = $(this);
        var btn    = $(this).parent();

        demo_version = _this.attr('data-demo');
        setup_msgs   = btn.next('ul');
        setup_success = btn.next('ul').next('.theme-setup-done');

        btn.hide();
        setup_msgs.find('.theme-setup-permalinks-msg').show();

        $('input[name=demo_version]').attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_setup_permalinks',
                'security' : $('#securityThemeSetup').val()
            },
            success: function(data) {
                if(data.setup == true) {
                    setup_msgs.find('.theme-setup-permalinks-msg .fa-spinner').hide();
                    setup_msgs.find('.theme-setup-permalinks-msg .fa-check').show();
                    setup_msgs.find('.theme-setup-permalinks-msg .msg-done').show();

                    setupReadingPages();
                }
            }
        });
    });

    function setupReadingPages() {
        setup_msgs.find('.theme-setup-homepage-msg').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_setup_reading_pages',
                'security' : $('#securityThemeSetup').val()
            },
            success: function(data) {
                if(data.setup == true) {
                    setup_msgs.find('.theme-setup-homepage-msg .fa-spinner').hide();
                    setup_msgs.find('.theme-setup-homepage-msg .fa-check').show();
                    setup_msgs.find('.theme-setup-homepage-msg .msg-done').show();

                    setupMenu();
                }
            }
        });
    }

    function setupMenu() {
        setup_msgs.find('.theme-setup-menu-msg').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_setup_menu',
                'security' : $('#securityThemeSetup').val()
            },
            success: function(data) {
                if(data.setup == true) {
                    setup_msgs.find('.theme-setup-menu-msg .fa-spinner').hide();
                    setup_msgs.find('.theme-setup-menu-msg .fa-check').show();
                    setup_msgs.find('.theme-setup-menu-msg .msg-done').show();

                    setupWidgets();
                }
            }
        });
    }

    function setupWidgets() {
        setup_msgs.find('.theme-setup-widgets-msg').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_setup_widgets',
                'demo'     : demo_version,
                'security' : $('#securityThemeSetup').val()
            },
            success: function(data) {
                if(data.setup == true) {
                    setup_msgs.find('.theme-setup-widgets-msg .fa-spinner').hide();
                    setup_msgs.find('.theme-setup-widgets-msg .fa-check').show();
                    setup_msgs.find('.theme-setup-widgets-msg .msg-done').show();

                    setupOptions();
                }
            }
        });
    }

    function setupOptions() {
        setup_msgs.find('.theme-setup-options-msg').show();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'   : 'reales_setup_options',
                'demo'     : demo_version,
                'security' : $('#securityThemeSetup').val()
            },
            success: function(data) {
                if(data.setup == true) {
                    setup_msgs.find('.theme-setup-options-msg .fa-spinner').hide();
                    setup_msgs.find('.theme-setup-options-msg .fa-check').show();
                    setup_msgs.find('.theme-setup-options-msg .msg-done').show();
                    setup_success.show();
                }
            }
        });
    }

    function openIconsWindow(btn) {
        var faIcons = ['fa fa-500px', 'fa fa-address-book', 'fa fa-address-book-o', 'fa fa-address-card', 'fa fa-address-card-o', 'fa fa-adjust', 'fa fa-adn', 'fa fa-align-center', 'fa fa-align-justify', 'fa fa-align-left', 'fa fa-align-right', 'fa fa-amazon', 'fa fa-ambulance', 'fa fa-american-sign-language-interpreting', 'fa fa-anchor', 'fa fa-android', 'fa fa-angellist', 'fa fa-angle-double-down', 'fa fa-angle-double-left', 'fa fa-angle-double-right', 'fa fa-angle-double-up', 'fa fa-angle-down', 'fa fa-angle-left', 'fa fa-angle-right', 'fa fa-angle-up', 'fa fa-apple', 'fa fa-archive', 'fa fa-area-chart', 'fa fa-arrow-circle-down', 'fa fa-arrow-circle-left', 'fa fa-arrow-circle-o-down', 'fa fa-arrow-circle-o-left', 'fa fa-arrow-circle-o-right', 'fa fa-arrow-circle-o-up', 'fa fa-arrow-circle-right', 'fa fa-arrow-circle-up', 'fa fa-arrow-down', 'fa fa-arrow-left', 'fa fa-arrow-right', 'fa fa-arrow-up', 'fa fa-arrows', 'fa fa-arrows-alt', 'fa fa-arrows-h', 'fa fa-arrows-v', 'fa fa-asl-interpreting', 'fa fa-assistive-listening-systems', 'fa fa-asterisk', 'fa fa-at', 'fa fa-audio-description', 'fa fa-automobile', 'fa fa-backward', 'fa fa-balance-scale', 'fa fa-ban', 'fa fa-bandcamp', 'fa fa-bank', 'fa fa-bar-chart', 'fa fa-bar-chart-o', 'fa fa-barcode', 'fa fa-bars', 'fa fa-bath', 'fa fa-bathtub', 'fa fa-battery', 'fa fa-battery-0', 'fa fa-battery-1', 'fa fa-battery-2', 'fa fa-battery-3', 'fa fa-battery-4', 'fa fa-battery-empty', 'fa fa-battery-full', 'fa fa-battery-half', 'fa fa-battery-quarter', 'fa fa-battery-three-quarters', 'fa fa-bed', 'fa fa-beer', 'fa fa-behance', 'fa fa-behance-square', 'fa fa-bell', 'fa fa-bell-o', 'fa fa-bell-slash', 'fa fa-bell-slash-o', 'fa fa-bicycle', 'fa fa-binoculars', 'fa fa-birthday-cake', 'fa fa-bitbucket', 'fa fa-bitbucket-square', 'fa fa-bitcoin', 'fa fa-black-tie', 'fa fa-blind', 'fa fa-bluetooth', 'fa fa-bluetooth-b', 'fa fa-bold', 'fa fa-bolt', 'fa fa-bomb', 'fa fa-book', 'fa fa-bookmark', 'fa fa-bookmark-o', 'fa fa-braille', 'fa fa-briefcase', 'fa fa-btc', 'fa fa-bug', 'fa fa-building', 'fa fa-building-o', 'fa fa-bullhorn', 'fa fa-bullseye', 'fa fa-bus', 'fa fa-buysellads', 'fa fa-cab', 'fa fa-calculator', 'fa fa-calendar', 'fa fa-calendar-check-o', 'fa fa-calendar-minus-o', 'fa fa-calendar-o', 'fa fa-calendar-plus-o', 'fa fa-calendar-times-o', 'fa fa-camera', 'fa fa-camera-retro', 'fa fa-car', 'fa fa-caret-down', 'fa fa-caret-left', 'fa fa-caret-right', 'fa fa-caret-square-o-down', 'fa fa-caret-square-o-left', 'fa fa-caret-square-o-right', 'fa fa-caret-square-o-up', 'fa fa-caret-up', 'fa fa-cart-arrow-down', 'fa fa-cart-plus', 'fa fa-cc', 'fa fa-cc-amex', 'fa fa-cc-diners-club', 'fa fa-cc-discover', 'fa fa-cc-jcb', 'fa fa-cc-mastercard', 'fa fa-cc-paypal', 'fa fa-cc-stripe', 'fa fa-cc-visa', 'fa fa-certificate', 'fa fa-chain', 'fa fa-chain-broken', 'fa fa-check', 'fa fa-check-circle', 'fa fa-check-circle-o', 'fa fa-check-square', 'fa fa-check-square-o', 'fa fa-chevron-circle-down', 'fa fa-chevron-circle-left', 'fa fa-chevron-circle-right', 'fa fa-chevron-circle-up', 'fa fa-chevron-down', 'fa fa-chevron-left', 'fa fa-chevron-right', 'fa fa-chevron-up', 'fa fa-child', 'fa fa-chrome', 'fa fa-circle', 'fa fa-circle-o', 'fa fa-circle-o-notch', 'fa fa-circle-thin', 'fa fa-clipboard', 'fa fa-clock-o', 'fa fa-clone', 'fa fa-close', 'fa fa-cloud', 'fa fa-cloud-download', 'fa fa-cloud-upload', 'fa fa-cny', 'fa fa-code', 'fa fa-code-fork', 'fa fa-codepen', 'fa fa-codiepie', 'fa fa-coffee', 'fa fa-cog', 'fa fa-cogs', 'fa fa-columns', 'fa fa-comment', 'fa fa-comment-o', 'fa fa-commenting', 'fa fa-commenting-o', 'fa fa-comments', 'fa fa-comments-o', 'fa fa-compass', 'fa fa-compress', 'fa fa-connectdevelop', 'fa fa-contao', 'fa fa-copy', 'fa fa-copyright', 'fa fa-creative-commons', 'fa fa-credit-card', 'fa fa-credit-card-alt', 'fa fa-crop', 'fa fa-crosshairs', 'fa fa-css3', 'fa fa-cube', 'fa fa-cubes', 'fa fa-cut', 'fa fa-cutlery', 'fa fa-dashboard', 'fa fa-dashcube', 'fa fa-database', 'fa fa-deaf', 'fa fa-deafness', 'fa fa-dedent', 'fa fa-delicious', 'fa fa-desktop', 'fa fa-deviantart', 'fa fa-diamond', 'fa fa-digg', 'fa fa-dollar', 'fa fa-dot-circle-o', 'fa fa-download', 'fa fa-dribbble', 'fa fa-drivers-license', 'fa fa-drivers-license-o', 'fa fa-dropbox', 'fa fa-drupal', 'fa fa-edge', 'fa fa-edit', 'fa fa-eercast', 'fa fa-eject', 'fa fa-ellipsis-h', 'fa fa-ellipsis-v', 'fa fa-empire', 'fa fa-envelope', 'fa fa-envelope-o', 'fa fa-envelope-open', 'fa fa-envelope-open-o', 'fa fa-envelope-square', 'fa fa-envira', 'fa fa-eraser', 'fa fa-etsy', 'fa fa-eur', 'fa fa-euro', 'fa fa-exchange', 'fa fa-exclamation', 'fa fa-exclamation-circle', 'fa fa-exclamation-triangle', 'fa fa-expand', 'fa fa-expeditedssl', 'fa fa-external-link', 'fa fa-external-link-square', 'fa fa-eye', 'fa fa-eye-slash', 'fa fa-eyedropper', 'fa fa-fa', 'fa fa-facebook', 'fa fa-facebook-f', 'fa fa-facebook-official', 'fa fa-facebook-square', 'fa fa-fast-backward', 'fa fa-fast-forward', 'fa fa-fax', 'fa fa-feed', 'fa fa-female', 'fa fa-fighter-jet', 'fa fa-file', 'fa fa-file-archive-o', 'fa fa-file-audio-o', 'fa fa-file-code-o', 'fa fa-file-excel-o', 'fa fa-file-image-o', 'fa fa-file-movie-o', 'fa fa-file-o', 'fa fa-file-pdf-o', 'fa fa-file-photo-o', 'fa fa-file-picture-o', 'fa fa-file-powerpoint-o', 'fa fa-file-sound-o', 'fa fa-file-text', 'fa fa-file-text-o', 'fa fa-file-video-o', 'fa fa-file-word-o', 'fa fa-file-zip-o', 'fa fa-files-o', 'fa fa-film', 'fa fa-filter', 'fa fa-fire', 'fa fa-fire-extinguisher', 'fa fa-firefox', 'fa fa-first-order', 'fa fa-flag', 'fa fa-flag-checkered', 'fa fa-flag-o', 'fa fa-flash', 'fa fa-flask', 'fa fa-flickr', 'fa fa-floppy-o', 'fa fa-folder', 'fa fa-folder-o', 'fa fa-folder-open', 'fa fa-folder-open-o', 'fa fa-font', 'fa fa-font-awesome', 'fa fa-fonticons', 'fa fa-fort-awesome', 'fa fa-forumbee', 'fa fa-forward', 'fa fa-foursquare', 'fa fa-free-code-camp', 'fa fa-frown-o', 'fa fa-futbol-o', 'fa fa-gamepad', 'fa fa-gavel', 'fa fa-gbp', 'fa fa-ge', 'fa fa-gear', 'fa fa-gears', 'fa fa-genderless', 'fa fa-get-pocket', 'fa fa-gg', 'fa fa-gg-circle', 'fa fa-gift', 'fa fa-git', 'fa fa-git-square', 'fa fa-github', 'fa fa-github-alt', 'fa fa-github-square', 'fa fa-gitlab', 'fa fa-gittip', 'fa fa-glass', 'fa fa-glide', 'fa fa-glide-g', 'fa fa-globe', 'fa fa-google', 'fa fa-google-plus', 'fa fa-google-plus-circle', 'fa fa-google-plus-official', 'fa fa-google-plus-square', 'fa fa-google-wallet', 'fa fa-graduation-cap', 'fa fa-gratipay', 'fa fa-grav', 'fa fa-group', 'fa fa-h-square', 'fa fa-hacker-news', 'fa fa-hand-grab-o', 'fa fa-hand-lizard-o', 'fa fa-hand-o-down', 'fa fa-hand-o-left', 'fa fa-hand-o-right', 'fa fa-hand-o-up', 'fa fa-hand-paper-o', 'fa fa-hand-peace-o', 'fa fa-hand-pointer-o', 'fa fa-hand-rock-o', 'fa fa-hand-scissors-o', 'fa fa-hand-spock-o', 'fa fa-hand-stop-o', 'fa fa-handshake-o', 'fa fa-hard-of-hearing', 'fa fa-hashtag', 'fa fa-hdd-o', 'fa fa-header', 'fa fa-headphones', 'fa fa-heart', 'fa fa-heart-o', 'fa fa-heartbeat', 'fa fa-history', 'fa fa-home', 'fa fa-hospital-o', 'fa fa-hotel', 'fa fa-hourglass', 'fa fa-hourglass-1', 'fa fa-hourglass-2', 'fa fa-hourglass-3', 'fa fa-hourglass-end', 'fa fa-hourglass-half', 'fa fa-hourglass-o', 'fa fa-hourglass-start', 'fa fa-houzz', 'fa fa-html5', 'fa fa-i-cursor', 'fa fa-id-badge', 'fa fa-id-card', 'fa fa-id-card-o', 'fa fa-ils', 'fa fa-image', 'fa fa-imdb', 'fa fa-inbox', 'fa fa-indent', 'fa fa-industry', 'fa fa-info', 'fa fa-info-circle', 'fa fa-inr', 'fa fa-instagram', 'fa fa-institution', 'fa fa-internet-explorer', 'fa fa-intersex', 'fa fa-ioxhost', 'fa fa-italic', 'fa fa-joomla', 'fa fa-jpy', 'fa fa-jsfiddle', 'fa fa-key', 'fa fa-keyboard-o', 'fa fa-krw', 'fa fa-language', 'fa fa-laptop', 'fa fa-lastfm', 'fa fa-lastfm-square', 'fa fa-leaf', 'fa fa-leanpub', 'fa fa-legal', 'fa fa-lemon-o', 'fa fa-level-down', 'fa fa-level-up', 'fa fa-life-bouy', 'fa fa-life-buoy', 'fa fa-life-ring', 'fa fa-life-saver', 'fa fa-lightbulb-o', 'fa fa-line-chart', 'fa fa-link', 'fa fa-linkedin', 'fa fa-linkedin-square', 'fa fa-linode', 'fa fa-linux', 'fa fa-list', 'fa fa-list-alt', 'fa fa-list-ol', 'fa fa-list-ul', 'fa fa-location-arrow', 'fa fa-lock', 'fa fa-long-arrow-down', 'fa fa-long-arrow-left', 'fa fa-long-arrow-right', 'fa fa-long-arrow-up', 'fa fa-low-vision', 'fa fa-magic', 'fa fa-magnet', 'fa fa-mail-forward', 'fa fa-mail-reply', 'fa fa-mail-reply-all', 'fa fa-male', 'fa fa-map', 'fa fa-map-marker', 'fa fa-map-o', 'fa fa-map-pin', 'fa fa-map-signs', 'fa fa-mars', 'fa fa-mars-double', 'fa fa-mars-stroke', 'fa fa-mars-stroke-h', 'fa fa-mars-stroke-v', 'fa fa-maxcdn', 'fa fa-meanpath', 'fa fa-medium', 'fa fa-medkit', 'fa fa-meetup', 'fa fa-meh-o', 'fa fa-mercury', 'fa fa-microchip', 'fa fa-microphone', 'fa fa-microphone-slash', 'fa fa-minus', 'fa fa-minus-circle', 'fa fa-minus-square', 'fa fa-minus-square-o', 'fa fa-mixcloud', 'fa fa-mobile', 'fa fa-mobile-phone', 'fa fa-modx', 'fa fa-money', 'fa fa-moon-o', 'fa fa-mortar-board', 'fa fa-motorcycle', 'fa fa-mouse-pointer', 'fa fa-music', 'fa fa-navicon', 'fa fa-neuter', 'fa fa-newspaper-o', 'fa fa-object-group', 'fa fa-object-ungroup', 'fa fa-odnoklassniki', 'fa fa-odnoklassniki-square', 'fa fa-opencart', 'fa fa-openid', 'fa fa-opera', 'fa fa-optin-monster', 'fa fa-outdent', 'fa fa-pagelines', 'fa fa-paint-brush', 'fa fa-paper-plane', 'fa fa-paper-plane-o', 'fa fa-paperclip', 'fa fa-paragraph', 'fa fa-paste', 'fa fa-pause', 'fa fa-pause-circle', 'fa fa-pause-circle-o', 'fa fa-paw', 'fa fa-paypal', 'fa fa-pencil', 'fa fa-pencil-square', 'fa fa-pencil-square-o', 'fa fa-percent', 'fa fa-phone', 'fa fa-phone-square', 'fa fa-photo', 'fa fa-picture-o', 'fa fa-pie-chart', 'fa fa-pied-piper', 'fa fa-pied-piper-alt', 'fa fa-pied-piper-pp', 'fa fa-pinterest', 'fa fa-pinterest-p', 'fa fa-pinterest-square', 'fa fa-plane', 'fa fa-play', 'fa fa-play-circle', 'fa fa-play-circle-o', 'fa fa-plug', 'fa fa-plus', 'fa fa-plus-circle', 'fa fa-plus-square', 'fa fa-plus-square-o', 'fa fa-podcast', 'fa fa-power-off', 'fa fa-print', 'fa fa-product-hunt', 'fa fa-puzzle-piece', 'fa fa-qq', 'fa fa-qrcode', 'fa fa-question', 'fa fa-question-circle', 'fa fa-question-circle-o', 'fa fa-quora', 'fa fa-quote-left', 'fa fa-quote-right', 'fa fa-ra', 'fa fa-random', 'fa fa-ravelry', 'fa fa-rebel', 'fa fa-recycle', 'fa fa-reddit', 'fa fa-reddit-alien', 'fa fa-reddit-square', 'fa fa-refresh', 'fa fa-registered', 'fa fa-remove', 'fa fa-renren', 'fa fa-reorder', 'fa fa-repeat', 'fa fa-reply', 'fa fa-reply-all', 'fa fa-resistance', 'fa fa-retweet', 'fa fa-rmb', 'fa fa-road', 'fa fa-rocket', 'fa fa-rotate-left', 'fa fa-rotate-right', 'fa fa-rouble', 'fa fa-rss', 'fa fa-rss-square', 'fa fa-rub', 'fa fa-ruble', 'fa fa-rupee', 'fa fa-s15', 'fa fa-safari', 'fa fa-save', 'fa fa-scissors', 'fa fa-scribd', 'fa fa-search', 'fa fa-search-minus', 'fa fa-search-plus', 'fa fa-sellsy', 'fa fa-send', 'fa fa-send-o', 'fa fa-server', 'fa fa-share', 'fa fa-share-alt', 'fa fa-share-alt-square', 'fa fa-share-square', 'fa fa-share-square-o', 'fa fa-shekel', 'fa fa-sheqel', 'fa fa-shield', 'fa fa-ship', 'fa fa-shirtsinbulk', 'fa fa-shopping-bag', 'fa fa-shopping-basket', 'fa fa-shopping-cart', 'fa fa-shower', 'fa fa-sign-in', 'fa fa-sign-language', 'fa fa-sign-out', 'fa fa-signal', 'fa fa-signing', 'fa fa-simplybuilt', 'fa fa-sitemap', 'fa fa-skyatlas', 'fa fa-skype', 'fa fa-slack', 'fa fa-sliders', 'fa fa-slideshare', 'fa fa-smile-o', 'fa fa-snapchat', 'fa fa-snapchat-ghost', 'fa fa-snapchat-square', 'fa fa-snowflake-o', 'fa fa-soccer-ball-o', 'fa fa-sort', 'fa fa-sort-alpha-asc', 'fa fa-sort-alpha-desc', 'fa fa-sort-amount-asc', 'fa fa-sort-amount-desc', 'fa fa-sort-asc', 'fa fa-sort-desc', 'fa fa-sort-down', 'fa fa-sort-numeric-asc', 'fa fa-sort-numeric-desc', 'fa fa-sort-up', 'fa fa-soundcloud', 'fa fa-space-shuttle', 'fa fa-spinner', 'fa fa-spoon', 'fa fa-spotify', 'fa fa-square', 'fa fa-square-o', 'fa fa-stack-exchange', 'fa fa-stack-overflow', 'fa fa-star', 'fa fa-star-half', 'fa fa-star-half-empty', 'fa fa-star-half-full', 'fa fa-star-half-o', 'fa fa-star-o', 'fa fa-steam', 'fa fa-steam-square', 'fa fa-step-backward', 'fa fa-step-forward', 'fa fa-stethoscope', 'fa fa-sticky-note', 'fa fa-sticky-note-o', 'fa fa-stop', 'fa fa-stop-circle', 'fa fa-stop-circle-o', 'fa fa-street-view', 'fa fa-strikethrough', 'fa fa-stumbleupon', 'fa fa-stumbleupon-circle', 'fa fa-subscript', 'fa fa-subway', 'fa fa-suitcase', 'fa fa-sun-o', 'fa fa-superpowers', 'fa fa-superscript', 'fa fa-support', 'fa fa-table', 'fa fa-tablet', 'fa fa-tachometer', 'fa fa-tag', 'fa fa-tags', 'fa fa-tasks', 'fa fa-taxi', 'fa fa-telegram', 'fa fa-television', 'fa fa-tencent-weibo', 'fa fa-terminal', 'fa fa-text-height', 'fa fa-text-width', 'fa fa-th', 'fa fa-th-large', 'fa fa-th-list', 'fa fa-themeisle', 'fa fa-thermometer', 'fa fa-thermometer-0', 'fa fa-thermometer-1', 'fa fa-thermometer-2', 'fa fa-thermometer-3', 'fa fa-thermometer-4', 'fa fa-thermometer-empty', 'fa fa-thermometer-full', 'fa fa-thermometer-half', 'fa fa-thermometer-quarter', 'fa fa-thermometer-three-quarters', 'fa fa-thumb-tack', 'fa fa-thumbs-down', 'fa fa-thumbs-o-down', 'fa fa-thumbs-o-up', 'fa fa-thumbs-up', 'fa fa-ticket', 'fa fa-times', 'fa fa-times-circle', 'fa fa-times-circle-o', 'fa fa-times-rectangle', 'fa fa-times-rectangle-o', 'fa fa-tint', 'fa fa-toggle-down', 'fa fa-toggle-left', 'fa fa-toggle-off', 'fa fa-toggle-on', 'fa fa-toggle-right', 'fa fa-toggle-up', 'fa fa-trademark', 'fa fa-train', 'fa fa-transgender', 'fa fa-transgender-alt', 'fa fa-trash', 'fa fa-trash-o', 'fa fa-tree', 'fa fa-trello', 'fa fa-tripadvisor', 'fa fa-trophy', 'fa fa-truck', 'fa fa-try', 'fa fa-tty', 'fa fa-tumblr', 'fa fa-tumblr-square', 'fa fa-turkish-lira', 'fa fa-tv', 'fa fa-twitch', 'fa fa-twitter', 'fa fa-twitter-square', 'fa fa-umbrella', 'fa fa-underline', 'fa fa-undo', 'fa fa-universal-access', 'fa fa-university', 'fa fa-unlink', 'fa fa-unlock', 'fa fa-unlock-alt', 'fa fa-unsorted', 'fa fa-upload', 'fa fa-usb', 'fa fa-usd', 'fa fa-user', 'fa fa-user-circle', 'fa fa-user-circle-o', 'fa fa-user-md', 'fa fa-user-o', 'fa fa-user-plus', 'fa fa-user-secret', 'fa fa-user-times', 'fa fa-users', 'fa fa-vcard', 'fa fa-vcard-o', 'fa fa-venus', 'fa fa-venus-double', 'fa fa-venus-mars', 'fa fa-viacoin', 'fa fa-viadeo', 'fa fa-viadeo-square', 'fa fa-video-camera', 'fa fa-vimeo', 'fa fa-vimeo-square', 'fa fa-vine', 'fa fa-vk', 'fa fa-volume-control-phone', 'fa fa-volume-down', 'fa fa-volume-off', 'fa fa-volume-up', 'fa fa-warning', 'fa fa-wechat', 'fa fa-weibo', 'fa fa-weixin', 'fa fa-whatsapp', 'fa fa-wheelchair', 'fa fa-wheelchair-alt', 'fa fa-wifi', 'fa fa-wikipedia-w', 'fa fa-window-close', 'fa fa-window-close-o', 'fa fa-window-maximize', 'fa fa-window-minimize', 'fa fa-window-restore', 'fa fa-windows', 'fa fa-won', 'fa fa-wordpress', 'fa fa-wpbeginner', 'fa fa-wpexplorer', 'fa fa-wpforms', 'fa fa-wrench', 'fa fa-xing', 'fa fa-xing-square', 'fa fa-y-combinator', 'fa fa-y-combinator-square', 'fa fa-yahoo', 'fa fa-yc', 'fa fa-yc-square', 'fa fa-yelp', 'fa fa-yen', 'fa fa-yoast', 'fa fa-youtube', 'fa fa-youtube-play', 'fa fa-youtube-square'];
        var slIcons = ['icon-user', 'icon-people', 'icon-user-female', 'icon-user-follow', 'icon-user-following', 'icon-user-unfollow', 'icon-login', 'icon-logout', 'icon-emotsmile', 'icon-phone', 'icon-call-end', 'icon-call-in', 'icon-call-out', 'icon-map', 'icon-location-pin', 'icon-direction', 'icon-directions', 'icon-compass', 'icon-layers', 'icon-menu', 'icon-list', 'icon-options-vertical', 'icon-options', 'icon-arrow-down', 'icon-arrow-left', 'icon-arrow-right', 'icon-arrow-up', 'icon-arrow-up-circle', 'icon-arrow-left-circle', 'icon-arrow-right-circle', 'icon-arrow-down-circle', 'icon-check', 'icon-clock', 'icon-plus', 'icon-minus', 'icon-close', 'icon-exclamation', 'icon-organization', 'icon-trophy', 'icon-screen-smartphone', 'icon-screen-desktop', 'icon-plane', 'icon-notebook', 'icon-mustache', 'icon-mouse', 'icon-magnet', 'icon-energy', 'icon-disc', 'icon-cursor', 'icon-cursor-move', 'icon-crop', 'icon-chemistry', 'icon-speedometer', 'icon-shield', 'icon-screen-tablet', 'icon-magic-wand', 'icon-hourglass', 'icon-graduation', 'icon-ghost', 'icon-game-controller', 'icon-fire', 'icon-eyeglass', 'icon-envelope-open', 'icon-envelope-letter', 'icon-bell', 'icon-badge', 'icon-anchor', 'icon-wallet', 'icon-vector', 'icon-speech', 'icon-puzzle', 'icon-printer', 'icon-present', 'icon-playlist', 'icon-pin', 'icon-picture', 'icon-handbag', 'icon-globe-alt', 'icon-globe', 'icon-folder-alt', 'icon-folder', 'icon-film', 'icon-feed', 'icon-drop', 'icon-drawer', 'icon-docs', 'icon-doc', 'icon-diamond', 'icon-cup', 'icon-calculator', 'icon-bubbles', 'icon-briefcase', 'icon-book-open', 'icon-basket-loaded', 'icon-basket', 'icon-bag', 'icon-action-undo', 'icon-action-redo', 'icon-wrench', 'icon-umbrella', 'icon-trash', 'icon-tag', 'icon-support', 'icon-frame', 'icon-size-fullscreen', 'icon-size-actual', 'icon-shuffle', 'icon-share-alt', 'icon-share', 'icon-rocket', 'icon-question', 'icon-pie-chart', 'icon-pencil', 'icon-note', 'icon-loop', 'icon-home', 'icon-grid', 'icon-graph', 'icon-microphone', 'icon-music-tone-alt', 'icon-music-tone', 'icon-earphones-alt', 'icon-earphones', 'icon-equalizer', 'icon-like', 'icon-dislike', 'icon-control-start', 'icon-control-rewind', 'icon-control-play', 'icon-control-pause', 'icon-control-forward', 'icon-control-end', 'icon-volume-1', 'icon-volume-2', 'icon-volume-off', 'icon-calendar', 'icon-bulb', 'icon-chart', 'icon-ban', 'icon-bubble', 'icon-camrecorder', 'icon-camera', 'icon-cloud-download', 'icon-cloud-upload', 'icon-envelope', 'icon-eye', 'icon-flag', 'icon-heart', 'icon-info', 'icon-key', 'icon-link', 'icon-lock', 'icon-lock-open', 'icon-magnifier', 'icon-magnifier-add', 'icon-magnifier-remove', 'icon-paper-clip', 'icon-paper-plane', 'icon-power', 'icon-refresh', 'icon-reload', 'icon-settings', 'icon-star', 'icon-symbol-female', 'icon-symbol-male', 'icon-target', 'icon-credit-card', 'icon-paypal', 'icon-social-tumblr', 'icon-social-twitter', 'icon-social-facebook', 'icon-social-instagram', 'icon-social-linkedin', 'icon-social-pinterest', 'icon-social-github', 'icon-social-google', 'icon-social-reddit', 'icon-social-skype', 'icon-social-dribbble', 'icon-social-behance', 'icon-social-foursqare', 'icon-social-soundcloud', 'icon-social-spotify', 'icon-social-stumbleupon', 'icon-social-youtube', 'icon-social-dropbox'];

        var iconsWindow = '<div tabindex="0" role="dialog" id="icons-modal" style="position: relative; display: none;">' + 
                                '<div class="media-modal wp-core-ui">' + 
                                    '<button type="button" class="media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text">Close</span></span></button>' + 
                                    '<div class="media-modal-content">' + 
                                        '<div class="media-frame mode-select wp-core-ui">' + 
                                            '<div class="media-frame-title">' + 
                                                '<h1>Icons</h1>' + 
                                                '<div class="search-icons-wrapper">' + 
                                                    '<div class="row">' + 
                                                        '<div class="col-xs-12 col-sm-12 col-md-4 search-icons rtl-pull-right">' +
                                                            '<span class="fa fa-search"></span>' + 
                                                            '<input type="text" id="search-icons-input" class="form-control" placeholder="Search icons">' + 
                                                        '</div>' +
                                                    '</div>' + 
                                                '</div>' + 
                                            '</div>' + 
                                            '<div class="media-frame-content">' + 
                                                '<div class="icons-frame-content">' + 
                                                    '<div class="icons-modal-subtitle">Font Awesome</div>' + 
                                                    '<div class="icons-list icons-list-fa"></div>' + 
                                                    '<div class="icons-modal-subtitle">Simple Line</div>' + 
                                                    '<div class="icons-list icons-list-sl"></div>' + 
                                                '</div>' + 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="media-modal-backdrop"></div>' + 
                            '</div>';

        $('body').append(iconsWindow);

        $('#icons-modal .media-modal-close').on('click', function(e) {
            $('#icons-modal').hide().remove();
            e.preventDefault();
        });
        $('#icons-modal').on('keyup',function(e) {
            if (e.keyCode == 27) {
               $(this).hide().remove();
               e.preventDefault();
            }
        });

        var faList = '<div class="row">';
        for(var i = 0; i < faIcons.length; i++) {
            faList += '<div class="col-xs-6 col-sm-4 col-md-3 is-icon">' + 
                            '<div class="icons-item">' + 
                                '<span class="' + faIcons[i] + '"></span> ' + faIcons[i] + 
                            '</div>' + 
                        '</div>';
        }
        faList += '</div>';
        $('#icons-modal .icons-list-fa').append(faList);

        var slList = '<div class="row">';
        for(var i = 0; i < slIcons.length; i++) {
            slList += '<div class="col-xs-6 col-sm-4 col-md-3 is-icon">' + 
                            '<div class="icons-item">' + 
                                '<span class="' + slIcons[i] + '"></span> ' + slIcons[i] + 
                            '</div>' + 
                        '</div>';
        }
        slList += '</div>';
        $('#icons-modal .icons-list-sl').append(slList);

        $('#search-icons-input').on('keyup', function() {
            var value = this.value;

            $('.is-icon').each(function(index) {
                var id = $(this).text();
                $(this).toggle(id.indexOf(value) !== -1);
            });
        });

        var selected = $(btn).find('span').attr('class');
        $('.icons-item span').each(function() {
            if($(this).hasClass(selected)) {
                $(this).parent().addClass('is-selected');
            }
        });

        $('.icons-item').on('click', function(e) {
            var cName = $(this).find('span').attr('class');

            $(btn).html('<span class="' + cName + '"></span> ' + cName);
            $(btn).prev('input').val(cName);

            $('#icons-modal').hide().remove();
            e.preventDefault();
        });

        $('#icons-modal').show().focus();
    }

    $('.choose-icon').click(function(event) {
        openIconsWindow(this);
    });

    $('.icons-field').each(function(index, el) {
        var fieldValue = $(this).val();
        if(fieldValue != '') {
            $(this).next('.choose-icon').html('<span class="' + fieldValue + '"></span> ' + fieldValue);
        }
    });

    $('#save_cards_design').click(function() {
        var _self = $(this);

        _self.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'    : 'reales_save_cards_design',
                'card_type' : $('#card_type').val(),
                'security'  : $('#securityPropCards').val()
            },
            success: function(data) {
                if(data.add == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=prop_cards_design';
                } else {
                    _self.removeAttr('disabled');
                    alert(data.message);
                }
            }
        });
    });

    var card_type = $('#card_type').val();

    switch(card_type) {
        case 'd1':
            $('.sample-card-1').css('display', 'block');
            break;
        case 'd2':
            $('.sample-card-2').css('display', 'block');
            break;
        default:
            $('.sample-card-1').css('display', 'block');
    }

    $('#card_type').change(function(event) {
        $('.sample-card').hide();

        switch($(this).val()) {
            case 'd1':
                $('.sample-card-1').css('display', 'block');
                break;
            case 'd2':
                $('.sample-card-2').css('display', 'block');
                break;
        }
    });

    $('#save_agent_cards_design').click(function() {
        var _self = $(this);

        _self.attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: settings_vars.ajaxurl,
            data: {
                'action'    : 'reales_save_agent_cards_design',
                'card_type' : $('#agent_card_type').val(),
                'security'  : $('#securityAgentCards').val()
            },
            success: function(data) {
                if(data.add == true) {
                    document.location.href = 'themes.php?page=admin/settings.php&tab=agent_cards_design';
                } else {
                    _self.removeAttr('disabled');
                    alert(data.message);
                }
            }
        });
    });

    var agent_card_type = $('#agent_card_type').val();

    switch(agent_card_type) {
        case 'd1':
            $('.agent-sample-card-1').css('display', 'block');
            break;
        case 'd2':
            $('.agent-sample-card-2').css('display', 'block');
            break;
        default:
            $('.agent-sample-card-1').css('display', 'block');
    }

    $('#agent_card_type').change(function(event) {
        $('.agent-sample-card').hide();

        switch($(this).val()) {
            case 'd1':
                $('.agent-sample-card-1').css('display', 'block');
                break;
            case 'd2':
                $('.agent-sample-card-2').css('display', 'block');
                break;
        }
    });
})(jQuery);