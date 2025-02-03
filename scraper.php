<?php
include_once('WebScraper.php');
$url = 'https://www.entekhab.ir';
$word = 'مجلس';
$targetLinks = array();
$html = file_get_contents($url);

if (str_contains($html, $word)) {
    $targetLinks[] = $url;
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

    $subDomains = $htmlDOM->find('a');
    foreach ($subDomains as $link) {
        // Find all links
        if (str_contains($link->href, '/fa/news/')) {
            $tempURL = 'https://www.entekhab.ir' . $link->href;

            $tempContent = $webScraper->scrape($tempURL);
            $tagsRemoved = strip_tags($tempContent);

            if (str_contains($tagsRemoved, $word)) {
                // Append base domain to sub
                print_r($tempURL);
            }
        }
    }

//    var_dump($targetLinks);

//    $finalLinks = array();
//    foreach ($targetLinks as $key => $link) {
//        // Extract HTML
//        $content = $webScraper->scrape($link);
//        $removedTag = strip_tags($content);
//
//        if (str_contains($removedTag, $word)) {
////            echo str_word_count($content);
////            echo "<br>";
////            echo count($content->find("img"));
//            $finalLinks[] = $link;
//
//        }
//    }
//    var_dump($finalLinks);

}




