<?php
namespace Conpress\Services\NewsFeed;

class Provider {

    const CONPRESS_DIR    = 'Conpress\\Services\\NewsFeed\\Models\\NewsSources\\';
    const DEFAULT_SOURCE  = 'Kathimerini';
    const NEWS_ACCOUNT_ID = 1;

    private $feed;
    private $news_source_name;

    public function __construct($news_source = '', $start_article) {
        $this->feed = $this->create_news_source($news_source, $start_article);
        $this->news_source_name = $this->feed->get_news_source_name();
    }

    /**
     * Creates the object of the given news source. If the given
     * name does not exists returns the Default source.
     * 
     * @param int $start_article: article pointer on the news feed
     * @return object
     */
    private function create_news_source($news_source, $start_article) {
        $class = self::CONPRESS_DIR.self::DEFAULT_SOURCE;

        if (class_exists(self::CONPRESS_DIR.$news_source)){
            $class = self::CONPRESS_DIR.$news_source;
        }

        return new $class($start_article);
    }

    /**
     * Creates the shortcode supported by plugin Buddypres Activity Plus
     * 
     * @return string
     */
    private function create_feed_element() {
        $url         = esc_url($this->feed->get_link());
        $title       = esc_attr($this->feed->get_title());
		$image       = esc_url($this->feed->get_attached_img());
        $description = esc_attr($this->feed->get_description());
        $source_name = $this->news_source_name;
        
		return "[bpfb_link url='{$url}' title='{$title} | {$source_name}' image='{$image}']{$description}[/bpfb_link]";
    }
    
    /**
     * Returns the array needed for [bp_activity_add] that adds 
     * the activity on the wall.
     * 
     * https://codex.buddypress.org/developer/function-examples/bp_activity_add/
     * 
     * @return array
     */
    public function get_news_feed(){
        return array(
            'user_id' => self::NEWS_ACCOUNT_ID,
            'action' => 'Νέα ενημερώσει από '.$this->news_source_name,
            'content' => $this->create_feed_element(),
            'component' => 'activity',
            'type' => 'activity_update',
        ); 
    }

}
