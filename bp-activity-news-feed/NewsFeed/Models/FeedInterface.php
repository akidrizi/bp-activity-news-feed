<?php
namespace Conpress\Services\NewsFeed\Models;

interface FeedInterface {

    /**
     * Returns the title of the news source.
     * 
     * @return string
     */
    public function get_news_source_name();

    /**
     * Returns the feed title
     * 
     * @return string
     */
    public function get_title();

    /**
     * Returns the feed description
     * 
     * @return string
     */
    public function get_description();

    /**
     * Returns the feed link
     * 
     * @return string
     */
    public function get_link();

    /**
     * Returns the feed title
     * 
     * @return string
     */
    public function get_attached_img();

}
