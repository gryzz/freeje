<?php

$ch      = curl_init();

$fp = fopen("cookie.txt", "w");
fclose($fp);
//$page = getWebPage('http://users.telecomax.net/cabapi/amfphp/json.php/service2.getSites');
//$page = getWebPage('http://users.telecomax.net/cabapi/amfphp/json.php/service2.getCountryForRegistartion');
//$page = getWebPage($ch, 'http://users.telecomax.net/cabapi/amfphp/json.php/service2.login/gryzz@mail.lviv.ua/4188991524/25');

//$sites = json_decode($page['content']);

//var_dump($sites);

//$page = getWebPage($ch, 'http://users.telecomax.net/cabapi/amfphp/json.php/service2.getCallHistory/20090101/20101212', false);

$page = getWebPage($ch, 'http://users.telecomax.net/cabapi/amfphp/json.php/service2.whoAmI', false);

$sites = json_decode($page['content']);

//var_dump($sites);

function getWebPage($ch, $url, $first=true )
{
    if ($first) {
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_COOKIEJAR      => "/tmp/cookie.txt",
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true
        );
    } else {
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_COOKIEFILE     => "/tmp/cookie.txt",
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true
        );
    }

    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);

    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;

    var_dump($header);

    return $header;
}

//curl_close( $ch );

?>
