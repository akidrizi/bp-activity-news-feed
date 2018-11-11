<?php 
namespace Conpress\Services\NewsFeed\Models\NewsSources;

use Conpress\Services\NewsFeed\Models\Feed;

class Sport24 extends Feed {

    // Atom Feed
    const RSS_URI = 'https://www.sport24.gr/?widget=rssfeed&view=feed';

    public function __construct($start_article = 0) {
        parent::__construct(self::RSS_URI, $start_article);
    }



}
