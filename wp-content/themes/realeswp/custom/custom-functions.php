<?php
$useOld = false;
define('SMS_GATEWAY_SENDER_ID', 'MAPADS');
if ($useOld) {
    define('SMS_GATEWAY_URL', 'https://apps.malert.io/api/api_http.php');
    define('SMS_GATEWAY_USAERNAME', 'Digitaladvice');
    define('SMS_GATEWAY_PASSWORD', 'Admin@2022');
}
//SMS functions
if (!$useOld) {
    define('SMS_GATEWAY_URL', 'https://bulksms.digitaladvicefirm.com/api/api_http.php');
    define('SMS_GATEWAY_USAERNAME', 'digitaladvice1');
    define('SMS_GATEWAY_PASSWORD', 'Admin@2022'); // API PASSWORD is not same with the portal login password
    //    define('SMS_GATEWAY_PASSWORD', 'Malert@777');
}

function _print($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

// define('SMTP_USER', 'main.nextsqft@gmail.com');    // your SMTP Username 
// define('SMTP_PASS', 'biro imqy iqef zqkw');   // your SMTP Password 
// define('SMTP_HOST', 'smtp.gmail.com');     // mail server hostname
// define('SMTP_FROM', 'main.nextsqft@gmail.com'); // from email address 
// define('SMTP_NAME', 'NEXTSQFT');    // Website Name
// define('SMTP_DEBUG', 0);
// define('SMTP_PORT', '587');     // Server Port Number
// define('SMTP_SECURE', 'tls');   // Encryption - ssl or tls
// define('SMTP_AUTH', true);  // Use SMTP authentication (true|false)
// NEXT SQFT SERVER MAIL
//define('SMTP_USER', 'admin@nextsqft.com');    // your SMTP Username 
//define('SMTP_PASS', '6m(qMG%;7mXY');   // your SMTP Password 
//define('SMTP_HOST', 'smtp.nextsqft.com');     // mail server hostname
//define('SMTP_FROM', 'admin@nextsqft.com'); // from email address 
//define('SMTP_NAME', 'NEXTSQFT');    // Website Name
//define('SMTP_DEBUG', 0);
//define('SMTP_PORT', '465');     // Server Port Number
//define('SMTP_SECURE', 'tls');   // Encryption - ssl or tls
//define('SMTP_AUTH', true);  // Use SMTP authentication (true|false)


// add_action('phpmailer_init', 'my_smtp_phpemailer');

// function my_smtp_phpemailer($phpmailer) {
//     $phpmailer->isSMTP();
//     $phpmailer->Host = SMTP_HOST;
//     $phpmailer->SMTPAuth = SMTP_AUTH;
//     $phpmailer->Port = SMTP_PORT;
//     $phpmailer->Username = SMTP_USER;
//     $phpmailer->Password = SMTP_PASS;
//     $phpmailer->SMTPSecure = SMTP_SECURE;
//     $phpmailer->From = SMTP_FROM;
//     $phpmailer->FromName = SMTP_NAME;
// }

//add_action('wp_mail_failed', 'onMailError', 10, 1);

// function onMailError($wp_error) {
//     echo "<pre>";
//     print_r($wp_error);
//     echo "</pre>";
// }

// function mail_function() {
//     echo wp_mail("suchandan.developer@gmail.com", "TEST", "TESING SHOULD PASS");
// }

// add_action('wp_ajax_mail_function', 'mail_function');    //execute when wp logged in
// add_action('wp_ajax_nopriv_mail_function', 'mail_function'); //execute when logged out

function generate_sms_Meta()
{
    $param = array(
        'username' => SMS_GATEWAY_USAERNAME,
        'password' => SMS_GATEWAY_PASSWORD,
        'senderid' => SMS_GATEWAY_SENDER_ID,
        'route' => 'Informative',
        'type' => 'text',
        'datetime' => date('Y-m-d H:i:s')
    );
    return $param;
}

// Featured saller SMS
function send_saler_sms($send_to, $number, $name, $url)
{
    $recipients = array($send_to);
    $param = generate_sms_Meta();
    $param['text'] = 'New query from customer via https://nextsqft.com Contact the buyer ' . $name . ' at ' . $number . ' . Source Url: ' . $url . ' . Regards- Digital Advice Firm';
    $param['to'] = implode(';', $recipients);
    if (isset($_GET['show_sms'])) {
        _print($param['text']);
    }
    send_sms($param);
}

//Free saller sms
function send_featured_saler_sms($send_to, $number, $name, $url)
{
    send_saler_sms($send_to, $number, $name, $url);
}

function send_free_saler_sms($send_to, $name, $url)
{
    $recipients = array($send_to);
    $param = generate_sms_Meta();
    $param['text'] = ' New query for the nextsqft Profile Url: ' . $url . ' . Contact the buyer ' . $name . ' at +91x. Activate Your Profile- https://nextsqft.com/real-ads/ Regards Digital Advice Firm ';
    $param['to'] = implode(';', $recipients);
    if (isset($_GET['show_sms'])) {
        _print($param['text']);
    }
    send_sms($param);
}

function send_buyer_sms($send_to, $number, $name, $url)
{
    $recipients = array($send_to);
    $param = generate_sms_Meta();
    //    $param['text'] = 'Welcome to #nextsqft. Contact the seller ' . $name . ' at ' . $number . '.Source Url: ' . $url . '. Regards-nextsqft';
    $param['text'] = ' Thank you for your enquiry. Contact the property seller ' . $name . ' at ' . $number . ' .Source Url: ' . $url . ' . Regards- Digital Advice Firm ';

    $param['to'] = implode(';', $recipients);
    if (isset($_GET['show_sms'])) {
        _print($param['text']);
    }
    send_sms($param);
}

function test_sms()
{
    $buyer_number = "8013182265";
    $url = url_short_io('https://nextsqft.com/properties/full-furnished-rajarhat-narayanpur-complex-3bhk-flat-for-sale/', 'Full furnished Rajarhat Narayanpur complex 3bhk flat for sale');
    $saller = isset($_GET['saller']) ? $_GET['saller'] : 'free';
    $send_to = '7980234140';
    $name = "Suchandan Haldar";

    if ($saller === 'free') {
        send_free_saler_sms($send_to, $name, $url);
    } else if ($saller === 'featured') {
        send_featured_saler_sms($send_to, $buyer_number, $name, $url);
    }
}

// New query for the nextsqft Profile Url: https://nextsqft.com/seller/subrata-bhattacharya/ . Contact the buyer Suchandan at +91x. Activate Your Profile- https://nextsqft.com/real-ads/ Regards Digital Advice Firm
add_action('wp_ajax_test_sms', 'test_sms');    //execute when wp logged in
add_action('wp_ajax_nopriv_test_sms', 'test_sms'); //execute when logged out

function manage_sms($param, $plan_featured)
{
    extract($param);

    //    $sms_data = array(
    //        'saler_number' => $saler_phone,
    //        'saler_name' => $agent->post_title,
    //        'buyer_number' => $customer_mobile,
    //        'buyer_name' => $customer_name,
    //        'url' => $link,
    //        'agent_link' => $agent_link,
    //        'data' => get_post_meta($agent_id),
    //        'user' => get_userdata(get_post_meta($agent_id, 'agent_user', true))
    //    );

    if ($plan_featured) {
        send_featured_saler_sms($saler_number, $buyer_number, $buyer_name, $url);
    } else {
        send_free_saler_sms($saler_number, $buyer_name, $agent_link);
    }

    send_buyer_sms($buyer_number, $saler_number, $saler_name, $url);
}

function send_sms($param)
{
    if (!$param)
        return false;
    //    $url = "https://apps.malert.io/api/api_http.php";
    $url = SMS_GATEWAY_URL;
    $post = http_build_query($param, '', '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
    $result = curl_exec($ch);

    if (isset($_REQUEST['show_sms'])) {
        _print($result);
        _print($param);
    }

    if (curl_errno($ch)) {
        $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
    } else {
        $returnCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch ($returnCode) {
            case 200:
                break;
            default:
                $result = "HTTP ERROR: " . $returnCode;
        }
    }
    curl_close($ch);
}

function url_short_io($url, $title = '')
{
    $private_key = 'sk_69yNIehA6FKS2KOL';
    $public_key = 'pk_lCYWXNJkIQN5tK8b';

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.short.io/links",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'title' => $title,
            'domain' => 'cotf.short.gy',
            'originalURL' => $url
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: sk_69yNIehA6FKS2KOL",
            "accept: application/json",
            "content-type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        //        echo "cURL Error #:" . $err;
        return false;
    } else {
        //        echo $response;
        $result = json_decode($response);
        if ($result) {
            return $result->secureShortURL;
        }
    }

    return false;
}

function test_short_url()
{
    print_r(url_short_io('https://nextsqft.com/properties/full-furnished-rajarhat-narayanpur-complex-3bhk-flat-for-sale/', 'Full furnished Rajarhat Narayanpur complex 3bhk flat for sale'));
}

add_action('wp_ajax_test_short_url', 'test_short_url');    //execute when wp logged in
add_action('wp_ajax_nopriv_test_short_url', 'test_short_url'); //execute when logged out

function short_url_bitly($long_url)
{
    $apiv4 = 'https://api-ssl.bitly.com/v4/shorten';
    $genericAccessToken = 'ad9ad8d0e0e0180025c457b78e8b8d7e5a476d02';

    if (!$long_url) {
        $long_url = $_GET['long_url'];
    }
    $data = array(
        'long_url' => $long_url,
        //        "group_guid" => "o_3cfp3pt3i6"
    );
    $payload = json_encode($data);

    $header = array(
        'Authorization: Bearer ' . $genericAccessToken,
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    );

    $ch = curl_init($apiv4);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);

    $result = json_decode($result);
    test_api($result);
    if (isset($result->link)) {
        return $result->link;
    }
    return false;
}

