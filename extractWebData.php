<?php

include_once('SaveWebContents.php');
include_once('WebScraper.php');
$url = 'https://www.entekhab.ir';
$webScraper = WebScraper::getInstance();
$html = $webScraper->scrape($url);

if ($html === false) {
    return false;
}
//$textContent = strip_tags($html);
$saveData = SaveWebContents::getInstance();

$subDomains = $html->find('a');

foreach ($subDomains as $link) {
    if (str_contains($link->href, '/fa/news/')) {
        $tempURL = 'https://www.entekhab.ir' . $link->href;
        $tempContent = $webScraper->scrape($tempURL);
        $tagsRemoved = strip_tags($tempContent);
        if ($saveData->savePageContent($tempURL, $tagsRemoved)) {
            echo $tempURL;
        }
    }
}

//$savedResult = $saveData->savePageContent($url, $textContent);
//
//if ($savedResult) {
//    echo "Saved";
//}

//$searchWord = '%مجلس%';
//$result = $saveData->searchPageContent($searchWord);
//print_r($result);
