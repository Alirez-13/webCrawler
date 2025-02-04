<?php
include_once('SaveWebContents.php');
include_once('WebScraper.php');
include_once('simple_html_dom.php');

$url = 'https://www.entekhab.ir';

$webScraper = WebScraper::getInstance();
$html = $webScraper->scrape($url);

if ($html === false) {
    return false;
}

$saveData = SaveWebContents::getInstance();
$html = str_get_html($html);
$subDomains = $html->find('a');
$tempURL = array();

foreach ($subDomains as $link) {
    if (str_contains($link->href, '/fa/news/')) {
        $tempURL[] = 'https://www.entekhab.ir' . $link->href;
    }
}

$removedDuplicationUrl = array_unique($tempURL);

foreach ($removedDuplicationUrl as $uniqueUrl) {

    $tempContent = $webScraper->scrape($uniqueUrl);

    $cleaned_string = preg_replace('/<[^>]+>/', '', $tempContent);

    if ($saveData->savePageContent($uniqueUrl, $cleaned_string)) {
        print "Added successfully" . '<br>';
    }
}
