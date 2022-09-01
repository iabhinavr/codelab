<?php

$url = "https://www.coralnodes.com/feed/";

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

$res = curl_exec($handle);

curl_close($handle);

$feed = new SimpleXMLElement($res);

$sitemap = new SimpleXMLElement('<urlset></urlset>');

$sitemap->addAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");
$sitemap->addAttribute("xmlns:xhtml", "http://www.w3.org/1999/xhtml");

foreach($feed->channel->item as $item) {
    $url = $sitemap->addChild("url");
    $url->addChild("loc", $item->link);
    $url->addChild("changefreq", "monthly");
}

$saved_sitemap = $sitemap->asXML();
file_put_contents("sitemap.xml", $saved_sitemap);