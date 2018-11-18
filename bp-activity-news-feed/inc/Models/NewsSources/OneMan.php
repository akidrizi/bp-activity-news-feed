<?php 
namespace BP_NewsFeed\Models\NewsSources;

use BP_NewsFeed\Models\Feed;

class OneMan extends Feed {

    // Atom Feed
    const RSS_URI = 'https://www.oneman.gr/?widget=rssfeed&view=feed';

    public function __construct($start_article = 0) {
        parent::__construct(self::RSS_URI, $start_article);
    }



}
