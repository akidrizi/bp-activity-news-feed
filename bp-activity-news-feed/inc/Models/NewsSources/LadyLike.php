<?php 
namespace BP_NewsFeed\Models\NewsSources;

use BP_NewsFeed\Models\Feed;

class LadyLike extends Feed {

    // Atom Feed
    const RSS_URI = 'https://www.ladylike.gr/?widget=rssfeed&view=feed&contentId=1309649';

    // They are morons and tend to Feed the website with placeholder posts
    // that are being pulled from the RSS Feed. Third Article seems to be safe
    public function __construct($start_article = 0) {
        parent::__construct(self::RSS_URI, $start_article);
    }



}
