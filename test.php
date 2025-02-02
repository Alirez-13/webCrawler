<?php
include_once("WebScraper.php");
$url = "https://www.entekhab.ir";
$word = "مجلس";

$html = file_get_contents($url);

if (str_contains($html, $word)) {

    if ($html === false) {
        return false;
    }
    // Remove html tag
    $text = strip_tags($html);

    $word_counter = str_word_count($html);

    $myWord = str_word_count($word);

    $webScraper = WebScraper::getInstance();
    $htmlDOM = $webScraper->scrape($url);

    // Find img tag in html
    $numberOfImg = $htmlDOM->find("img");

    $targetLinks = array();

    $subDomains = $htmlDOM->find("a");
    foreach ($subDomains as $link) {
        // Find all links and add main base domain to fist of subDomain
        if (str_contains($link->href, "/fa/news")) {
            // Append base domain to sub
            $targetLinks[] = "https://www.entekhab.ir" . $link->href;
        }
    }

    echo count($targetLinks) . "<br>";
    $finalLinks = array();
    foreach ($targetLinks as $key => $link) {
        // Extract HTML
        $content = $webScraper->scrape($link);
        $removedTag = strip_tags($content);

        if (stripos($removedTag, $word)) {
            echo str_word_count($content);
            echo "<br>";
            echo count($content->find("img"));
            $finalLinks[] = $link;

        }
    }
//    print_r($finalLinks);

}




