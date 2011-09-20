<?php

$ch      = curl_init();

$page = getWebPage($ch, 'http://users.telecomax.net/cabapi/amfphp/json.php/service2.getCallBackCost/+38067629097/+38sac/phone/phone');

var_dump(json_decode($page['content']));


function getWebPage($ch, $url)
{
    $options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
//            CURLOPT_COOKIEJAR      => "/tmp/cookie.txt",
//        CURLOPT_COOKIEFILE     => "cookie.txt",
 //           CURLOPT_COOKIE         => "A2BSesIdentClients=bb3abc183de3dd84f318e309239e2586",
//            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLINFO_HEADER_OUT    => true
    );

    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);



    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    
    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;


    return $header;
}

//curl_close( $ch );

?>