function short_url_by_cutly($long_url)
{
    $apiv4 = 'https://cutt.ly/api/api.php';
    $genericAccessToken = 'a78c8d80b9a1ca889ad37c706e180cb9ff544';

    if (!$long_url) {
        $long_url = $_GET['long_url'];
    }

    $result = file_get_contents("https://cutt.ly/api/api.php?key=" . $genericAccessToken . "&short=" . urlencode($long_url) . "&userDomain=0");

    $result = json_decode($result);
    $result = $result->url;

    test_api($result, $_GET);

    if ($result->status == 7) {
        return $result->shortLink;
    }
    return false;
}

function test_api($json)
{
    if (isset($_GET['isApi'])) {
        if (isset($_GET['show'])) {
            _print($json);
            return false;
        }
    }
}

function send_json_response($data)
{
    wp_send_json($data);
    wp_die(); //use wp_die() once you have completed your execution.
}

add_action('wp_ajax_get_saller_contact', 'get_saller_contact');    //execute when wp logged in
add_action('wp_ajax_nopriv_get_saller_contact', 'get_saller_contact'); //execute when logged out

function get_saller_contact()
{
    $logged_in_user = wp_get_current_user();
    $user = get_userdata($logged_in_user->ID);
    $is_logged_in = is_user_logged_in();
    //    $is_saller = reales_check_user_agent($user->ID) === true;
    $is_mobile_numbr_showable = $is_logged_in;

    //    if (!$is_mobile_numbr_showable) {
    //        wp_send_json(array(
    //            'message' => 'Saller details can not be shown..',
    //            'status' => "failure",
    //            'statusCode' => '401',
    //            'loggedIn' => false
    //        ));
    //        wp_die();
    //    }

    $agent_id = $_REQUEST['saler_id'];
    $agent = get_post($agent_id);
    $agent_phone = get_post_meta($agent_id, 'agent_phone', true);
    $agent_mobile = get_post_meta($agent_id, 'agent_mobile', true);
    $plan_id = get_post_meta($agent_id, 'agent_plan', true);
    $is_featured = esc_html(get_post_meta($agent_id, 'agent_featured', true)) == 1;

    if ($agent) {

        global $current_user;

        //        $args = array(
        //            'post_type' => 'agent',
        //            'author' => $current_user->ID,
        //            'orderby' => 'post_date',
        //            'post_status' => 'publish',
        //            'order' => 'ASC',
        //            'posts_per_page' => -1 // no limit
        //        );

        wp_send_json(array(
            'message' => 'Saler ingo fetched successfully.',
            'status' => "success",
            'statusCode' => '200',
            'agent' => $agent,
            'mobile' => $agent_phone,
            'phone' => $agent_mobile,
            'is_featured' => $is_featured
        ));
        wp_die(); //use wp_die() once you have completed your execution.
    }
}

