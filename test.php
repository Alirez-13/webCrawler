<?php
function findWordInPage($url, $word)
{
    // Fetch the HTML content of the webpage
    $html = file_get_contents($url);

    // Check if the content was fetched successfully
    if ($html === false) {
        return false; // Could not fetch the page
    }
    // Check if the word exists in the HTML content
    return str_contains($html, $word);
}

function wordCounter($url, $word)
{
    $html = file_get_contents($url);

    if (findWordInPage($url, $word) !== false) {

    }
}

$url = "https://www.entekhab.ir";
$word = "مجلس";

?>
