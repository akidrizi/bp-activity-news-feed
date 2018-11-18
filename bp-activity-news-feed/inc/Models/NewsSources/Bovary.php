<?php
namespace BP_NewsFeed\Models\NewsSources;

use BP_NewsFeed\Models\Feed;

class Bovary extends Feed {

    // RSS 2.0 Feed
    const RSS_URI = 'http://www.bovary.gr/rss.xml';

    public function __construct($start_article = 0) {
        parent::__construct(self::RSS_URI, $start_article);
    }


    /**
     * Manipulates HTML Data from RSS feed and isolates head from description.
     * Returns the text (if exist) of the isolated elements combined else NULL
     * 
     * @return string|null
     */
    private function strip_head_and_paragraph_tags($HTML_string) {
        $document = new \DOMDocument();
        $document->loadHTML(mb_convert_encoding($HTML_string, 'HTML-ENTITIES', 'UTF-8'));

        $header      = $document->getElementsByTagName('div')[0];
        $paragraph   = $document->getElementsByTagName('p')[0];
        $description = null; 
        
        if (isset($header) && isset($paragraph)){
            $header      = $header->textContent;
            $paragraph   = $paragraph->textContent;
            $description = $header.' - '.$paragraph; 
        }
            

        return $description;
    }

    /**
     * Fixes description spaces and returns it in correct form
     * 
     * @return string
     */
    public function get_description(){
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        $description = $this->feed_item->get_description();
        $bovary_description = $this->strip_head_and_paragraph_tags($description);

        if ( $bovary_description !== null )
            return $bovary_description;

        return strip_tags($description);
    }

}
