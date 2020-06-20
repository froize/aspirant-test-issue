<?php


class RssParser
{
    public function __construct()
    {
        $html = array();
        // URL containing rss feed
        $url = "https://trailers.apple.com/trailers/home/rss/newtrailers.rss";
        $xml = simplexml_load_file($url);
        for ($i = 0; $i < 10; $i++) {

            $title = $xml->channel->item[$i]->title;
            $link = $xml->channel->item[$i]->link;
            $description = $xml->channel->item[$i]->description;
            $pubDate = $xml->channel->item[$i]->pubDate;
            $html[$i]['title'] = $title;
            $html[$i]['link'] = $link;
            $html[$i]['description'] = $description;
            $html[$i]['pubDate'] = $pubDate;

        }
        return $html;

    }
}