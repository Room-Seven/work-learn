<?php
/**
 * @package		SITE
 * @author		Ron Tayler
 * @copyright	2020
 */

/**
 * Document class
 */
class Document {
	private $title;
	private $description;
	private $keywords;
    private $header;
    private $content;
    private $footer;
    private $meta_tags = array();
	private $links = array();
	private $styles = array();
	private $scripts = array();
	private $script_code = array();

	/**
     * setTitle
     * @param	string	$title
     */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
     * getTitle
	 * @return	string
     */
	public function getTitle() {
		return $this->title;
	}

	/**
     * setDescription
     * @param	string	$description
     */
	public function setDescription($description) {
		$this->description = $description;
	}

    /**
     * getDescription
     * @return    string
     */
	public function getDescription() {
		return $this->description;
	}

	/**
     * setKeywords
     * @param	string	$keywords
     */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
     * getKeywords
	 * @return	string
     */
	public function getKeywords() {
		return $this->keywords;
	}
	
	/**
     * addLink
     * @param	string	$href
	 * @param	string	$rel
     */
	public function addLink($href, $rel) {
		$this->links[$href] = array(
			'href' => $href,
			'rel'  => $rel
		);
	}

	/**
     * getLinks
	 * @return	array
     */
	public function getLinks() {
		return $this->links;
	}

    /**
     * addMetaTag
     * @param	array	$param
     */
    public function addMetaTag($param) {
        $this->meta_tags[] = $param;
    }

    /**
     * getMetaTags
     * @return	array
     */
    public function getMetaTags() {
        return $this->meta_tags;
    }

	/**
     * addStyle
     * @param	string	$href
	 * @param	string	$rel
	 * @param	string	$media
     */
	public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
		$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		);
	}

	/**
     * getStyles
	 * @return	array
     */
	public function getStyles() {
		return $this->styles;
	}

	/**
     * addScript
     * @param	string	$href
	 * @param	string	$position
     */
	public function addScript($href, $position = 'header') {
		$this->scripts[$position][$href] = $href;
	}

	/**
     * getScripts
     * @param	string	$position
	 * @return	array
     */
	public function getScripts($position = 'header') {
		if (isset($this->scripts[$position])) {
			return $this->scripts[$position];
		} else {
			return array();
		}
	}

    /**
     * addScriptCode
     * @param	string	$code
     * @param	string	$position
     */
    public function addScriptCode($code, $position = 'header') {
        $this->script_code[$position][] = $code;
    }

    /**
     * getScriptsCode
     * @param	string	$position
     * @return	array
     */
    public function getScriptsCode($position = 'header') {
        if (isset($this->script_code[$position])) {
            return $this->script_code[$position];
        } else {
            return array();
        }
    }

    /**
     * setHeader
     * @param	string	$header
     */
    public function setHeader($header) {
        $this->header = $header;
    }

    /**
     * getHeader
     * @return	string
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * setContent
     * @param	string	$content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * getContent
     * @return	string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * setFooter
     * @param	string	$footer
     */
    public function setFooter($footer) {
        $this->footer = $footer;
    }

    /**
     * getFooter
     * @return	string
     */
    public function getFooter() {
        return $this->footer;
    }

}