add_action('wp_footer', 'new_system_tray');

function new_system_tray()
{
    //    echo get_page_template_slug();

    $user = wp_get_current_user();
    $is_logged_in = is_user_logged_in();
    $is_saller = reales_check_user_agent($user->ID) === true;

    $args = array(
        'post_type' => 'agent',
        'author' => $user->ID,
        'orderby' => 'post_date',
        'post_status' => 'publish',
        'order' => 'ASC',
        'posts_per_page' => -1 // no limit
    );


    $current_user_posts = get_posts($args);
    $total = count($current_user_posts);
    $saller_url = "https://nextsqft.com";

    if ($total > 0) {
        $saler_post = $current_user_posts[0];
        $saller_url = get_the_permalink($saler_post->ID);
    }

    $attr = array(
        "new" => "",
        "profile" => "",
        "properties" => "",
        "fevourite" => "",
        "alert" => "",
    );
    if ($is_logged_in) {
        $attr['new'] = "href='" . site_url('/submit-new-property/') . "'";
        $profile_link = site_url('/account-settings/');
        if ($is_saller) {
            $profile_link = $saller_url;
        }
        $attr['profile'] = "href='" . $profile_link . "'";
        $attr['properties'] = "href='" . site_url('/my-properties/') . "'";
        $attr['fevourite'] = "href='" . site_url('/favourite-properties/') . "'";
        $attr['alert'] = "href='" . site_url('/request-a-query/') . "'";
    }
    if (!is_page_template('submit-property.php') && !is_page_template('page-contact.php') && !is_page_template('user-account.php')) {
?>
        <div class="system-tray" id="newSite">
            <a class="system-tray-item" <?php echo $attr['new']; ?>>
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                <span class="glyphicon-class">Add New</span>
            </a>
            <?php if (!$is_saller): ?>
                <a class="system-tray-item" <?php echo $attr['alert']; ?>>
                    <!--            <a class="system-tray-item" data-toggle="modal" data-target="#searches-modal">-->
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    <span class="glyphicon-class">Search</span>
                </a>
            <?php endif; ?>
            <?php if ($is_saller): ?>
                <a class="system-tray-item" <?php echo $attr['properties']; ?>>
                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    <span class="glyphicon-class">Properties</span>
                </a>
            <?php endif; ?>
            <?php if (!$is_saller): ?>
                <a class="system-tray-item" <?php echo $attr['fevourite']; ?>>
                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                    <span class="glyphicon-class">Favourite</span>
                </a>
            <?php endif; ?>
            <!--            <a class="system-tray-item" <?php // echo $attr['alert'];                                            
                                                        ?>>
        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
        <span class="glyphicon-class">Set alert</span>
        </a>-->
            <a class="system-tray-item" <?php echo $attr['profile']; ?>>
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <span class="glyphicon-class">Profile</span>
            </a>
        </div>
        <?php if (!$is_logged_in): ?>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $("#newSite a").click(function(e) {
                        e.preventDefault();
                        if ($('#signin').hasClass('in')) {
                            $('#signin').modal('hide');
                            setTimeout(function() {
                                $('#signin').modal('show');
                            }, 500);
                        } else {
                            $('#signin').modal('show');
                        }
                    });
                });
            </script>
        <?php endif; ?>
        <style type="text/css">
            @media (max-width: 767px) {
                .home-footer {
                    margin-bottom: 54px;
                }
            }
        </style>
