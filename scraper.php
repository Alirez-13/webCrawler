<?php

include_once("simple_html_dom.php");

// specify the target website's URL
$url = "https://www.entekhab.ir/fa/services/2/1";

// initialize a cURL session
$curl = curl_init();

// set the website URL
curl_setopt($curl, CURLOPT_URL, $url);

// return the response as a string
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// follow redirects
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

// ignore SSL verification
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// execute the cURL session
$htmlContent = curl_exec($curl);

// check for errors
if ($htmlContent === false) {

    // handle the error
    $error = curl_error($curl);
    echo "curl error: " . $error;
    exit;
}

// print the HTML content
//echo $htmlContent;

// close cURL session
curl_close($curl);

$html = str_get_html($htmlContent);

$body = $html->find("body", 0);
$links = $body->find("a");
$targetLinks = array();

// this code find every blog that have مجلس word
$wordToFind = "مجلس";
$href = "";
foreach ($links as $link) {
    if (str_contains($link->href, $wordToFind)) {
        $MLink = $link->href;
        $targetLinks[] = "https://www.entekhab.ir" . $MLink;
    }
}

print_r($targetLinks);
//print_r($targetLinks);

//print_r($targetLinks);

foreach ($targetLinks as $link) {
    $htmlContents = str_get_html($link);

//    echo $link ."  <br>";
    if ($htmlContents === false) {
        echo $link . " This link not found.";
        continue;
    }
    $img = $htmlContents->find("img");
//    echo count($img);
}
//if (strpos($body, $wordToFind)) {
//    var_dump(strpos($body, $wordToFind));
//}
//
//// Count Images
//$image = $html->find("img");
//$imgCount = count($image);
//echo "$imgCount number of image";
//
//$html->find("title6");






