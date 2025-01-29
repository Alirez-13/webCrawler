<?php
//require 'vendor/autoload.php';
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
$wordToFind = "مجلس";
$links = $body->find("a");
$targetLinks = [];
// this code find every blog that have مجلس word
foreach ($links as $link) {
    if (str_contains($link->innertext, $wordToFind)) {
        $href = $link->href;
//        echo $href;
//        echo "<br>";
        // Links that have مجلس word in it
        $targetLinks = saveAfterSubstring($href, "/fa/news/");
//        echo $link->innertext;
    }
}

function saveAfterSubstring($string, $substring)
{
    $position = strpos($string, $substring);

    if ($position !== false) {

        $result = substr($string, $position);

        return [$result];
    }
    // If the substring is not found, return an empty array
    return [];
}

function prependToArray($array, $stringToPrepend)
{
    // Use array_map to prepend the string to each element
    return array_map(function ($item) use ($stringToPrepend) {
        return $stringToPrepend . $item;
    }, $array);
}

$urlToAppend = "https://www.entekhab.ir";
$targetLinks = prependToArray($targetLinks, $urlToAppend);
foreach ($targetLinks as $link) {
    $htmlsContent = str_get_html($link);

    echo $link;
    if ($htmlsContent === false) {
        echo $link . " This link not found.";
        continue;
    }
    $img = $htmlsContent->find("img");
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






