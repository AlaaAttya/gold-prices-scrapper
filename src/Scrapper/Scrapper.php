<?php

/**
 * Scrapper
 *
 * @author Alaa Attya <alaa.attya91@gmail.com>
 */
class Scrapper {
    
    /**
     * @var string website url to be scrapped
     */
    private $_src_url;
    
    /**
     * @param string $src_url
     */
    public function __construct($src_url = null) {
        $this->_src_url = $src_url;
    }
    
    /**
     * Set source url
     * 
     * @param string $src_url
     * @return Scrapper
     */
    public function set_src_url($src_url) {
        $this->_src_url = $src_url;
        return $this;
    }
    
    /**
     * Get website html content as string
     * 
     * @return string html content of the page
     */
    public function get_page_content() {
        $ch = curl_init($this->_src_url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$htmlPage = curl_exec($ch);
	curl_close($ch);
        return $htmlPage;
    }
}
