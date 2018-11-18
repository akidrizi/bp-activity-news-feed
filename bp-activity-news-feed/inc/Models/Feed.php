<?php
namespace BP_NewsFeed\Models;

abstract class Feed implements FeedInterface {

    const CONPRESS_DIR = 'Conpress\\Services\\NewsFeed\Models\\NewsSources\\';

    protected $feed;
    protected $feed_item;
    protected $error_msg;
    protected $source_name;

    public function __construct($rss_stream_uri = '', $start_article = 0) {
        $this->feed = fetch_feed($rss_stream_uri);

        $this->init_error_message();

        /**
         * Gathers one single item. We may also get the all items based
         * by the following documentation:
         * 
         * http://simplepie.org/wiki/reference/simplepie_item/get_feed
         */
        if(!is_wp_error( $this->feed ))
            $this->feed_item = $this->feed->get_items($start_article, 1)[0];

    }

    /**
     * Creates the error message that will be displayed when the news
     * source is not feeding data.
     */
    private function init_error_message() {
        $this->source_name = str_replace(self::CONPRESS_DIR, "", get_class($this));
        $this->error_msg = $this->source_name.' '.__('not responding', 'thrive-child');
    }

    /**
     * Remote page retrieving routine.
     *
     * @param string Remote URL
     * @return mixed Remote page as string, or (bool)false on failure
     */
    private function get_page_contents($url) {
        $response = wp_remote_get($url);

        if (is_wp_error($response)) 
            return false;

        return $response['body'];
    }

    /**
     * Gets the src:URL of all the images inside the page
     * and return the first one found
     * 
     * @param string Remote URL
     * @return string
     */
    private function get_page_image_url($url) {
        $page = $this->get_page_contents($url);

        if ($page === false)
            return '';

		if (!function_exists('str_get_html')) require_once(BPFB_PLUGIN_BASE_DIR . '/lib/external/simple_html_dom.php');
		$html = str_get_html($page);

        $images = array();
        $image_elements = $html->find('img');

        foreach ($image_elements as $element) {
            if ($element->width > 100 && $element->height > 1) // Disregard spacers
                $images[] = esc_url($element->src);
        }

        $og_image = $html->find('meta[property=og:image]', 0);
        if ($og_image) 
            array_unshift($images, esc_url($og_image->content));

        $images = array_filter($images);
            
        if ($images)
            return $images[0];

        return '';
    }

    /**
     * Returns the title of the news source.
     * 
     * @return string
     */
    public function get_news_source_name() {
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        return $this->feed_item->get_feed()->get_title();
    }

    /**
     * Returns the feed title
     * 
     * @return string
     */
    public function get_title(){
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        return $this->feed_item->get_title();
    }

    /**
     * Returns the feed description
     * 
     * @return string
     */
    public function get_description(){
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        return $this->feed_item->get_description();
    }

    /**
     * Returns the feed link
     * 
     * @return string
     */
    public function get_link(){
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        return $this->feed_item->get_permalink();
    }

    /**
     * Returns the feed title
     * 
     * @return string
     */
    public function get_attached_img() {
        if (is_wp_error( $this->feed ))
            return $this->error_msg;

        return $this->get_page_image_url($this->get_link());
    }

}
