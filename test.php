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
        $targetLinks[] = "https://www.entekhab.ir" . $link->href;
    }

}