<?php
    }
}

add_action('wpcf7_mail_sent', 'do_some_work_contact_form_7', 99);

add_action('wp_ajax_do_some_work_contact_form_7', 'do_some_work_contact_form_7');    //execute when wp logged in
add_action('wp_ajax_nopriv_do_some_work_contact_form_7', 'do_some_work_contact_form_7'); //execute when logged out
//This function called when contact saler form is successfully submitted and mail has been sent

function do_some_work_contact_form_7($contact_form)
{
    if (isset($_REQUEST['saler_id'])) {
        $agent_id = $_REQUEST['saler_id'];
        $post_id = $_REQUEST['post_id'];

        $agent = get_post($agent_id);
        $agent_link = get_the_permalink($agent->ID);

        //saler details
        $saler_phone = get_post_meta($agent_id, 'agent_mobile', true);
        //        $saler_name = get_post_meta($agent_id, 'agent_name', true);
        //PLAN DETAILS FOR SALER
        $plan_id = get_post_meta($agent_id, 'agent_plan', true);
        $is_featured = esc_html(get_post_meta($agent_id, 'agent_featured', true)) == 1;
        $has_free = '';

        $plan_name = get_the_title($plan_id);
        $plan_listings = get_post_meta($agent_id, 'agent_plan_listings', true);
        $plan_featured = get_post_meta($agent_id, 'agent_plan_featured', true);
        $plan_unlimited = get_post_meta($agent_id, 'agent_plan_unlimited', true);
        $has_free = get_post_meta($agent_id, 'agent_plan_free', true);
        $plan_activation = strtotime(get_post_meta($agent_id, 'agent_plan_activation', true));
        $plan_time_unit = get_post_meta($plan_id, 'membership_billing_time_unit', true);
        $plan_period = get_post_meta($plan_id, 'membership_period', true);

        $time_frame = $seconds * $plan_period;
        $expiration_date = $plan_activation + $time_frame;
        $expiration_date = date('Y-m-d', $expiration_date);
        $today = getdate();
        //PLAN DETAILS FOR SALER

        $customer_name = $_REQUEST['FullName'];
        $customer_mobile = $_REQUEST['mobile'];
        $customer_email = $_REQUEST['email'];
        $customer_query = $_REQUEST['query'];

        $agent_email = get_post_meta($agent_id, 'agent_email', true);
        $admin_email = get_option('admin_email');
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: NEXT SQFT <' . $admin_email . '>';

        $request_link = get_bloginfo('home') . '/request-a-query';

        $title = get_the_title($post_id);
        $permalink = get_the_permalink($post_id);

        $subject = "New query from customer :";

        $message = "<p>Name - " . $customer_name . "</p>";
        //         $message = "<p>Name - " . $customer_name . "=" . $plan_id . "=" . $agent_id . "=" . $today[0] . "=" . strtotime($expiration_date) . "</p>";

        if ($is_featured) {
            $message .= "<p>Phone - " . $customer_mobile . "</p>"
                . "<p>Email - " . $customer_email . "</p>";
        }

        $message .= "<p>Query - " . $customer_query . "</p>"
            . "<p>Property - <a href='" . $permalink . "'> " . $title . " </a>";


        //        $agent_email = "suchandan.developer@gmail.com"; 
        $saler_mail_status = wp_mail($agent_email, $subject, $message, $headers);


        $message = "<p>Thank you for your enquiry. 
You have contacted <b>" . esc_html($agent->post_title) . "</b> for this property <a href='" . $permalink . "'> " . $title . " </a>.  
Seller will contact you soon. </p>

<p>To get exact property alerts, kindly fillup the property requirements <a href='" . $request_link . "'> Form </a>.";


        //        $customer_email = "suchandan.developer@gmail.com";
        $buyer_mail_status = wp_mail($customer_email, "Thank you for connecting saller through NEXT SQFT", $message, $headers);

        $link = $permalink;
        //        $result = short_url_by_cutly($link);
        $result = url_short_io($link, $title);
        if ($result) {
            //            $link = "Property ID: " . $post_id;
            //        } else {
            $link = $result;
        }
        $sms_data = array(
            'saler_number' => $saler_phone,
            'saler_name' => $agent->post_title,
            'buyer_number' => $customer_mobile,
            'buyer_name' => $customer_name,
            'url' => $link,
            'agent_link' => url_short_io($agent_link),
            //            'data' => get_post_meta($agent_id),
            //            'user' => get_userdata(get_post_meta($agent_id, 'agent_user', true))
        );
        //send sms both way alert to buyers and saler
        manage_sms($sms_data, $plan_featured);

        //        wp_send_json($sms_data);
        //        wp_die(); //use wp_die() once you have completed your execution.
    }
}
