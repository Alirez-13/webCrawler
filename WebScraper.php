<?php
include_once("simple_html_dom.php");

class WebScraper
{

    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }


    public function scrape()
    {

        // initialize a cURL session
        $curl = curl_init();

        // set the website URL
        curl_setopt($curl, CURLOPT_URL, $this->url);

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

        curl_close($curl);
        // Extract the html content
        return str_get_html($htmlContent);
    }
}