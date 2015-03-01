<?php
/**
 * Encapselation for a blog post.
 *
 * @todo maybe change the name of asso_array
 */

class BlogPost
{
    protected $id = null;
    protected $title = null;
    protected $subtitle = null;
    protected $author = null;
    protected $pub_date = null;
    protected $mod_date = null;
    protected $excerpt = null;
    protected $content = null;
    protected $keywords = null;
    protected $tags = null;
    protected $category = null;

    /**
     * The BlogPost Constructor
     *
     * Takes an associative array with each key being a BlogPost
     * property (i.e. title, author, etc) with it's corresponding
     * value. For each key that that is a class property the
     * constructor sets that key's value to the object's property
     * value.
     *
     * @param array $asso_array An associative array with key/value
     * pairs representing attributes of a blog post.
     */
    public function __construct($asso_array) {
        foreach ($asso_array as $attrib => $value) {
            switch($attrib) {
            case 'id':
                $this->set_id($value);
                break;
            case 'title':
                $this->set_title($value);
                break;
            case 'subtitle':
                $this->set_subtitle($value);
                break;
            case 'author':
                $this->set_author($value);
                break;
            case 'pub_date':
                $this->set_pub_date(new DateTime($value));
                break;
            case 'mod_date':
                $this->set_mod_date(new DateTime($value));
                break;
            case 'excerpt':
                $this->set_excerpt($value);
                break;
            case 'content':
                $this->set_content($value);
                break;
            case 'keywords':
                $this->set_keywords($value);
                break;
            case 'tags':
                $this->set_tags($value);
                break;
            case 'category':
                $this->set_category($value);
                break;
            }
        }
    }

    public function __toString() {
        $string = "";
        if ($this->id) $string .= "id='$this->id',";
        if ($this->title) $string .= "title='$this->title',";
        if ($this->subtitle) $string .= "subtitle='$this->subtitle',";
        if ($this->author) $string .= "author='$this->author',";
        if ($this->pub_date) $string .= "pub_date='$this->pub_date',";
        if ($this->mod_date) $string .= "mod_date='$this->mod_date',";
        if ($this->excerpt) $string .= "excerpt='$this->excerpt',";
        if ($this->content) $string .= "content='$this->content',";
        if ($this->tags) $string .= "tags='$this->tags',";
        if ($this->category) $string .= "category='$this->category',";
        return $string;
    }

    public function toHTML() {
        $html  = '<article class=\"blog-post\">';
        $html .= "\n<header>";
        $html .= "\n<h1>".$this->get_title()."</h1>";
        $html .= "\n<h2>".$this->get_subtitle()."</h2>";
        $html .= "\n<span class=\"timestamp\">".$this->get_pub_date()."</span>";
        $html .= "\n</header>";
        $html .= "\n".$this->get_content()."<br>";
        $html .= "\n<p class=\"details\">
                  <span class=\"glyphicon glyphicon-bookmark\"></span>
                  <span class=\"cat\"> category: ".$this->get_category()."</span>
                  <span class=\"glyphicon glyphicon-tags\"></span>
                  <span class=\"tags\">tags: ".$this->get_tags()."</span></p>";
        $html .= '</article>';
        return $html;
    }

    public function set_id($x) {
        $this->id = $x;
    }

    public function set_title($x) {
        $this->title = $x;
    }

    public function set_subtitle($x) {
        $this->subtitle = $x;
    }

    public function set_author($x) {
        $this->author = $x;
    }

    public function set_pub_date($x) {
        $this->pub_date = $x;
    }

    public function set_mod_date($x) {
        $this->mod_date = $x;
    }

    public function set_excerpt($x) {
        $this->excerpt = $x;
    }

    public function set_content($x) {
        $this->content = $x;
    }

    public function set_keywords($x) {
        $this->keywords = $x;
    }

    public function set_tags($x) {
        $this->tags = $x;
    }

    public function set_category($x) {
        $this->category = $x;
    }

    public function get_id() {
        return $this->gerial;
    }

    public function get_title() {
        return $this->title;
    }

    public function get_subtitle() {
        return $this->subtitle;
    }

    public function get_author() {
        return $this->author;
    }

    public function get_pub_date() {
        if (!defined('PUBDATE_FORMAT')) return "PUBDATE FORMAT NOT DEFINED";
        else return $this->pub_date->format(PUBDATE_FORMAT);
    }

    public function get_mod_date() {
        if (!defined('MODDATE_FORMAT')) return "MODDATE FORMAT NOT DEFINED";
        return $this->mod_date->format(MODDATE_FORMAT);
    }

    public function get_excerpt() {
        return $this->excerpt;
    }

    public function get_content() {
        return $this->content;
    }

    public function get_keywords() {
        return $this->keywords;
    }

    public function get_tags() {
        return $this->tags;
    }

    public function get_category() {
        return $this->category;
    }
}

