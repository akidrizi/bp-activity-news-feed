<?php 
namespace Conpress\Services\NewsFeed\Models\NewsSources;

use Conpress\Services\NewsFeed\Models\Feed;

class Kathimerini extends Feed {

    // Atom Feed
    const RSS_URI = 'http://www.kathimerini.gr/rss';
    const EXTRA_SOURCE_NAME = ' | Ημερήσια Πολιτική και Οικονομική Εφημερίδα';

    public function __construct($start_article = 0) {
        parent::__construct(self::RSS_URI, $start_article);
    }

    /**
     * Trim extra words added from the source to the source nme
     */
    public function get_news_source_name() {
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        $original_source_name = $this->feed_item->get_feed()->get_title();
        $original_source_name = str_replace(self::EXTRA_SOURCE_NAME, "",$original_source_name);

        return $original_source_name;
    }

    /**
     * Strips HTML tags for the description
     * 
     * @return string
     */
    public function get_description(){
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        return strip_tags($this->feed_item->get_description());
    }

}
